<?php

namespace Modules\Shop\Models\Admin;

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
use Illuminate\Support\Facades\Storage;

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
    protected    $table                = 'product_brands';
    public static function getFileRules(): string
    {
        return FileDimensionHelper::getRules('Shop', 1);
    }
    public static function getUserInfoMessage(): string
    {
        return FileDimensionHelper::getUserInfoMessage('Shop', 1);
    }
    public static function cacheUpdate(): void
    {
        cache()->forget(CacheKeysHelper::$SHOP_BRAND_ADMIN);
        cache()->forget(CacheKeysHelper::$SHOP_BRAND_FRONT);
        cache()->remember(CacheKeysHelper::$SHOP_BRAND_ADMIN, config('default.app.cache.ttl_seconds'), function () {
            return self::withTranslation()->with('translations')->orderBy('position')->get();
        });

        cache()->remember(CacheKeysHelper::$SHOP_BRAND_FRONT, config('default.app.cache.ttl_seconds'), function () {
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

        $data['logo_active'] = false;
        if ($request->has('logo_active')) {
            $data['logo_active'] = filter_var($request->logo_active, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('logo_filename')) {
            $data['logo_filename'] = $request->logo_filename;
        }

        if ($request->hasFile('image')) {
            $data['filename'] = pathinfo(CommonActions::getValidFilenameStatic($request->image->getClientOriginalName()), PATHINFO_FILENAME) . '.' . $request->image->getClientOriginalExtension();
        }

        if ($request->hasFile('logo_image')) {
            $data['logo_filename'] = pathinfo(CommonActions::getValidFilenameStatic($request->logo_image->getClientOriginalName()), PATHINFO_FILENAME) . '.' . $request->logo_image->getClientOriginalExtension();
        }

        return $data;
    }

    public static function getLangArraysOnStore($data, $request, $languages, $modelId, $isUpdate)
    {
        foreach ($languages as $language) {
            $data[$language->code] = BrandTranslation::getLanguageArray($language, $request, $modelId, $isUpdate);
        }

        return $data;
    }
    public function setKeys($array): array
    {
        //        Go to Shop Model
    }
    public function getLogoUrl(): string
    {
        if (!is_null($this->logo_filename) && Storage::disk('public')->exists($this->getFilepath($this->logo_filename))) {
            return Storage::disk('public')->url($this->getFilepath($this->logo_filename));
        }

        return url($this->getSystemImage());
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
        return AdminHelper::getSystemImage(self::$BRAND_SYSTEM_IMAGE);
    }
}
