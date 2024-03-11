<?php

    namespace Modules\Shop\Entities\Basket;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Modules\Shop\Models\Admin\Products\Product;

    class BasketProductCollection extends Model
    {
        protected $table    = "basket_products_collection_pivot";
        protected $fillable = ['basket_product_id', 'product_id', 'main_product_id', 'price', 'quantity', 'total', 'product_print'];

        public function product(): BelongsTo
        {
            return $this->belongsTo(Product::class);
        }
    }
