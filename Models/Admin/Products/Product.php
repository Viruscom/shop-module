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
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Modules\RetailObjectsRestourant\Models\ProductAdditive;
use Modules\RetailObjectsRestourant\Models\ProductAdditivePivot;
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
    public function getProductQuantityDiscountHtml()
    {
        //ako ne iskash da si generirash taka html prostro v html si vikash $product->getQuantityDiscountRecord(); i shte poluchis tozi zapis koito iteriram tuk
        $productQuantityDiscount = $this->getQuantityDiscountRecord();
        if (is_null($productQuantityDiscount)) {
            return "";
        }

        $data = json_decode($productQuantityDiscount->data, true);
        if (count($data) < 1) {
            return "";
        }

        $html = "<table class='table'><thead><tr><th>FROM</th><th>TO</th><th>PRICE</th></tr><tbody>";
        foreach ($data as $ranges) {
            $html .= "<tr><td>" . $ranges['from_quantity'] . "</td><td>" . $ranges['to_quantity'] . "</td><td>" . $ranges['price'] . "</td></tr>";
        }
        $html .= "</tbody><table>";

        return $html;
    }
    public function getQuantityDiscountRecord()
    {
        return Discount::getBaseQuery()->where('type_id', Discount::$QUANTITY_TYPE_ID)
            ->where('product_id', $this->id)->orderBy('created_at', 'desc')->first();
    }
    public function getFreeDeliveryDiscountHtml()
    {
        //ako ne iskash da si generirash taka html prostro v html si vikash $product->getFreeDeliveryDiscountRecord(); i shte poluchis tozi zapis koito proverqvam dali ne e null
        return is_null($this->getFreeDeliveryDiscountRecord()) ? "" : "<span>Free Delivery</span>";
    }

    // BEGIN QUANTITY DISCOUNT
    public function getFreeDeliveryDiscountRecord()//ako e null nqma free deliveryako nee nul ima free delivery
    {
        $product = $this;

        return Discount::getBaseQuery()->where('type_id', Discount::$FIXED_FREE_DELIVERY_TYPE_ID)
            ->where(function ($q) use ($product) {
                return $q->where(function ($qq) {
                    return $qq->where('applies_to', Discount::$EVERY_PRODUCT_APPLICATION);
                })->orWhere(function ($qq) use ($product) {
                    return $qq->where('applies_to', Discount::$PRODUCT_APPLICATION)->where('product_id', $product->id);
                })->orWhere(function ($qq) use ($product) {
                    return $qq->where('applies_to', Discount::$CATEGORY_APPLICATION)->whereHas('categories', function ($qqq) use ($product) {
                        return $qqq->where('category_id', $product->category_id);
                    });
                })->orWhere(function ($qq) use ($product) {
                    return $qq->where('applies_to', Discount::$BRAND_APPLICATION)->where('brand_id', $product->brand->id);
                });
            })->get()->first();
    }
    public function getFixedDiscountsHtml($country, $city)
    {
        //ako ne iskash da go polzvash taka mojesh da si gi polzvash po otderlo
        $vat                       = $this->getVat($country, $city);
        $vatAppliedPrice           = $this->price + ($this->price * ($vat / 100));
        $discounts                 = $this->getFixedDiscountsRecords();
        $discountsAmount           = Discount::getDiscountsAmount($discounts, $vatAppliedPrice);
        $vatAppliedDiscountedPrice = $vatAppliedPrice - $discountsAmount;

        return "<span>No VAT price: " . $this->price . "</span><span> | </span><span>VAT: " . $vat . "</span><span> | </span><span>VAT pice: " . $vatAppliedPrice . "</span><span> | </span><span>Discounts: " . $discountsAmount . "</span><span> | </span><span>Discounted price: " . $vatAppliedDiscountedPrice . "</span><span> | </span>";
    }
    // END QUANTITY DISCOUNT

    // BEGON FREE DELIVERY DISCOUT
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
    // END FREE DELIVERY DISCOUNT

    // BEGIN FIXED DISCOUNTS
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
    public function getFixedDiscountsRecords()
    {
        $product = $this;

        $fixedDiscounts = Discount::getBaseQuery()->whereIn('type_id', [Discount::$FIXED_PERCENT_TYPE_ID, Discount::$FIXED_AMOUNT_TYPE_ID])
            ->where(function ($q) use ($product) {
                return $q->where(function ($qq) {
                    return $qq->where('applies_to', Discount::$EVERY_PRODUCT_APPLICATION);
                })->orWhere(function ($qq) use ($product) {
                    return $qq->where('applies_to', Discount::$PRODUCT_APPLICATION)->where('product_id', $product->id);
                })->orWhere(function ($qq) use ($product) {
                    return $qq->where('applies_to', Discount::$CATEGORY_APPLICATION)->whereHas('categories', function ($qqq) use ($product) {
                        return $qqq->where('category_id', $product->category_id);
                    });
                })->orWhere(function ($qq) use ($product) {
                    return $qq->where('applies_to', Discount::$BRAND_APPLICATION)->where('brand_id', $product->brand->id);
                });
            })->get();

        $discounts        = [];
        $currentAppliesTo = null;
        foreach ($fixedDiscounts as $fixedDiscount) {
            if (count($discounts) == 0) {
                $discounts[$fixedDiscount->id] = $fixedDiscount;
                $currentAppliesTo              = $fixedDiscount->applies_to;
            } else {
                if ($currentAppliesTo == Discount::$PRODUCT_APPLICATION) {
                    if ($fixedDiscount->applies_to == Discount::$PRODUCT_APPLICATION) {
                        $discounts[$fixedDiscount->id] = $fixedDiscount;
                    }
                } else {
                    if ($currentAppliesTo == $fixedDiscount->applies_to) {
                        $discounts[$fixedDiscount->id] = $fixedDiscount;
                    } else if ($currentAppliesTo < $fixedDiscount->applies_to) {
                        $discounts                     = [];
                        $discounts[$fixedDiscount->id] = $fixedDiscount;
                        $currentAppliesTo              = $fixedDiscount->applies_to;
                    }
                }
            }
        }

        if (count($discounts) < 1) {
            return null;
        }

        return $discounts;
    }
    // END FIXED DISCOUNTS
    public function hasDiscounts()
    {
        $discounts = $this->getFixedDiscountsRecords();

        return !is_null($discounts) && count($discounts) > 0;
    }
    public function getPercentDiscountsLabel($country, $city): string
    {
        $label = (($this->getVatPrice($country, $city) - $this->getVatDiscountedPrice($country, $city)) / $this->getVatPrice($country, $city)) * 100;

        return number_format($label, 2, '.', '');
    }
    public function getVatPrice($country, $city)
    {
        $vat             = $this->getVat($country, $city);
        $vatAppliedPrice = $this->price + ($this->price * ($vat / 100));

        return number_format($vatAppliedPrice, 2, '.', '');
    }
    public function getVatDiscountedPrice($country, $city)
    {
        $vat                       = $this->getVat($country, $city);
        $vatAppliedPrice           = $this->price + ($this->price * ($vat / 100));
        $discounts                 = $this->getFixedDiscountsRecords();
        $discountsAmount           = Discount::getDiscountsAmount($discounts, $vatAppliedPrice);
        $vatAppliedDiscountedPrice = $vatAppliedPrice - $discountsAmount;

        return number_format($vatAppliedDiscountedPrice, 2, '.', '');
    }

    public function additives($isWithoutList): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductAdditive::class,
            ProductAdditivePivot::class,
            'product_id',
            'id',
            'id',
            'product_additive_id'
        )->where('in_without_list', $isWithoutList);
    }
}
