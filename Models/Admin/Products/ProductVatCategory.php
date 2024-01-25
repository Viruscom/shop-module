<?php

    namespace Modules\Shop\Models\Admin\Products;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Modules\Shop\Entities\Settings\VatCategory;

    class ProductVatCategory extends Model
    {
        protected $table = 'product_vat_category';
        public function product(): BelongsTo
        {
            return $this->belongsTo(Product::class);
        }

        public function vatCategories(): HasMany
        {
            return $this->hasMany(VatCategory::class);
        }
    }
