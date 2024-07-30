<?php

    namespace Modules\Shop\Models;

    use App\Helpers\AdminHelper;
    use App\Traits\HasModelRatios;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Shop\Models\Admin\Brands\Brand;
    use Modules\Shop\Models\Admin\ProductCategory\Category;
    use Modules\Shop\Models\Admin\Products\Product;

    class Shop extends Model
    {
        use HasModelRatios;
        
        public const CURRENCY_DECIMALS            = 2;
        public const CURRENCY_SEPARATOR           = ',';
        public const CURRENCY_THOUSANDS_SEPARATOR = '';

        public static function allocateModule($viewArray)
        {
            switch (class_basename($viewArray['currentModel']->parent)) {
                case 'Product':
                    return view('shop::front.products.show', ['viewArray' => $viewArray]);
                case 'Brand':
                    return view('shop::front.brands.show', ['viewArray' => $viewArray]);
                case 'Category':
                    $categories = Category::where('active', true)->whereNull('main_category')->with('translations')->with(['subCategories' => function ($q) {
                        return $q->orderBy('position');
                    }])->orderBy('position')->get();
                    $brands     = Brand::where('active', true)->with('translations')->orderBy('position')->get();

                    return view('shop::front.categories.show', ['viewArray' => $viewArray, 'categories' => $categories, 'brands' => $brands]);
                default:
                    abort(404);
            }
        }

        public static function getDashboardInfo(): array
        {
            $data = [];

            return $data;
        }

        public static function getShopBrandsSpecialPage($viewArray)
        {
            return view('shop::front.shop_special_page', [
                'viewArray' => $viewArray,
                'brands'    => Brand::where('active', true)->orderBy('position', 'asc')->get()
            ]);
        }

        public static function formatPrice($price)
        {
            return number_format($price, self::CURRENCY_DECIMALS, self::CURRENCY_SEPARATOR, self::CURRENCY_THOUSANDS_SEPARATOR);
        }

        public function setKeys($array): array
        {
            $array[1]['sys_image_name'] = trans('shop::admin.product_brands.index');
            $array[1]['sys_image']      = Brand::$BRAND_SYSTEM_IMAGE;
            $array[1]['sys_image_path'] = AdminHelper::getSystemImage(Brand::$BRAND_SYSTEM_IMAGE);
            $array[1]['field_name']     = 'brand';
            $array[1]['ratio']          = self::getModelRatio('brand');
            $array[1]['mimes']          = self::getModelMime('brand');
            $array[1]['max_file_size']  = self::getModelMaxFileSize('brand');
            $array[1]['file_rules']     = 'mimes:' . self::getModelMime('brand') . '|size:' . self::getModelMaxFileSize('brand') . '|dimensions:ratio=' . self::getModelRatio('brand');

            $array[2]['sys_image_name'] = trans('shop::admin.product_categories.index');
            $array[2]['sys_image']      = Category::$PRODUCT_CATEGORY_SYSTEM_IMAGE;
            $array[2]['sys_image_path'] = AdminHelper::getSystemImage(Category::$PRODUCT_CATEGORY_SYSTEM_IMAGE);
            $array[2]['field_name']     = 'product_category';
            $array[2]['ratio']          = self::getModelRatio('product_category');
            $array[2]['mimes']          = self::getModelMime('product_category');
            $array[2]['max_file_size']  = self::getModelMaxFileSize('product_category');
            $array[2]['file_rules']     = 'mimes:' . self::getModelMime('product_category') . '|size:' . self::getModelMaxFileSize('product_category') . '|dimensions:ratio=' . self::getModelRatio('product_category');

            $array[3]['sys_image_name'] = trans('shop::admin.products.index');
            $array[3]['sys_image']      = Product::$PRODUCT_SYSTEM_IMAGE;
            $array[3]['sys_image_path'] = AdminHelper::getSystemImage(Product::$PRODUCT_SYSTEM_IMAGE);
            $array[3]['field_name']     = 'product';
            $array[3]['ratio']          = self::getModelRatio('product');
            $array[3]['mimes']          = self::getModelMime('product');
            $array[3]['max_file_size']  = self::getModelMaxFileSize('product');
            $array[3]['file_rules']     = 'mimes:' . self::getModelMime('product') . '|size:' . self::getModelMaxFileSize('product') . '|dimensions:ratio=' . self::getModelRatio('product');

            return $array;
        }
    }
