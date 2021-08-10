<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Product;
use App\Category;
use App\Customer;
use App\Province;

class FrontController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->limit(8)
            ->get();



        return view('front.index', compact('products'));
    }

    public function getProduct()
    {
        $product = Product::where('id', request()->id)->first();
        return response()->json(['product' => $product]);
    }

    public function product()
    {
        $products = Product::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(12);



        return view('front.product', compact('products'));
    }

    public function CategoryProduct($slug)
    {
        if (Category::whereSlug($slug)->exists()) {
            $products = Category::where('slug', $slug)->first()
                ->product()->orderBy('created_at', 'DESC')
                ->paginate(12);
            return view('front.product', compact('products'));
        }

        return redirect(route('front.product'));
    }

    public function show($slug)
    {
        $product = Product::with(['category'])->where('slug', $slug)->first();

        $related = Product::where('id', '!=', $product->id)
            ->where('category_id', '=', $product->category_id)
            ->limit(4)
            ->get();

        return view("front.detail_product", compact('product', 'related'));
    }

    public function settingForm()
    {
        $customer  = auth()->user()->customer->load('district');
        $provinces = Province::orderBy('name', 'ASC')->get();

        return view('front.setting', compact('customer', 'provinces'));
    }

    public function customerUpdateProfile(Request $req)
    {
        $this->validate($req, [
            'name'          => 'required|string|max:100',
            'phone_number'  => 'required|max:15',
            'address'       => 'required|string',
            'district_id'   => 'required|exists:districts,id',
            'password'      => 'nullable|string|min:8',
        ]);

        try {
            $user = auth()->user();
            $pw   = !empty($req->password) ? bcrypt($req->password) : $user->password;

            Customer::where('id', $user->customer->id)->update([
                'name'         => $req->name,
                'phone_number' => $req->phone_number,
                'address'      => $req->address,
                'district_id'  => $req->district_id
            ]);

            $user->update(['password' => $pw]);

            return back()->with('success', 'Data Berhasil Diperbarui');
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
