<?php

namespace Modules\Shop\Models\Admin\Products;

use App\Helpers\AdminHelper;
use App\Helpers\CacheKeysHelper;
use App\Helpers\FileDimensionHelper;
use App\Interfaces\Models\ImageModelInterface;
use App\Traits\CommonActions;
use App\Traits\Scopes;
use App\Traits\StorageActions;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shop\Models\Admin\Brand;
use Modules\Shop\Models\Admin\ProductCategory\Category;
use Modules\ShopDiscounts\Entities\Discount;

class Product extends Model implements TranslatableContract, ImageModelInterface
{
    use Translatable, Scopes, StorageActions, CommonActions;

    public const FILES_PATH = "images/shop/products";

    public static string $PRODUCT_SYSTEM_IMAGE  = 'product_1_image.png';
    public static string $PRODUCT_RATIO         = '1/1';
    public static string $PRODUCT_MIMES         = 'jpg,jpeg,png,gif';
    public static string $PRODUCT_MAX_FILE_SIZE = '3000';

    public array $translatedAttributes = ['title', 'announce', 'description', 'visible', 'url', 'title_additional_1', 'title_additional_2', 'title_additional_3',
                                          'title_additional_4', 'title_additional_5', 'title_additional_6', 'text_additional_1', 'text_additional_2',
                                          'text_additional_3', 'text_additional_4', 'text_additional_5', 'text_additional_6'];
    protected    $fillable             = ['active', 'position', 'filename', 'creator_user_id', 'logo_filename', 'logo_active', 'category_id', 'brand_id'];
    protected    $table                = 'products';
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
        cache()->forget(CacheKeysHelper::$SHOP_PRODUCT_ADMIN);
        cache()->forget(CacheKeysHelper::$SHOP_PRODUCT_FRONT);
        cache()->remember(CacheKeysHelper::$SHOP_PRODUCT_ADMIN, config('default.app.cache.ttl_seconds'), function () {
            return self::with('category')->with('brand')->withTranslation()->with('translations')->orderBy('position')->get();
        });

        cache()->remember(CacheKeysHelper::$SHOP_PRODUCT_FRONT, config('default.app.cache.ttl_seconds'), function () {
            return self::with('category')->with('brand')->active(true)->orderBy('position')->withTranslation()->get();
        });
    }
    public static function getRequestData($request): array
    {
        $data = [
            'category_id'     => $request->category_id,
            'brand_id'        => $request->brand_id,
            'position'        => $request->position,
            'creator_user_id' => Auth::user()->id
        ];

        $data['active'] = false;
        if ($request->has('active')) {
            $data['active'] = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('filename')) {
            $data['filename'] = $request->filename;
        }

        if ($request->hasFile('image')) {
            $data['filename'] = pathinfo(CommonActions::getValidFilenameStatic($request->image->getClientOriginalName()), PATHINFO_FILENAME) . '.' . $request->image->getClientOriginalExtension();
        }

        return $data;
    }
    public static function getLangArraysOnStore($data, $request, $languages, $modelId, $isUpdate)
    {
        foreach ($languages as $language) {
            $data[$language->code] = ProductTranslation::getLanguageArray($language, $request, $modelId, $isUpdate);
        }

        return $data;
    }
    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }
    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function getVat($country, $city)
    {
        if (is_null($country) && is_null($city)) {
            return 0;
        }
        $defaultVat = self::getDefaultVat($country, $city);
        //select product city vat category or product state vat category or country vat category
        //of any of above is not null return it else
        //TODO: nqma kak da go napish sega zashtoto nqmam funkcionalnost za dobavqne na produkti, Kato se dobavqt productite se dobavqt i suotvetnite vat katogrii
        return $defaultVat;
    }
    private static function getDefaultVat($country, $city)
    {
        if ($city != null) {
            if (!is_null($city->vat)) {
                return $city->vat;
            }
            if (!is_null($city->state->vat)) {
                return $city->state->vat;
            }
        }

        return $country->vat;
    }
    public function getFilepath($filename): string
    {
        return $this->getFilesPath() . $filename;
    }
    public function getFilesPath(): string
    {
        return self::FILES_PATH . '/' . $this->id . '/';
    }
    public function getSystemImage(): string
    {
        return AdminHelper::getSystemImage(self::$PRODUCT_SYSTEM_IMAGE);
    }
    public function setKeys($array): array
    {
        //        Go to Shop Model
    }
}
