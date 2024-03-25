<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderReturnAmountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $this->trimInput();

        return [
            'returned_amount' => 'required|numeric|between:0,999999999.99',
            'date_of_return'  => 'required|date',
            'type_of_return'  => 'required|string',
        ];
    }

    public function trimInput()
    {
        $trim_if_string = function ($var) {
            return is_string($var) ? trim($var) : $var;
        };
        $this->merge(array_map($trim_if_string, $this->all()));
    }
    public function messages(): array
    {
        return [
            'returned_amount.required' => trans('shop::admin.returned_products.returned_amount_required'),
            'returned_amount.numeric'  => trans('shop::admin.returned_products.returned_amount_numeric'),
            'returned_amount.between'  => trans('shop::admin.returned_products.returned_amount_between'),
            'date_of_return.required'  => trans('shop::admin.returned_products.date_of_return_required'),
            'date_of_return.date'      => trans('shop::admin.returned_products.date_of_return_date'),
            'type_of_return.required'  => trans('shop::admin.returned_products.type_of_return_required'),
            'type_of_return.string'    => trans('shop::admin.returned_products.type_of_return_string'),

        ];
    }
}
