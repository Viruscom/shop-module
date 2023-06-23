<?php

namespace Modules\Shop\Entities\Settings;

use App\Helpers\CacheKeysHelper;
use App\Traits\CommonActions;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class MeasureUnit extends Model implements TranslatableContract
{
    use Translatable, CommonActions;

    public array $translatedAttributes = ['title'];
    protected    $table                = "measure_units";
    protected    $guarded              = ['id'];
    public static function cacheUpdate(): void
    {
        cache()->forget(CacheKeysHelper::$SHOP_MEASURE_UNITS_ADMIN);
        cache()->rememberForever(CacheKeysHelper::$SHOP_MEASURE_UNITS_ADMIN, function () {
            return self::withTranslation()->with('translations')->get();
        });
    }

    public static function getRequestData($request): array
    {
        return [];
    }

    public static function getLangArraysOnStore($data, $request, $languages, $modelId, $isUpdate)
    {
        foreach ($languages as $language) {
            $data[$language->code] = MeasureUnitTranslation::getLanguageArray($language, $request, $modelId, $isUpdate);
        }

        return $data;
    }
    public static function generatePosition($request): int
    {
        return 1;
    }
}
