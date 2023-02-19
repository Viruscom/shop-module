<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdBoxProductTranslation extends Model
{
    protected $table    = "product_adbox_translation";
    protected $fillable = ['language_id', 'product_adbox_id', 'title'];

    public function adbox()
    {
        return $this->belongsTo(AdBox::class, 'product_adbox_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public static function getCreateData($language, $request)
    {
        $data = [
            'language_id' => $language->id,
            'title'       => $request['title_' . $language->code]
        ];

        return $data;
    }

    public function getUpdateData($language, $request)
    {
        $data = [
            'language_id' => $language->id,
            'title'       => $request['title_' . $language->code]
        ];

        return $data;
    }
}
