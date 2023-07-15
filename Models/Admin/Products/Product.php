<?php

namespace Modules\Shop\Models\Admin\Products;

use App\Helpers\AdminHelper;
use App\Helpers\CacheKeysHelper;
use App\Helpers\FileDimensionHelper;
use App\Helpers\SeoHelper;
use App\Interfaces\Models\ImageModelInterface;
use App\Models\Seo;
use App\Traits\CommonActions;
use App\Traits\HasGallery;
use App\Traits\Scopes;
use App\Traits\StorageActions;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Modules\Shop\Entities\Settings\MeasureUnit;
use Modules\Shop\Entities\Settings\VatCategory;
use Modules\Shop\Models\Admin\Brands\Brand;
use Modules\Shop\Models\Admin\ProductCategory\Category;
use Modules\Shop\Models\Admin\ProductCombination\ProductCombination;
use Modules\ShopDiscounts\Entities\Discount;

class Product extends Model implements TranslatableContract, ImageModelInterface
{
    use Translatable, Scopes, StorageActions, CommonActions, HasGallery;

    public const FILES_PATH     = "images/shop/products";
    const        ALLOW_CATALOGS = true;
    const        ALLOW_ICONS    = true;
    const        ALLOW_LOGOS    = true;

    public static string $PRODUCT_SYSTEM_IMAGE  = 'shop_3_image.png';
    public static string $PRODUCT_RATIO         = '1/1';
    public static string $PRODUCT_MIMES         = 'jpg,jpeg,png,gif';
    public static string $PRODUCT_MAX_FILE_SIZE = '3000';

    public array $translatedAttributes = ['title', 'announce', 'description', 'visible', 'url', 'title_additional_1', 'title_additional_2', 'title_additional_3',
                                          'title_additional_4', 'title_additional_5', 'title_additional_6', 'text_additional_1', 'text_additional_2',
                                          'text_additional_3', 'text_additional_4', 'text_additional_5', 'text_additional_6'];
    protected    $fillable             = ['active', 'position', 'filename', 'creator_user_id', 'logo_filename', 'logo_active', 'category_id', 'brand_id',
                                          'supplier_delivery_price', 'price', 'barcode', 'ean_code', 'measure_unit_id', 'is_new', 'is_promo', 'width', 'height', 'length', 'weight', 'sku', 'units_in_stock', 'measure_unit_value', 'catalog_from_price', 'catalog_discounted_price', 'catalog_from_discounted_price'];
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
        cache()->rememberForever(CacheKeysHelper::$SHOP_PRODUCT_ADMIN, function () {
            return self::with('category')->with('brand', 'measureUnit')->withTranslation()->with('translations')->orderBy('position')->get();
        });

