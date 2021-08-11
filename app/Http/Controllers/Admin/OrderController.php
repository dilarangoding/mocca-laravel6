<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\OrderMail;
use Mail;

// Models

use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(["customer.district.city.province"])
            ->withCount(['return'])
            ->orderBy('created_at', 'DESC');

        if (request()->q != '') {
            $orders = $orders->where(function ($q) {
                $q->where('customer_name', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('invoice', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('customer_address', 'LIKE', '%' . request()->q . '%');
            });
        }

        if (request()->status != '') {
            $orders = $orders->where('status', 'LIKE', '%' . request()->status . '%');
        }

        $orders = $orders->paginate(10);
        return view("admin.orders.index", compact('orders'));
    }

    public function detail($invoice)
    {
        $order = Order::with(['customer.district.city.province', 'payment', 'orderDetail.product'])
            ->where('invoice', $invoice)->first();

        return view('admin.orders.detail', compact('order'));
    }

    public function acceptPayment($id)
    {
        $order = Order::with(['payment'])->where('id', $id)->first();
        $order->payment()->update(['status' => 1]);
        $order->update(['status' => 2]);

        return redirect(route('orders.detail', $order->invoice))->with('success', 'Berhasil Menerima Pesanan');
    }

    public function shippingOrder(Request $req)
    {
        $this->validate($req, [
            'tracking_number' => 'required',
        ]);

        $order = Order::with(['customer'])->find($req->order_id);

        $order->update([
            'tracking_number' => $req->tracking_number,
            'status'          => 3
        ]);

        Mail::to($order->customer->user->email)->send(new OrderMail($order));

        return back()->with('success', 'Berhasil mengirim resi');
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->orderDetail()->delete();
        $order->payment()->delete();
        $order->delete();

        return back()->with('success', 'Data Berhasil dihapus');
    }

    public function return($invoice)
    {
        $order = Order::with(['return', 'customer'])->where('invoice', $invoice)->first();

        return view('admin.orders.return', compact('order'));
    }

    public function approveReturn(Request $req)
    {
        $this->validate($req, [
            'status' => 'required',
        ]);

        $order = Order::find($req->order_id);

        $order->return()->update([
            'status'  => $req->status
        ]);
        $order->update(['status' => 4]);

        return back()->with('success', 'Berhasil');
    }
}
