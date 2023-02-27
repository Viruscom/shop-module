<?php

namespace Modules\Shop\Entities;

use App\Helpers\AdminHelper;
use App\Helpers\FileDimensionHelper;
use App\Interfaces\Models\ImageModelInterface;
use App\Traits\CommonActions;
use App\Traits\Scopes;
use App\Traits\StorageActions;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model implements TranslatableContract, ImageModelInterface
{
    use Translatable, Scopes, StorageActions, CommonActions;

    public const FILES_PATH = "images/shop/brands";

    public static string $BRAND_SYSTEM_IMAGE  = 'brand_1_image.png';
    public static string $BRAND_RATIO         = '1/1';
    public static string $BRAND_MIMES         = 'jpg,jpeg,png,gif';
    public static string $BRAND_MAX_FILE_SIZE = '3000';

    public array $translatedAttributes = ['title', 'announce', 'description', 'visible', 'url'];
    protected    $fillable             = ['active', 'position', 'filename', 'creator_user_id', 'logo_filename', 'logo_active'];
    public static function getFileRules(): string
    {
        return FileDimensionHelper::getRules('Brand', 1);
    }
    public static function getUserInfoMessage(): string
    {
        return FileDimensionHelper::getUserInfoMessage('Brand', 1);
    }
    public function setKeys($array): array
    {
        $array[1]['sys_image_name'] = trans('shop::admin.brand.index');
        $array[1]['sys_image']      = self::$BRAND_SYSTEM_IMAGE;
        $array[1]['sys_image_path'] = AdminHelper::getSystemImage(self::$BRAND_SYSTEM_IMAGE);
        $array[1]['ratio']          = self::$BRAND_RATIO;
        $array[1]['mimes']          = self::$BRAND_MIMES;
        $array[1]['max_file_size']  = self::$BRAND_MAX_FILE_SIZE;
        $array[1]['file_rules']     = 'mimes:' . self::$BRAND_MIMES . '|size:' . self::$BRAND_MAX_FILE_SIZE . '|dimensions:ratio=' . self::$BRAND_RATIO;

        return $array;
    }
    public function getSystemImage(): string
    {
        return AdminHelper::getSystemImage(self::$BRAND_SYSTEM_IMAGE);
    }
    public function getFilepath($filename): string
    {
        return $this->getFilesPath() . $filename;
    }
    public function getFilesPath(): string
    {
        return self::FILES_PATH . '/' . $this->id . '/';
    }
}
