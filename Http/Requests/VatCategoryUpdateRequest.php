<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Entities\VatCategory;

class VatCategoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $category = VatCategory::findOrFail($this->id);
        $rules    = [
            'name' => 'required|min:0|max:255|unique:vat_categories,name,' . $this->id . ',id,country_id,' . $category->country_id,
            'vat'  => 'required|numeric|between:0,100',
        ];

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
