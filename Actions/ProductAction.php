<?php

namespace Modules\Shop\Actions;

use App\Classes\ProductHelper;
use App\Helpers\CacheKeysHelper;
use App\Helpers\LanguageHelper;
use App\Models\AdBox;
use App\Models\AdBoxTranslation;
use App\Models\Files\File;
use Cache;
use Illuminate\Http\Request;
use Modules\Shop\Entities\AdBoxProduct\AdBoxProduct;
use Modules\Shop\Models\Admin\Brands\Brand;
use Modules\Shop\Models\Admin\ProductCategory\Category;
<<<<<<< HEAD
use Modules\Shop\Models\Admin\Products\Product;

class ProductAction
{
=======

class ProductAction
{
    public function generateProductAdBox()
    {

    }
>>>>>>> origin/main
    public function checkForFilesCache(): void
    {
        if (is_null(Cache::get(CacheKeysHelper::$FILES))) {
            File::updateCache();
        }
    }
    public function checkForProductCategoriesAdminCache(): void
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN))) {
            Category::cacheUpdate();
        }
    }
    public function checkForBrandsCache(): void
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_BRAND_ADMIN))) {
            Brand::cacheUpdate();
        }
    }

    public function isProductAdBoxExists($productId)
    {
        return (bool)AdBoxProduct::where('product_id', $productId)->first();
    }
    public function sendToProductAdbox($productId): void
    {
        $languages = LanguageHelper::getActiveLanguages();
        $data      = new Request();
        foreach ($languages as $language) {
            $data[$language->code] = [
                'locale'  => $language->code,
                'visible' => true
            ];
        }
        $data['type']       = AdBoxProduct::$WAITING_ACTION;
        $data['product_id'] = $productId;
        $data['position']   = AdBoxProduct::generatePosition($data, 0);
        $data['active']     = true;

        AdBoxProduct::create($data->all());
    }
<<<<<<< HEAD
    public function storeAdditionalFields(Request $request)
    {

    }
    public function updateAdditionalFields(Product $product, Request $request)
    {

    }
=======
>>>>>>> origin/main
}
