<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use DB;

// models
use App\Product;
use App\Category;


class ProductController extends Controller
{

    public function index()
    {

        $product = Product::with('category')->orderBy('created_at', 'DESC');
        if (request()->q != '') {
            $product = $product->where('name', 'LIKE', '%' . request()->q . '%');
        }

        $product = $product->paginate(10);

        return view('admin.products.index', compact('product'));
    }


    public function create()
    {
        $category = Category::orderBy('created_at', 'DESC')->get();
        return view('admin.products.create', compact('category'));
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'name'         => 'required|string|max:100',
            'description'  => 'required',
            'category_id'  => 'required|exists:categories,id',
            'price'        => 'required|integer',
            'weight'       => 'required|integer',
            'status'       => 'required',
            'image'        => 'required|image|mimes:png,jpg, jpeg',
        ]);

        if ($req->hasFile('image')) {
            $file     = $req->file('image');
            $filename = time() . Str::slug($req->name) . '.' . $file->getClientOriginalExtension();
            $file->move('asset/produk', $filename);

            Product::updateOrCreate([
                'name'        => $req->name,
                'slug'        => $req->name,
                'category_id' => $req->category_id,
                'description' => $req->description,
                'image'       => $filename,
                'price'       => $req->price,
                'weight'      => $req->weight,
                'status'      => $req->status,
            ]);

            return redirect(route('product.index'))->with("success", "Berhasil menambah data");
        }
    }


    public function show()
    {
        $product = Product::where('id', request()->id)->first();
        $category = Category::where('id', $product->category_id)->first();
        return response()->json(['product' => $product, 'category' => $category]);
    }


    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::orderBy("name", "ASC")->get();

        return view('admin.products.edit', compact('product', 'category'));
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'name'         => 'required|string|max:100',
            'description'  => 'required',
            'category_id'  => 'required|exists:categories,id',
            'price'        => 'required|integer',
            'weight'       => 'required|integer',
            'status'       => 'required',
            'image'        => 'nullable|image|mimes:png,jpg, jpeg',
        ]);

        $product = Product::find($id);
        $filename = $product->image;

        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $filename = time() . Str::slug($req->name) . '.' . $file->getClientOriginalExtension();
            $file->move('asset/produk', $filename);
            File::delete('asset/produk/' . $product->image);
        }

        $product->update([
            'name'        => $req->name,
            'slug'        => $req->name,
            'category_id' => $req->category_id,
            'description' => $req->description,
            'image'       => $filename,
            'price'       => $req->price,
            'weight'      => $req->weight,
            'status'      => $req->status,
        ]);

        return redirect(route('product.index'))->with('succes', 'Berhasil mengedit data');
    }


    public function destroy($id)
    {
        $product  = Product::find($id);
        File::delete('asset/produk/' . $product->image);
        $product->delete();

        return back()->with('success', 'Berhasil menghapus data');
    }
}
