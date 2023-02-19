<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdBoxProductTranslation extends Model
{
    protected $table    = "product_adbox_translation";
    protected $fillable = ['language_id', 'product_adbox_id', 'title'];
    public static function getCreateData($language, $request): array
    {
        return [
            'language_id' => $language->id,
            'title'       => $request['title_' . $language->code]
        ];
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    public function getUpdateData($language, $request): array
    {
        return [
            'language_id' => $language->id,
            'title'       => $request['title_' . $language->code]
        ];
    }
}
