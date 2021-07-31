<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models

use App\Product;

class TransactionController extends Controller
{

    public function getCarts()
    {
        $carts = json_decode(request()->cookie('mocca-carts'), true);
        $carts = $carts != '' ? $carts : [];

        return $carts;
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

        $subtotal = collect($carts)->sum(function ($i) {
            return $i['product_price'] * $i['qty'];
        });

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
}
