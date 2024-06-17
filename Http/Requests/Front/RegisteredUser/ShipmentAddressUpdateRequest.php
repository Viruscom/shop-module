<?php

    namespace Modules\Shop\Http\Requests\Front\RegisteredUser;

    use Auth;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class ShipmentAddressUpdateRequest extends FormRequest
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
            $userId = Auth::guard('shop')->user()->id;

            return [
                'name'          => [
                    'required',
                    Rule::unique('shop_reg_user_shipment_addresses')
                        ->where(function ($query) use ($userId) {
                            return $query->where('user_id', $userId);
                        })
                        ->ignore($this->segment(5)),
                ],
                'street'        => 'required',
                'street_number' => 'required',
                'country_id'    => ['required', Rule::exists('countries', 'id')],
                'state_id'      => ['required', Rule::exists('states', 'id')],
                'city_id'       => ['required', Rule::exists('cities', 'id')],
                'zip_code'      => 'required',
                'is_default'    => 'boolean',
                'is_deleted'    => 'boolean',
                'entrance'      => 'nullable|string',
                'floor'         => 'nullable|string',
                'apartment'     => 'nullable|string',
                'bell_name'     => 'nullable|string',
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
                'name.unique'            => 'Името на адреса трябва да е уникално',
                'street.required'        => trans('shop::admin.registered_users.street_required'),
                'street_number.required' => trans('shop::admin.registered_users.street_number_required'),
                'country_id.exists'      => trans('shop::admin.registered_users.country_id_exists'),
                'state_id.required'      => trans('shop::admin.registered_users.state_id_required'),
                'state_id.exists'        => trans('shop::admin.registered_users.state_id_exists'),
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
