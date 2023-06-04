<?php

namespace Modules\Shop\Models\Admin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\Entities\Basket\Basket;
use Modules\Shop\Entities\ShopRegisteredUser;

class ProductFavorite extends Model
{
    protected $table   = "product_favorites";
    protected $guarded = ['id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(ShopRegisteredUser::class, 'user_id');
    }

}
