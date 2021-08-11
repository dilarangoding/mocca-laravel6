<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Product;
use App\Order;
use App\User;

class DashboardController extends Controller
{
    public function index()
    {
        $product   = Product::count();
        $order     = Order::where('status', 2)->count();
        $income    = Order::where('status', 4)->sum('subtotal');
        $date      = Carbon::now()->subDays(7);
        $customer = User::where('created_at', '>=', $date)->count();

        return view('admin.dashboard', compact('product', 'order', 'income', 'date', 'customer'));
    }
}
