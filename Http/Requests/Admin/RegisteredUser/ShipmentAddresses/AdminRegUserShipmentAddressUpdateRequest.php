<?php

namespace Modules\Shop\Http\Requests\Admin\RegisteredUser\ShipmentAddresses;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRegUserShipmentAddressUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        return [
            'name'          => 'required',
            'street'        => 'required',
            'street_number' => 'required',
            'country_id'    => ['required', Rule::exists('countries', 'id')],
            'city_id'       => ['required', Rule::exists('cities', 'id')],
            'zip_code'      => 'required',
            'is_default'    => 'boolean',
            'is_deleted'    => 'boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'          => trans('shop::admin.registered_users.name_required'),
            'street.required'        => trans('shop::admin.registered_users.street_required'),
            'street_number.required' => trans('shop::admin.registered_users.street_number_required'),
            'country_id.required'    => trans('shop::admin.registered_users.country_id_required'),
            'country_id.exists'      => trans('shop::admin.registered_users.country_id_exists'),
            'city_id.required'       => trans('shop::admin.registered_users.city_id_required'),
            'city_id.exists'         => trans('shop::admin.registered_users.city_id_exists'),
            'zip_code.required'      => trans('shop::admin.registered_users.zip_code_required'),
            'is_default.boolean'     => trans('shop::admin.registered_users.is_default_boolean'),
            'is_deleted.boolean'     => trans('shop::admin.registered_users.is_deleted_boolean'),
        ];
    }

    public function trimInput()
    {
        $trim_if_string = function ($var) {
            return is_string($var) ? trim($var) : $var;
        };
        $this->merge(array_map($trim_if_string, $this->all()));
    }
}
