<?php

namespace Modules\Shop\Entities\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shop\Models\Admin\Products\Product;

class OrderProduct extends Model
{
    protected $fillable = ['order_id', 'product_id', 'product_quantity', 'supplier_delivery_price', 'price', 'discounts_amount', 'vat', 'vat_applied_price', 'end_price', 'free_delivery', 'vat_applied_discounted_price', 'end_discounted_price', 'vat_applied_default_price'];

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
