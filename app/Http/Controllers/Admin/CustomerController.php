<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Customer;


class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['user'])->withCount(['order'])->paginate(10);

        return view('admin.customer', compact('customers'));
    }

    public function destroy($id)
    {
        $customer = Customer::with(['user'])->where('id', $id)->first();
        $customer->user()->delete();
        $customer->delete();

        return back()->with('success', 'Berhasil Menghapus Data');
    }
}
