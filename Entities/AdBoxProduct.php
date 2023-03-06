<?php

namespace Modules\Shop\Entities;

use App\Helpers\LanguageHelper;
use App\Models\AdBoxProductTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Shop\Models\Admin\Products\Product;

class AdBoxProduct extends Model
{
    public static int $WAITING_ACTION = 0;
    public static int $FIRST_TYPE     = 1;

    protected $table    = 'product_adboxes';
    protected $fillable = ['active', 'position', 'type', 'product_id', 'filename'];

    public static function getTypes(): array
    {
        return [self::$FIRST_TYPE];
    }

    public static function generatePosition($request, $AdBoxType): int
    {
        $adboxes = self::where('type', $AdBoxType)->orderBy('position', 'desc')->get();
        if (count($adboxes) < 1) {
            return 1;
        }
        if (!$request->has('position') || is_null($request['position'])) {
            return $adboxes->first()->position + 1;
        }

        if ($request['position'] > $adboxes->first()->position) {
            return $adboxes->first()->position + 1;
        }
        $adboxesToUpdate = self::where('type', $AdBoxType)->where('position', '>=', $request['position'])->get();
        self::updateAdBoxPosition($adboxesToUpdate, true);

        return $request['position'];
    }
    /**
     * Update adbox position
     *
     * @param $adboxes / Adboxes to update
     * @param bool $increment / Increment (true) or decrement (false)
     *
     * @return void
     */
    private static function updateAdBoxPosition($adboxes, $increment = true): void
    {
        foreach ($adboxes as $AdBoxUpdate) {
            $position = ($increment) ? $AdBoxUpdate->position + 1 : $AdBoxUpdate->position - 1;
            $AdBoxUpdate->update(['position' => $position]);
        }
    }
    public static function getCreateData($request)
    {
        $data               = self::getRequestData($request);
        $data['type']       = self::$WAITING_ACTION;
        $data['product_id'] = $request->product_id;
        $data['filename']   = $request->filename;

        if ($request->has('type')) {
            $data['type'] = $request['type'];
        }

        return $data;
    }
    private static function getRequestData($request)
    {
        $data = [
            'position' => $request->position
        ];

        $data['active'] = true;

        return $data;
    }

    public function updatedPosition($request, $adBox, $AdBoxType): int
    {
        if ($adBox->type == 0) {
            $lastPosition        = self::where('type', $AdBoxType)->get()->max('position');
            $request['position'] = $lastPosition + 1;

            return $request['position'];
        }

        if (!$request->has('position') || is_null($request->position) || $request->position == $this->position) {
            return $this->position;
        }

        $adboxes = self::where('type', $AdBoxType)->orderBy('position', 'desc')->get();
        if (count($adboxes) == 1) {
            $request['position'] = 1;

            return $request['position'];
        }

        if ($request['position'] > $adboxes->first()->position) {
            $request['position'] = $adboxes->first()->position;
        } elseif ($request['position'] < $adboxes->last()->position) {
            $request['position'] = $adboxes->last()->position;
        }

        if ($request['position'] >= $this->position) {
            $adboxesToUpdate = self::where('type', $AdBoxType)->where('id', '<>', $this->id)->where('position', '>', $this->position)->where('position', '<=', $request['position'])->get();
            self::updateAdBoxPosition($adboxesToUpdate, false);

            return $request['position'];
        }

        $adboxesToUpdate = self::where('type', $AdBoxType)->where('id', '<>', $this->id)->where('position', '<', $this->position)->where('position', '>=', $request['position'])->get();
        self::updateAdBoxPosition($adboxesToUpdate, true);

        return $request['position'];
    }
    public function getUpdateData($request)
    {
        $data = self::getRequestData($request);
        if ($request->has('type')) {
            $data['type'] = $request['type'];
        }

        $data['active'] = true;

        return $data;
    }
    public function scopeActive($query, $active)
    {
        return $query->where('active', $active);
    }
    public function scopeOrderByPosition($query, $type)
    {
        return $query->orderBy('position', $type);
    }
    public function scopeWaitingAction($query)
    {
        return $query->where('type', self::$WAITING_ACTION);
    }
    public function scopeFirstType($query)
    {
        return $query->where('type', self::$FIRST_TYPE);
    }

    /**
     * Get translation by language id
     *
     * @param $languageId
     *
     * @return HasOne
     */
    public function getTranslation($languageId): HasOne
    {
        return $this->hasOne(AdBoxProductTranslation::class, 'product_adbox_id')->where('language_id', $languageId);
    }
    public function translations()
    {
        return $this->hasMany(AdBoxProductTranslation::class, 'product_adbox_id');
    }

    public function currentTranslation(): HasOne
    {
        $currentLanguage = LanguageHelper::getCurrentLanguage();

        return $this->hasOne(AdBoxProductTranslation::class, 'product_adbox_id')->where('language_id', $currentLanguage->id);
    }

    public function defaultTranslation(): HasOne
    {
        $defaultLanguage = LanguageHelper::getDefaultLanguage();

        return $this->hasOne(AdBoxProductTranslation::class, 'product_adbox_id')->where('language_id', $defaultLanguage->id);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
