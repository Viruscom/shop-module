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
use Modules\Shop\Entities\AdBoxProduct;
use Modules\Shop\Entities\AdBoxProductTranslation;
use Modules\Shop\Models\Admin\Brand;
use Modules\Shop\Models\Admin\ProductCategory\Category;

class ProductAction
{
    public function generateProductAdBox()
    {

    }
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
    public function sendToProductAdbox($productId)
    {
        $languages = LanguageHelper::getActiveLanguages();
        $data      = new Request();
        foreach ($languages as $language) {
            $data['visible_' . $language->code] = true;
        }
        $data['product_id'] = $productId;
        $data['position']   = AdBoxProduct::generatePosition($data, 0);

        $adBox = AdBoxProduct::create(AdBoxProduct::getCreateData($data));
        foreach ($languages as $language) {
            $adBox->translations()->create(AdBoxProductTranslation::getCreateData($language, $data));
        }
    }
}
