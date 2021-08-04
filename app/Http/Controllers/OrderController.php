<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// models

use App\Order;
use App\Payment;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', auth()->user()->customer->id)
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

            if ($req->amount < $order->subtotal) {
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
}
