<?php

namespace Modules\Shop\Models;

use App\Helpers\AdminHelper;
use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Models\Admin\Brand;

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

        return $array;
    }
}
