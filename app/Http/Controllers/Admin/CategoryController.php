<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {

        $category = Category::with(['parent'])->orderBy('created_at')->paginate(5);

        $parent = Category::getParent()->orderBy('name', 'ASC')->get();

        return view('admin.category.index', compact('category', 'parent'));
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'name' => 'required|string|max:100|unique:categories'
        ]);

        $req->request->add(['slug' => $req->name]);
        Category::create($req->except('_token'));

        return redirect(route('category.index'))->with('success', 'Berhasil menambah data');
    }

    public function getCategory(Request $req)
    {

        $category = Category::where('id', request()->id)->first();
        $parent   = Category::getParent()->orderBy('name', 'ASC')->get();
        return response()->json(['category' => $category, 'parent' => $parent]);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'name' => 'required|string|max:100|unique:categories,name,' . $id
        ]);

        $category = Category::find($id);
        $category->update([
            'name' => $req->name,
            'parent_id' => $req->parent_id
        ]);

        return back()->with("success", "Berhasil mengedit data");
    }

    public function destroy($id)
    {
        $category = Category::withCount('child')->find($id);

        if ($category->child_count == 0) {
            $category->delete();
            return back()->with('success', 'Berhasil mengapus Data');
        }

        return back()->with('error', $category->name . ' ' . 'Memiliki anak kategori');
    }
}
