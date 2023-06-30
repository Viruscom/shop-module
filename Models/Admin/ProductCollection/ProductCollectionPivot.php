<?php

namespace Modules\Shop\Models\Admin\ProductCollection;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Shop\Models\Admin\Products\Product;

class ProductCollectionPivot extends Model
{
    protected $table    = "product_collections_pivot";
    protected $fillable = ['collection_id', 'main_product_id', 'additional_product_id', 'price', 'discount', 'price_with_discount', 'collection_hash'];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(ProductCollection::class, 'collection_id', 'id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'additional_product_id');
    }
}
