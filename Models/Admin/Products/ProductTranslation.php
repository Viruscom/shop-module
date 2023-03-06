<?php

namespace Modules\Shop\Models\Admin\Products;

use App\Helpers\UrlHelper;
use App\Interfaces\Models\CommonModelTranslationInterfaces;
use App\Models\CategoryPage\CategoryPage;
use App\Models\Language;
use App\Traits\StorageActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTranslation extends Model implements CommonModelTranslationInterfaces
{
    use StorageActions;

    protected $table    = "product_translation";
    protected $fillable = ['locale', 'product_id', 'title', 'url', 'announce', 'description', 'visible', 'seo_title', 'seo_description',
                           'height', 'width', 'depth', 'weight', 'facebook_script', 'google_script', 'title_additional_first', 'title_additional_second', 'title_additional_third',
                           'title_additional_fourth', 'title_additional_fifth', 'title_additional_sixth', 'text_additional_first', 'text_additional_second',
                           'text_additional_third', 'text_additional_fourth', 'text_additional_fifth', 'text_additional_sixth'];
    public static function getLanguageArray($language, $request, $modelId, $isUpdate): array
    {
        $data = [
            'locale' => $language->code,
            'title'  => $request['title_' . $language->code],
            'url'    => UrlHelper::generate($request['title_' . $language->code], 'ProductTranslation', $modelId, $isUpdate)
        ];

        if ($request->has('announce_' . $language->code)) {
            $data['announce'] = $request['announce_' . $language->code];
        }

        if ($request->has('description_' . $language->code)) {
            $data['description'] = $request['description_' . $language->code];
        }

        $data['visible'] = false;
        if ($request->has('visible_' . $language->code)) {
            $data['visible'] = filter_var($request['visible_' . $language->code], FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('seo_title_' . $language->code)) {
            $data['seo_title'] = $request['seo_title_' . $language->code];
        }

        if ($request->has('seo_description_' . $language->code)) {
            $data['seo_description'] = $request['seo_description_' . $language->code];
        }

        if ($request->has('facebook_script_' . $language->code)) {
            $data['facebook_script'] = $request['facebook_script_' . $language->code];
        }

        if ($request->has('google_script_' . $language->code)) {
            $data['google_script'] = $request['google_script_' . $language->code];
        }

        if ($request->has('title_additional_first_' . $language->code)) {
            $data['title_additional_first'] = $request['title_additional_first_' . $language->code];
        }

        if ($request->has('title_additional_second_' . $language->code)) {
            $data['title_additional_second'] = $request['title_additional_second_' . $language->code];
        }

        if ($request->has('title_additional_third_' . $language->code)) {
            $data['title_additional_third'] = $request['title_additional_third_' . $language->code];
        }

        if ($request->has('title_additional_fourth_' . $language->code)) {
            $data['title_additional_fourth'] = $request['title_additional_fourth_' . $language->code];
        }

        if ($request->has('title_additional_fifth_' . $language->code)) {
            $data['title_additional_fifth'] = $request['title_additional_fifth_' . $language->code];
        }

        if ($request->has('title_additional_sixth_' . $language->code)) {
            $data['title_additional_sixth'] = $request['title_additional_sixth_' . $language->code];
        }

        if ($request->has('text_additional_first_' . $language->code)) {
            $data['text_additional_first'] = $request['text_additional_first_' . $language->code];
        }

        if ($request->has('text_additional_second_' . $language->code)) {
            $data['text_additional_second'] = $request['text_additional_second_' . $language->code];
        }

        if ($request->has('text_additional_third_' . $language->code)) {
            $data['text_additional_third'] = $request['text_additional_third_' . $language->code];
        }

        if ($request->has('text_additional_fourth_' . $language->code)) {
            $data['text_additional_fourth'] = $request['text_additional_fourth_' . $language->code];
        }

        if ($request->has('text_additional_fifth_' . $language->code)) {
            $data['text_additional_fifth'] = $request['text_additional_fifth_' . $language->code];
        }

        if ($request->has('text_additional_sixth_' . $language->code)) {
            $data['text_additional_sixth'] = $request['text_additional_sixth_' . $language->code];
        }

        return $data;
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(CategoryPage::class, 'category_page_id');
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
