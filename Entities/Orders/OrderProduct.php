<?php

    namespace Modules\Shop\Entities\Orders;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Modules\Shop\Entities\Basket\BasketProductAdditive;
    use Modules\Shop\Entities\Basket\BasketProductCollection;
    use Modules\Shop\Models\Admin\Products\Product;

    class OrderProduct extends Model
    {
        protected $fillable = ['order_id', 'product_id', 'product_quantity',
                               'supplier_delivery_price', 'price', 'discounts_amount',
                               'vat', 'vat_applied_price', 'end_price', 'free_delivery',
                               'vat_applied_discounted_price', 'end_discounted_price',
                               'vat_applied_default_price'];

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

        public function additives(): HasMany
        {
            return $this->hasMany(OrderProductAdditive::class, 'order_product_id', 'id')->where('in_without_list', false)->with(['productAdditive']);
        }

        public function additiveExcepts(): HasMany
        {
            return $this->hasMany(OrderProductAdditive::class, 'order_product_id', 'id')->where('in_without_list', true)->with(['productAdditive']);
        }
        public function productCollection(): HasMany
        {
            return $this->hasMany(OrderProductCollection::class, 'order_product_id', 'id')->with(['product']);
        }

        public function additivesTotal()
        {
            $total = 0;
            foreach ($this->additives as $additive) {
                $total += $additive->total;
            }

            return $total;
        }

        public function collectionTotal()
        {
            $total = 0;
            foreach ($this->productCollection as $productCollection) {
                $total += $productCollection->total;
            }

            return $total;
        }
    }
