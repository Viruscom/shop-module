<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Entities\State;

class StateVatCategoryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $state = State::findOrFail($this->id);
        $rules = [
            'vat_category_id' => 'required|exists:vat_categories,id,country_id,' . $state->country->id . '|unique:state_vat_categories,vat_category_id,NULL,id,state_id,' . $this->id,
            'vat'             => 'required|numeric|between:0,100',
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
