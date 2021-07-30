<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Product;
use App\Category;


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
}
