<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;

class AdBoxProductTranslation extends Model
{


    protected $table    = "product_adboxes_translation";
    protected $fillable = ['locale', 'ad_box_product_id', 'visible'];
    public static function getCreateData($language, $request): array
    {
        return [
            'locale'  => $language->code,
            'visible' => filter_var($request['visible_' . $language->code], FILTER_VALIDATE_BOOLEAN)
        ];
    }
    public function getUpdateData($language, $request): array
    {
        $data = [
            'locale' => $language->code,
        ];

        $data['visible'] = false;
        if ($request->has('visible_' . $language->code)) {
            $data['visible'] = filter_var($request['visible_' . $language->code], FILTER_VALIDATE_BOOLEAN);
        }

        return $data;
    }
}