        cache()->rememberForever(CacheKeysHelper::$SHOP_PRODUCT_FRONT, function () {
            return self::with('category')->with('brand', 'measureUnit')->active(true)->orderBy('position')->with('translations')->get();
        });
    }
    public static function getRequestData($request): array
    {
        $data = [
            'category_id'     => $request->category_id,
            'measure_unit_id' => $request->measure_unit_id,
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

        if ($request->has('supplier_delivery_price')) {
            $data['supplier_delivery_price'] = $request->supplier_delivery_price;
        }

        if ($request->has('price')) {
            $data['price'] = $request->price;
        }

        if ($request->has('barcode')) {
            $data['barcode'] = $request->barcode;
        }

        if ($request->has('ean_code')) {
            $data['ean_code'] = $request->ean_code;
        }

        if ($request->has('sku')) {
            $data['sku'] = $request->sku;
        }

        if ($request->has('measure_unit')) {
            $data['measure_unit'] = $request->measure_unit;
        }

        if ($request->has('measure_unit_value')) {
            $data['measure_unit_value'] = $request->measure_unit_value;
        }

        $data['is_new'] = false;
        if ($request->has('is_new')) {
            $data['is_new'] = filter_var($request->is_new, FILTER_VALIDATE_BOOLEAN);
        }

        $data['is_promo'] = false;
        if ($request->has('is_promo')) {
            $data['is_promo'] = filter_var($request->is_promo, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('width')) {
            $data['width'] = $request->width;
        }

        if ($request->has('height')) {
            $data['height'] = $request->height;
        }

        if ($request->has('length')) {
            $data['length'] = $request->length;
        }

        if ($request->has('weight')) {
            $data['weight'] = $request->weight;
        }

        if ($request->has('units_in_stock')) {
            $data['units_in_stock'] = $request->units_in_stock;
        }

        $data['catalog_from_price'] = false;
        if ($request->has('catalog_from_price')) {
            $data['catalog_from_price'] = filter_var($request->catalog_from_price, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('catalog_discounted_price')) {
            $data['catalog_discounted_price'] = $request->catalog_discounted_price;
        }

        $data['catalog_from_discounted_price'] = false;
        if ($request->has('catalog_from_discounted_price')) {
            $data['catalog_from_discounted_price'] = filter_var($request->catalog_from_discounted_price, FILTER_VALIDATE_BOOLEAN);
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
    public static function generatePosition($request)
    {
        $models = self::where('category_id', $request->category_id)->orderBy('position', 'desc')->get();
        if (count($models) < 1) {
            return 1;
        }
        if (!$request->has('position') || is_null($request['position'])) {
            return $models->first()->position + 1;
        }

        if ($request['position'] > $models->first()->position) {
            return $models->first()->position + 1;
        }
        $modelsToUpdate = self::where('category_id', $request->category_id)->where('position', '>=', $request['position'])->get();
        foreach ($modelsToUpdate as $modelToUpdate) {
            $modelToUpdate->update(['position' => $modelToUpdate->position + 1]);
        }

        return $request['position'];
    }
    public function updatedPosition($request)
    {
        if (!$request->has('position') || is_null($request->position) || $request->position == $this->position) {
            return $this->position;
        }

        $models = self::where('category_id', $this->category_id)->orderBy('position', 'desc')->get();
        if (count($models) == 1) {
            $request['position'] = 1;

            return $request['position'];
        }

        if ($request['position'] > $models->first()->position) {
            $request['position'] = $models->first()->position;
        } elseif ($request['position'] < $models->last()->position) {
            $request['position'] = $models->last()->position;
        }

        if ($request['position'] >= $this->position) {
            $modelsToUpdate = self::where('category_id', $this->category_id)->where('id', '<>', $this->id)->where('position', '>', $this->position)->where('position', '<=', $request['position'])->get();
            foreach ($modelsToUpdate as $modelToUpdate) {
                $modelToUpdate->update(['position' => $modelToUpdate->position - 1]);
            }

            return $request['position'];
        }

        $modelsToUpdate = self::where('category_id', $this->category_id)->where('id', '<>', $this->id)->where('position', '<', $this->position)->where('position', '>=', $request['position'])->get();
        foreach ($modelsToUpdate as $modelToUpdate) {
            $modelToUpdate->update(['position' => $modelToUpdate->position + 1]);
        }

        return $request['position'];
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
        $countryId = null;
        if (!is_null($country)) {
            $countryId = $country->id;
        }
        if (!is_null($city)) {
            $countryId = $city->country->id;
        }
        if (!is_null($countryId)) {
            $vatCategory = $this->getVatCategory($countryId);
            if (!is_null($vatCategory)) {
                if (!is_null($city)) {
                    $cityVatCategory = $vatCategory->cityVatCategories->where('city_id', $city->id)->first();
                    if (!is_null($cityVatCategory)) {
                        return $cityVatCategory->vat;
                    } else {
                        $stateVatCategory = $vatCategory->stateVatCategories->where('state_id', $city->state_id)->first();
                        if (!is_null($stateVatCategory)) {
                            return $stateVatCategory->vat;
                        }
                    }
                }

                return $vatCategory->vat;
            }
        }

        return self::getDefaultVat($country, $city);
    }
    public function getVatCategory($countryId)
    {
        return $this->hasManyThrough(VatCategory::class, ProductVatCategory::class, 'product_id', 'id', 'id', 'vat_category_id')->where('vat_categories.country_id', $countryId)->first();
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
    public function getAnnounce(): string
    {
        return Str::limit($this->announce, 255, ' ...');
    }
    public function getPrice()
    {
        return number_format($this->price, 2, '.', '');
    }
    public function getEncryptedPath($moduleName): string
    {
        return encrypt($moduleName . '-' . get_class($this) . '-' . $this->id);
    }
    public function headerGallery()
    {
        return $this->getHeaderGalleryRelation(get_class($this));
    }
    public function mainGallery()
    {
        return $this->getMainGalleryRelation(get_class($this));
    }
    public function additionalGalleryOne()
    {
        return $this->getAdditionalGalleryOneRelation(get_class($this));
    }
    public function additionalGalleryTwo()
    {
        return $this->getAdditionalGalleryTwoRelation(get_class($this));
    }
    public function additionalGalleryThree()
    {
        return $this->getAdditionalGalleryThreeRelation(get_class($this));
    }
    public function additionalGalleryFour()
    {
        return $this->getAdditionalGalleryFourRelation(get_class($this));
    }
    public function additionalGalleryFive()
    {
        return $this->getAdditionalGalleryFiveRelation(get_class($this));
    }
    public function additionalGallerySix()
    {
        return $this->getAdditionalGallerySixRelation(get_class($this));
    }
    public function seoFields()
    {
        return $this->hasOne(Seo::class, 'model_id')->where('model', get_class($this));
    }
    public function seo($languageSlug)
    {
        $seo = $this->seoFields;
        if (is_null($seo)) {
            return null;
        }
        SeoHelper::setSeoFields($this, $seo->translate($languageSlug));
    }
    public function isNewProduct(): bool
    {
        return (boolean)$this->is_new;
    }
    public function isPromoProduct(): bool
    {
        return (boolean)$this->is_promo;
    }
    public function isInCollection(): bool
    {
        //TODO: Make collection check
        return false;
    }
    public function scopeIsInStock($query)
    {
        return $query->where('units_in_stock', '>', 0);
    }

    public function updateUnitsInStock($newQuantity): void
    {
        $this->update(['units_in_stock' => $newQuantity]);
    }
    public function additionalFields(): HasMany
    {
        return $this->hasMany(ProductAdditionalField::class, 'product_id', 'id');
    }

    public function getAdditionalFields($languageSlug)
    {
        return $this->hasMany(ProductAdditionalField::class, 'product_id', 'id')->where('locale', $languageSlug)->whereNotNull(['name', 'text'])->get();
    }

    public function getPreviousProductUrl($languageSlug)
    {
        if ($this->position == 1) {
            return null;
        }
        $previousProduct = $this->category->products()->where('position', $this->position - 1)->first();
        if (is_null($previousProduct)) {
            return null;
        }

        return $previousProduct->getUrl($languageSlug);
    }
    public function getUrl($languageSlug)
    {
        return url($languageSlug . '/' . $this->url);
    }
    public function getNextProductUrl($languageSlug)
    {
        $query       = $this->category->products();
        $lastProduct = $query->latest()->first();
        if (is_null($lastProduct) || $this->position == $lastProduct->position) {
            return null;
        }

        $nextProduct = $query->where('position', $this->position + 1)->first();
        if (is_null($nextProduct)) {
            return null;
        }

        return $nextProduct->getUrl($languageSlug);
    }

    public function measureUnit(): HasOne
    {
        return $this->hasOne(MeasureUnit::class, 'id', 'measure_unit_id')->with('translations');
    }

    public function combinations(): HasMany
    {
        return $this->hasMany(ProductCombination::class, 'product_id', 'id');
    }
}
