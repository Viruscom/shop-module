<?php

    namespace Modules\Shop\Models\Admin\Brands;

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
    use Illuminate\Support\Facades\Storage;

    class Brand extends Model implements TranslatableContract, ImageModelInterface
    {
        use Translatable, Scopes, StorageActions, CommonActions, HasGallery;

        public const FILES_PATH     = "images/shop/brands";
        const        ALLOW_CATALOGS = false;
        const        ALLOW_ICONS    = false;
        const        ALLOW_LOGOS    = false;

        public static string $BRAND_SYSTEM_IMAGE = 'shop_1_image.png';

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
            cache()->rememberForever(CacheKeysHelper::$SHOP_BRAND_ADMIN, function () {
                return self::withTranslation()->with('translations')->orderBy('position')->get();
            });

            cache()->rememberForever(CacheKeysHelper::$SHOP_BRAND_FRONT, function () {
                return self::active(true)->orderBy('position')->with('translations')->get();
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

        public function getUrl()
        {
            if (!is_null($this->url)) {
                if ($this->external_url) {
                    return $this->url;
                }

                return url($this->url);
            }

            return '';
        }
    }
