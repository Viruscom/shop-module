<?php

namespace Modules\Shop\Models\Admin\ProductCategory;

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

class Category extends Model implements TranslatableContract, ImageModelInterface
{
    use Translatable, Scopes, StorageActions, CommonActions;

    public const FILES_PATH = "images/shop/product_categories";

    public static string $PRODUCT_CATEGORY_SYSTEM_IMAGE  = 'product_category_1_image.png';
    public static string $PRODUCT_CATEGORY_RATIO         = '1/1';
    public static string $PRODUCT_CATEGORY_MIMES         = 'jpg,jpeg,png,gif';
    public static string $PRODUCT_CATEGORY_MAX_FILE_SIZE = '3000';

    public array $translatedAttributes = ['title', 'announce', 'description'];
    protected    $fillable             = ['active', 'position', 'filename', 'creator_user_id'];
    protected    $table                = 'product_categories';

    public static function getFileRules(): string
    {
        return FileDimensionHelper::getRules('Shop', 2);
    }
    public static function getUserInfoMessage(): string
    {
        return FileDimensionHelper::getUserInfoMessage('Shop', 2);
    }
    public static function cacheUpdate(): void
    {
        cache()->forget(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN);
        cache()->forget(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_FRONT);
        cache()->remember(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN, config('default.app.cache.ttl_seconds'), function () {
            return self::withTranslation()->with('translations')->orderBy('position')->get();
        });

        cache()->remember(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_FRONT, config('default.app.cache.ttl_seconds'), function () {
            return self::active(true)->orderBy('position')->withTranslation()->get();
        });
    }
    public static function getRequestData($request): array
    {
        $data = [
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
            $data[$language->code] = CategoryTranslation::getLanguageArray($language, $request, $modelId, $isUpdate);
        }

        return $data;
    }
    public function setKeys($array): array
    {
        //        Go to Shop Model
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
        return AdminHelper::getSystemImage(self::$PRODUCT_CATEGORY_SYSTEM_IMAGE);
    }
}
