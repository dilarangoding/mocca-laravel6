<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


// models

use App\Order;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $order = Order::selectRaw('COALESCE(sum(CASE WHEN status = 0 THEN subtotal END), 0) as pending, 
        COALESCE(count(CASE WHEN status = 3 THEN subtotal END), 0) as shipping,
        COALESCE(count(CASE WHEN status = 4 THEN subtotal END), 0) as completeOrder')
            ->where('customer_id', auth()->user()->customer->id)->get();


        return view('customer.dashboard', compact('order'));
    }
}
