<?php

namespace Modules\Shop\Models\Admin\ProductAttribute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttributeTranslation extends Model
{
    protected $table    = "product_attribute_translation";
    protected $fillable = ['language_id', 'product_attribute_id', 'title'];
    public static function getCreateData($language, $request): array
    {
        $data = [
            'language_id' => $language->id,
            'title'       => $request['title_' . $language->code]
        ];

        return $data;
    }
    public function productAttribute(): BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    public function getUpdateData($language, $request): array
    {
        $data = [
            'language_id' => $language->id,
            'title'       => $request['title_' . $language->code]
        ];

        return $data;
    }
}
