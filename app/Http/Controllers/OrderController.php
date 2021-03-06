<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
// models

use App\Order;
use App\OrderReturn;
use App\Payment;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withCount(['return'])->where('customer_id', auth()->user()->customer->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('customer.order', compact('orders'));
    }

    public function detailOrder($invoice)
    {
        if (Order::where('invoice', $invoice)->exists()) {
            $order = Order::with(['district.city.province', 'orderDetail', 'orderDetail.product', 'payment'])->where('invoice', $invoice)->first();
            return view('customer.detail', compact('order'));
        }
    }

    public function payment()
    {
        $cekInvoice = Order::where('invoice', request()->invoice)->exists();
        $cekUser = Order::where('invoice', '=', request()->invoice)
            ->where('customer_id', auth()->user()->customer->id)
            ->count();

        if ($cekInvoice != 0 && $cekUser != 0) {
            return view("customer.payment");
        }

        return back();
    }

    public function paymentStore(Request $req)
    {
        $this->validate($req, [
            'invoice'       => 'required|exists:orders,invoice',
            'name'          => 'required|string',
            'transfer_to'   => 'required|string',
            'transfer_date' => 'required',
            'amount'        => 'required|integer',
            'proof'         => 'required|image|mimes:jpg,png,jpeg'
        ]);

        DB::beginTransaction();
        try {

            $order = Order::where('invoice', $req->invoice)->first();

            if ($req->amount != $order->subtotal) {
                return back()->with('error', 'Jumlah Transfer Kurang Dari Tagihan Pemesanan');
            }

            if ($order->status == 0 && $req->hasFile('proof')) {
                $file = $req->file('proof');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('asset/payment', $filename);


                Payment::create([
                    'order_id'      => $order->id,
                    'name'          => $req->name,
                    'transfer_to'   => $req->transfer_to,
                    'transfer_date' => Carbon::parse($req->tranfer_date)->format('Y-m-d'),
                    'amount'        => $req->amount,
                    'proof'         => $filename,
                    'status'        => false,
                ]);

                $order->update(['status' => 1]);
                DB::commit();

                return back()->with("success", "Pesanan Dikonfirmasi");
            }
        } catch (\Exception $th) {
            DB::rollback();
            return back()->with('error', $th->getMessage());
        }
    }

    public function acceptOrder(Request $req)
    {
        $order = Order::find($req->order_id);
        if ($order->where("customer_id", auth()->user()->customer->id)->exists()) {
            $order->update(['status' => 4]);

            return back()->with('success', 'Pesanan Anda Selesai');
        }

        return back()->with('error', 'Bukan Pesanan Anda');
    }

    public function returnForm($invoice)
    {
        $order = Order::where('invoice', $invoice)
            ->where('customer_id', Auth::user()->customer->id)
            ->first();

        return view('customer.return', compact('order'));
    }

    public function proccessReturn(Request $req, $id)
    {
        $this->validate($req, [
            'reason'           => 'required|string',
            'refund_transfer'  => 'required|string',
            'photo'            => 'required|image|mimes:png, jpg, jpeg',
        ]);

        $returnOrder = OrderReturn::where('order_id', $id)->first();

        if ($returnOrder) return back()->with('error', 'Permintaan Refund Dalam Prosses');

        if ($req->hasFile('photo')) {
            $file     = $req->file('photo');
            $filename = time() . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move('asset/return', $filename);

            OrderReturn::create([
                'order_id'        => $id,
                'photo'           => $filename,
                'reason'          => $req->reason,
                'refund_transfer' => $req->refund_transfer,
                'status'          => 0,
            ]);

            $order = Order::find($id);

            $this->sendMessage('#' . $order->invoice, $req->reason);

            return back()->with('success', 'Permintan Refund Pesanan Berhasil Dikirim');
        }
    }

    private function getTelegram($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . $params);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $content = curl_exec($ch);
        curl_close($ch);
        return json_decode($content, true);
    }

    private function sendMessage($invoice, $reason)
    {

        $key = env('TELEGRAM_KEY');

        $chat = $this->getTelegram('https://api.telegram.org/' . $key . '/getUpdates', '');
        if ($chat['ok']) {
            $chat_id = $chat['result'][0]['message']['chat']['id'];
            $text = "Hai Mocca.id ada yang return barang nih segera dicek ya!";
            $chat = $this->getTelegram('https://api.telegram.org/' . $key . '/getUpdates', '');
            return  $this->getTelegram('https://api.telegram.org/' . $key . '/sendMessage', '?chat_id=' . $chat_id . '&text=' . $text);
        }
    }
}
