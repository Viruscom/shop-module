<?php

namespace Modules\Shop\Models;

use App\Helpers\AdminHelper;
use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Models\Admin\Brand;
use Modules\Shop\Models\Admin\ProductCategory\Category;

class Shop extends Model
{
    public function setKeys($array): array
    {
        $array[1]['sys_image_name'] = trans('shop::admin.brand.index');
        $array[1]['sys_image']      = Brand::$BRAND_SYSTEM_IMAGE;
        $array[1]['sys_image_path'] = AdminHelper::getSystemImage(Brand::$BRAND_SYSTEM_IMAGE);
        $array[1]['ratio']          = Brand::$BRAND_RATIO;
        $array[1]['mimes']          = Brand::$BRAND_MIMES;
        $array[1]['max_file_size']  = Brand::$BRAND_MAX_FILE_SIZE;
        $array[1]['file_rules']     = 'mimes:' . Brand::$BRAND_MIMES . '|size:' . Brand::$BRAND_MAX_FILE_SIZE . '|dimensions:ratio=' . Brand::$BRAND_RATIO;

        $array[2]['sys_image_name'] = trans('shop::admin.product_categories.index');
        $array[2]['sys_image']      = Category::$PRODUCT_CATEGORY_SYSTEM_IMAGE;
        $array[2]['sys_image_path'] = AdminHelper::getSystemImage(Category::$PRODUCT_CATEGORY_SYSTEM_IMAGE);
        $array[2]['ratio']          = Category::$PRODUCT_CATEGORY_RATIO;
        $array[2]['mimes']          = Category::$PRODUCT_CATEGORY_MIMES;
        $array[2]['max_file_size']  = Category::$PRODUCT_CATEGORY_MAX_FILE_SIZE;
        $array[2]['file_rules']     = 'mimes:' . Category::$PRODUCT_CATEGORY_MIMES . '|size:' . Category::$PRODUCT_CATEGORY_MAX_FILE_SIZE . '|dimensions:ratio=' . Category::$PRODUCT_CATEGORY_RATIO;

        return $array;
    }
}
