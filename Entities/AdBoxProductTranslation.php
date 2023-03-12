<?php

namespace Modules\Shop\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdBoxProductTranslation extends Model implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['visible'];
    protected    $table                = "product_adbox_translation";
    protected    $fillable             = ['code', 'product_adbox_id', 'title'];
    public static function getCreateData($language, $request): array
    {
        return [
            'locale'  => $language->code,
            'visible' => filter_var($request['visible_' . $language->code], FILTER_VALIDATE_BOOLEAN)
        ];
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    public function getUpdateData($language, $request): array
    {
        $data = [
            'language_id' => $language->id,
            'title'       => $request['title_' . $language->code]
        ];

        $data['visible'] = false;
        if ($request->has('visible_' . $language->code)) {
            $data['visible'] = filter_var($request['visible_' . $language->code], FILTER_VALIDATE_BOOLEAN);
        }

        return $data;
    }
}
