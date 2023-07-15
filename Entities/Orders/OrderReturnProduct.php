<?php

namespace Modules\Shop\Entities\Orders;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class OrderReturnProduct extends Model
{
    protected $table   = 'orders_returns_products';
    protected $guarded = ['id'];

    public function return()
    {
        return $this->belongsTo(OrderReturn::class, 'order_return_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
