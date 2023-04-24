<?php

namespace Modules\Shop\Http\Controllers\admin\Orders;

use App\Http\Controllers\Controller;
use Modules\Shop\Entities\Order;

class OrdersController extends Controller
{
    public function index()
    {
        return view('shop::admin.orders.index', [
            'orders' => Order::orderBy('created_at', 'desc')->get()
        ]);
    }
}
