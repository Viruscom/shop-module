<?php

namespace Modules\Shop\Models\Admin\ProductAttribute\Values;

use App\Helpers\CacheKeysHelper;
use App\Helpers\FileDimensionHelper;
use App\Traits\CommonActions;
use App\Traits\Scopes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shop\Models\Admin\ProductCategory\Category;

class ProductAttributeValue extends Model implements TranslatableContract
{
    use Translatable, Scopes, CommonActions;

    public const FILES_PATH = "images/shop/products/attribute_values";
    public static string $PRODUCT_ATTRIBUTE_VALUE_SYSTEM_IMAGE  = 'product_attribute_value_img.png';
    public static string $PRODUCT_ATTRIBUTE_VALUE_RATIO         = '1/1';
    public static string $PRODUCT_ATTRIBUTE_VALUE_MIMES         = 'jpg,jpeg,png,gif';
    public static string $PRODUCT_ATTRIBUTE_VALUE_MAX_FILE_SIZE = '3000';

    public array $translatedAttributes  = ['title'];
    protected    $table                 = 'product_attribute_values';
    protected    $fillable              = ['product_attr_id', 'color_picker_color', 'filename', 'position'];
    protected    $translationForeignKey = 'pattrv_id';

    public static function getFileRules(): string
    {
        return FileDimensionHelper::getRules('Shop', 3);
    }
    public static function getUserInfoMessage(): string
    {
        return FileDimensionHelper::getUserInfoMessage('Shop', 3);
    }
    public static function cacheUpdate(): void
    {
        cache()->forget(CacheKeysHelper::$SHOP_PRODUCT_ATTRIBUTE_VALUES_ADMIN);
        cache()->forget(CacheKeysHelper::$SHOP_PRODUCT_ATTRIBUTE_VALUES_FRONT);
        cache()->rememberForever(CacheKeysHelper::$SHOP_PRODUCT_ATTRIBUTE_VALUES_ADMIN, function () {
            return self::with('translations')->orderBy('position')->get();
        });

        cache()->rememberForever(CacheKeysHelper::$SHOP_PRODUCT_ATTRIBUTE_VALUES_FRONT, function () {
            return self::orderBy('position')->with('translations')->get();
        });
    }


    public static function generatePosition($request): int
    {
        $cities = self::orderBy('position', 'desc')->get();
        if (count($cities) < 1) {
            return 1;
        }
        if (!$request->has('position') || is_null($request['position'])) {
            return $cities->first()->position + 1;
        }

        if ($request['position'] > $cities->first()->position) {
            return $cities->first()->position + 1;
        }
        $citiesToUpdate = self::where('position', '>=', $request['position'])->get();
        foreach ($citiesToUpdate as $cityToUpdate) {
            $cityToUpdate->update(['position' => $cityToUpdate->position + 1]);
        }

        return $request['position'];
    }

    public static function getLangArraysOnStore($data, $request, $languages, $modelId, $isUpdate)
    {
        foreach ($languages as $language) {
            $data[$language->code] = ProductAttributeValueTranslation::getLanguageArray($language, $request, $modelId, $isUpdate);
        }

        return $data;
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
    public function translations(): HasMany
    {
        return $this->hasMany(ProductAttributeValueTranslation::class, 'pattrv_id', 'id');
    }
    public function getUpdateData($request): array
    {
        return self::getRequestData($request);
    }
    public static function getRequestData($request): array
    {
        $data = [
            'type' => $request->type
        ];

        $data['active'] = false;
        if ($request->has('active')) {
            $data['active'] = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
        }

        return $data;
    }
    public function updatedPosition($request)
    {
        if (!$request->has('position') || is_null($request->position) || $request->position == $this->position) {
            return $this->position;
        }

        $cities = self::orderBy('position', 'desc')->get();
        if (count($cities) == 1) {
            $request['position'] = 1;

            return $request['position'];
        }

        if ($request['position'] > $cities->first()->position) {
            $request['position'] = $cities->first()->position;
        } elseif ($request['position'] < $cities->last()->position) {
            $request['position'] = $cities->last()->position;
        }

        if ($request['position'] >= $this->position) {
            $citiesToUpdate = self::where('id', '<>', $this->id)->where('position', '>', $this->position)->where('position', '<=', $request['position'])->get();
            foreach ($citiesToUpdate as $cityToUpdate) {
                $cityToUpdate->update(['position' => $cityToUpdate->position - 1]);
            }

            return $request['position'];
        }

        $citiesToUpdate = self::where('id', '<>', $this->id)->where('position', '<', $this->position)->where('position', '>=', $request['position'])->get();
        foreach ($citiesToUpdate as $cityToUpdate) {
            $cityToUpdate->update(['position' => $cityToUpdate->position + 1]);
        }

        return $request['position'];
    }
}
