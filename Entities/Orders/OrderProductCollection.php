<?php

    namespace Modules\Shop\Entities\Orders;

    use Auth;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
    use Modules\Shop\Models\Admin\Products\Product;
    use Modules\ShopDiscounts\Entities\Discount;

    class OrderProductCollection extends Model
    {
        protected $table = "order_products_collection_pivot";
        protected $fillable = ['order_product_id', 'product_id', 'main_product_id', 'price', 'quantity', 'total', 'product_print'];

        public function product(): BelongsTo
        {
            return $this->belongsTo(Product::class, 'product_id', 'id');
        }

        public function getVatPrice($country, $city): string
        {
            $vat             = $this->product->getVat($country, $city);
            $vatAppliedPrice = $this->price_with_discount + ($this->price_with_discount * ($vat / 100));

            return number_format($vatAppliedPrice, 2, '.', '');
        }

        public function getVat($country, $city): string
        {
            $vat = $this->product->getVat($country, $city);

            return number_format($vat, 2, '.', '');
        }
    }
