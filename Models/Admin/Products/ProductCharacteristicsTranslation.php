<?php

namespace Modules\Shop\Models\Admin\Products;

use App\Helpers\UrlHelper;
use App\Interfaces\Models\CommonModelTranslationInterfaces;
use App\Models\CategoryPage\CategoryPage;
use App\Models\Language;
use App\Models\Pages\PageTranslation;
use App\Traits\StorageActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCharacteristicsTranslation extends Model implements CommonModelTranslationInterfaces
{
    protected $table    = "product_characteristic_translation";
    protected $fillable = ['locale', 'pch_id', 'title'];

    public static function getLanguageArray($language, $request, $modelId, $isUpdate): array
    {
        return [
            'locale' => $language->code,
            'title'  => $request['title_' . $language->code],
        ];

    }
    public static function createMissingLanguageRow($language, $request, $model)
    {
        $data  = [
            'locale' => $language->code,
            'title'  => $request['title_' . $language->code] . '-' . $language->code,
        ];
        $model->translations()->create(self::langArray($data, $language, $request));
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCharacteristic::class, 'pch_id');
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
