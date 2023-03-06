<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shop\Models\Admin\Products\Product;

class BasketProduct extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['basket_id', 'product_id', 'product_quantity'];

    /**
     * @return BelongsTo
     */
    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }

    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
