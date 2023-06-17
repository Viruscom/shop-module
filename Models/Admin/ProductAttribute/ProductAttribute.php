<?php

namespace Modules\Shop\Models\Admin\ProductAttribute;

use App\Classes\LanguageHelper;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductAttribute extends Model
{
    protected $table    = 'product_attributes';
    protected $fillable = ['position', 'active', 'type'];
    public static function getCreateData($request): array
    {
        return self::getRequestData($request);
    }
    private static function getRequestData($request): array
    {
        $data['position'] = $request->position;
        $data['type']     = $request->type;
        $data['active']   = false;
        if ($request->has('active')) {
            $data['active'] = $request->boolean('active');
        }

        return $data;
    }
    public static function generatePosition($request): int
    {
        $cities = self::orderBy('position', 'desc')->get();
        if (count($cities) < 1) {
            return 1;
        }
        if (!$request->has('position') || is_null($request['position'])) {
            return $cities->first()->position + 1;
        }

        if ($request['position'] > $cities->first()->position) {
            return $cities->first()->position + 1;
        }
        $citiesToUpdate = self::where('position', '>=', $request['position'])->get();
        foreach ($citiesToUpdate as $cityToUpdate) {
            $cityToUpdate->update(['position' => $cityToUpdate->position + 1]);
        }

        return $request['position'];
    }
    protected static function boot(): void
    {
        parent::boot();

        static::created(static function () {
            self::updateCache();
        });

        static::updated(static function () {
            self::updateCache();
        });

        static::deleted(static function () {
            self::updateCache();
        });
    }
    public static function updateCache()
    {
        Cache::forget('adminProductAttributes');

        return Cache::remember('adminProductAttributes', config('app.cache_ttl_seconds'), static function () {
            return self::orderBy('position', 'asc')->with('translations', 'defaultTranslation')->get();
        });
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class);
    }
    public function translations(): HasMany
    {
        return $this->hasMany(ProductAttributeTranslation::class, 'pattr_id', 'id');
    }
    public function getUpdateData($request): array
    {
        return self::getRequestData($request);
    }
    public function updatedPosition($request)
    {
        if (!$request->has('position') || is_null($request->position) || $request->position == $this->position) {
            return $this->position;
        }

        $cities = self::orderBy('position', 'desc')->get();
        if (count($cities) == 1) {
            $request['position'] = 1;

            return $request['position'];
        }

        if ($request['position'] > $cities->first()->position) {
            $request['position'] = $cities->first()->position;
        } elseif ($request['position'] < $cities->last()->position) {
            $request['position'] = $cities->last()->position;
        }

        if ($request['position'] >= $this->position) {
            $citiesToUpdate = self::where('id', '<>', $this->id)->where('position', '>', $this->position)->where('position', '<=', $request['position'])->get();
            foreach ($citiesToUpdate as $cityToUpdate) {
                $cityToUpdate->update(['position' => $cityToUpdate->position - 1]);
            }

            return $request['position'];
        }

        $citiesToUpdate = self::where('id', '<>', $this->id)->where('position', '<', $this->position)->where('position', '>=', $request['position'])->get();
        foreach ($citiesToUpdate as $cityToUpdate) {
            $cityToUpdate->update(['position' => $cityToUpdate->position + 1]);
        }

        return $request['position'];
    }
    public function defaultTranslation(): HasOne
    {
        $defaultLanguage = LanguageHelper::getDefaultLanguage();

        return $this->hasOne(ProductAttributeTranslation::class, 'pattr_id', 'id')->where('language_id', $defaultLanguage->id);
    }
    public function currentTranslation(): HasOne
    {
        $currentLanguage = LanguageHelper::getCurrentLanguage();

        return $this->hasOne(ProductAttributeTranslation::class, 'pattr_id', 'id')->where('language_id', $currentLanguage->id);
    }
}
