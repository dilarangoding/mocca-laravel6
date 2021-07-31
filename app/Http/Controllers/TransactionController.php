<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\TransactionConfirmMail;
use Mail;
use DB;
// Models

use App\Product;
use App\Province;
use App\City;
use App\Customer;
use App\District;
use App\OrderDetail;
use App\Order;

class TransactionController extends Controller
{

    public function getCarts()
    {
        $carts = json_decode(request()->cookie('mocca-carts'), true);
        $carts = $carts != '' ? $carts : [];

        return $carts;
    }

    public function getSubtotal()
    {
        $carts = $this->getCarts();
        $subtotal = collect($carts)->sum(function ($i) {
            return $i['product_price'] * $i['qty'];
        });

        return $subtotal;
    }

    public function addToCart(Request $req)
    {
        $this->validate($req, [
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer'
        ]);

        $carts = $this->getCarts();

        if ($carts && array_key_exists($req->product_id, $carts)) {
            $carts[$req->product_id]['qty'] += $req->qty;
        } else {
            $product = Product::find($req->product_id);

            // membuat array dengan product_id sebagai key nya
            $carts[$product->id] = [
                'qty'           => $req->qty,
                'product_id'    => $product->id,
                'product_name'  => $product->name,
                'product_slug'  => $product->slug,
                'product_price' => $product->price,
                'product_image' => $product->image,
            ];
        }

        $cookie = cookie('mocca-carts', json_encode($carts), 2880);

        return back()->cookie($cookie)->with('success', 'Berhasil menambah produk ke keranjang');
    }

    public function listCart()
    {
        $carts = $this->getCarts();
        $subtotal = $this->getSubtotal();

        return view('front.list_cart', compact('carts', 'subtotal'));
    }

    public function updateCart(Request $req)
    {

        $carts = $this->getCarts();

        foreach ($req->product_id as $key => $value) {
            if ($req->qty[$key] == 0) {
                unset($carts[$value]);
            } else {
                $carts[$value]['qty'] = $req->qty[$key];
            }
        }

        $cookie = cookie('mocca-carts', json_encode($carts), 2880);

        return back()->cookie($cookie)->with('success', 'Berhasil Memperbaharui Keranjang ');
    }

    public function deleteCart($id)
    {

        if (Product::where('id', $id)->exists()) {

            $carts = $this->getCarts();
            unset($carts[$id]);

            $cookie = cookie('mocca-carts', json_encode($carts), 2880);
            return back()->cookie($cookie)->with('success', 'Berhasil Memperbaharui Keranjang ');
        }

        return back();
    }

    public function checkout()
    {
        if (auth()->check()) {
            $provinces = Province::orderBy('created_at', 'DESC')->get();
            $carts     = $this->getCarts();
            $subtotal  = $this->getSubtotal();

            return view('front.checkout', compact('provinces', 'carts', 'subtotal'));
        }

        return back()->with('error', 'Silahkan Login Terlebih Dahulu');
    }
    public function getCity()
    {
        $city = City::where('province_id', request()->province_id)
            ->orderBy('type', 'ASC')
            ->get();
        return response()->json(['status' => 'success', 'data' => $city]);
    }
    public function getDistrict()
    {
        $district = District::where('city_id', request()->city_id)
            ->orderBy('name', 'ASC')
            ->get();
        return response()->json(['status' => 'success', 'data' => $district]);
    }

    public function prosesCheckout(Request $req)
    {
        $this->validate($req, [
            'customer_name'    => 'required|string|max:100',
            'customer_phone'   => 'required|exists:customers,phone_number',
            'email'            => 'required|email',
            'customer_address' => 'required|string',
            'province_id'      => 'required|exists:provinces,id',
            'city_id'          => 'required|exists:cities,id',
            'district_id'      => 'required|exists:districts,id'
        ]);

        DB::beginTransaction();
        try {

            if (!auth()->check()) {
                return back()->with('error', 'Silahkan Login Terlebih dahulu');
            }

            $carts    = $this->getCarts();
            $subtotal = $this->getSubtotal();

            $customer = Customer::find(auth()->user()->customer->id);
            if ($customer->status == false) {
                $customer->update([
                    'address'     => $req->customer_address,
                    'district_id' => $req->district_id,
                    'status'      => true,
                ]);
            }

            $order = Order::create([
                'invoice'          => Str::random(4) . '-' . time(),
                'customer_id'      => $customer->id,
                'customer_name'    => $req->customer_name,
                'customer_phone'   => $req->customer_phone,
                'customer_address' => $req->customer_address,
                'district_id'      => $req->district_id,
                'subtotal'         => $subtotal
            ]);

            foreach ($carts  as $item) {
                $product = Product::find($item['product_id']);
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'price'      => $item['product_price'],
                    'qty'        => $item['qty'],
                    'weight'     => $product->weight
                ]);
            }

            DB::commit();

            $carts = [];
            $cookie = cookie('mocca-carts', json_encode($carts), 2880);

            Mail::to($req->email)->send(new TransactionConfirmMail($order->invoice));
            return redirect(route('front.finish_checkout', $order->invoice))->cookie($cookie);
        } catch (\Exception $th) {
            DB::rollback();
            return back()->with('error', $th->getMessage());
        }
    }

    public function checkoutFinish($invoice)
    {
        if (Order::where('invoice', $invoice)->exists()) {

            $order = Order::with(['orderDetail.product'])->where('invoice', $invoice)->first();

            return view('front.checkout_finish', compact('order'));
        }

        return back();
    }
}
