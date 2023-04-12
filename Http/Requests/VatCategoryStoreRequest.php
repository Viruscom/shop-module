<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VatCategoryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|min:0|max:255|unique:vat_categories,name,NULL,id,country_id,' . $this->id,
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
