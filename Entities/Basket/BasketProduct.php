<?php

    namespace Modules\Shop\Entities\Basket;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Modules\Shop\Models\Admin\Products\Product;

    class BasketProduct extends Model
    {
        use HasFactory;

        /**
         * @var array
         */
        protected $fillable = ['basket_id', 'product_id', 'product_quantity', 'product_print'];

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
        
        public function productCollection(): HasMany
        {
            return $this->hasMany(BasketProductCollection::class, 'basket_product_id', 'id')->where('product_print', $this->product_print)->with(['product']);
        }
    }
