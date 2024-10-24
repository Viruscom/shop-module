<?php

    namespace Modules\Shop\Actions;

    use App\Classes\ProductHelper;
    use App\Helpers\CacheKeysHelper;
    use App\Helpers\LanguageHelper;
    use App\Models\Files\File;
    use Cache;
    use Illuminate\Http\Request;
    use Modules\AdBoxes\Models\AdBox;
    use Modules\Shop\Entities\AdBoxProduct\AdBoxProduct;
    use Modules\Shop\Entities\Settings\MeasureUnit;
    use Modules\Shop\Models\Admin\Brands\Brand;
    use Modules\Shop\Models\Admin\ProductCategory\Category;
    use Modules\Shop\Models\Admin\Products\ProductAdditionalField;
    use Modules\Shop\Models\Admin\Products\ProductVatCategory;

    class ProductAction
    {
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

        public function checkForMeasureUnitsCache(): void
        {
            if (is_null(Cache::get(CacheKeysHelper::$SHOP_MEASURE_UNITS_ADMIN))) {
                MeasureUnit::cacheUpdate();
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
            AdBoxProduct::cacheUpdate();
        }

        public function createOrUpdateAdditionalFields(Request $request, $product)
        {
            $languages = LanguageHelper::getActiveLanguages();

            $maxFields = ProductAdditionalField::MAX_FIELDS;

            foreach ($languages as $language) {
                for ($f = 1; $f <= $maxFields; $f++) {
                    $data = ProductAdditionalField::getData($language, $request, $f);

                    $additionalField = ProductAdditionalField::updateOrCreate(
                        ['product_id' => $product->id, 'locale' => $data['locale'], 'field_id' => $data['field_id']],
                        ['name' => $data['name'], 'text' => $data['text']]
                    );

                    $product->additionalFields()->save($additionalField);
                }
            }
        }

        public function sendToAdBox($product): void
        {
            $languages = LanguageHelper::getActiveLanguages();
            $data      = new Request();
            foreach ($languages as $language) {
                $productTitle          = is_null($product->translate($language->code)) ? $product->title : $product->translate($language->code)->title;
                $productUrl            = is_null($product->translate($language->code)) ? $product->url : $product->translate($language->code)->url;
                $productAnnounce       = is_null($product->translate($language->code)) ? $product->announce : $product->translate($language->code)->announce;
                $data[$language->code] = [
                    'locale'            => $language->code,
                    'title'             => $productTitle,
                    'short_description' => $productAnnounce,
                    'url'               => $productUrl,
                    'visible'           => true
                ];
            }
            $data['type']     = AdBox::$WAITING_ACTION;
            $data['position'] = AdBox::generatePositionForWaitingAdBox();
            $data['active']   = true;

            AdBox::create($data->all());
            AdBox::cacheUpdate();
        }

        public function updateVatCategoriesByCountry($product, $saleCountries)
        {
            ProductVatCategory::where('product_id', $product->id)->delete();
            $this->storeVatCategoriesByCountry($product, $saleCountries);
        }

        public function storeVatCategoriesByCountry($product, $saleCountries)
        {
            foreach ($saleCountries as $countryId => $vatArray) {
                ProductVatCategory::create([
                                               'product_id'      => $product->id,
                                               'vat_category_id' => $vatArray['vat_category'],
                                           ]);
            }
        }

        public function positionUp($modelClass, $model)
        {
            $previousModel = $modelClass::where('category_id', $model->category_id)->where('position', $model->position - 1)->first();
            if (!is_null($previousModel)) {
                $previousModel->update(['position' => $previousModel->position + 1]);
                $model->update(['position' => $model->position - 1]);
            }
        }

        public function positionDown($modelClass, $model)
        {
            $nextModel = $modelClass::where('category_id', $model->category_id)->where('position', $model->position + 1)->first();
            if (!is_null($nextModel)) {
                $nextModel->update(['position' => $nextModel->position - 1]);
                $model->update(['position' => $model->position + 1]);
            }
        }
    }
