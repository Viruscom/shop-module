<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCollectionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->trimInput();

        return [
            'title'           => 'required|min:2|max:255',
            'main_product_id' => 'required|min:1|exists:products,id',
        ];
    }
    public function trimInput()
    {
        $trim_if_string = function ($var) {
            return is_string($var) ? trim($var) : $var;
        };
        $this->merge(array_map($trim_if_string, $this->all()));
    }
    public function messages()
    {
        return [
            'title.required'           => trans('shop::admin.product_collections.title_required'),
            'title.min'                => trans('shop::admin.product_collections.title_min'),
            'title.max'                => trans('shop::admin.product_collections.title_max'),
            'main_product_id.required' => trans('shop::admin.product_collections.main_product_id_required'),
            'main_product_id.min'      => trans('shop::admin.product_collections.main_product_id_min'),
            'main_product_id.exists'   => trans('shop::admin.product_collections.main_product_id_exists'),
        ];
    }

}
