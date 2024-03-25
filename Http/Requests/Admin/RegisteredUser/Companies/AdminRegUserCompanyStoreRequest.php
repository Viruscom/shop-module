<?php

    namespace Modules\Shop\Http\Requests\Admin\RegisteredUser\Companies;

    use Illuminate\Foundation\Http\FormRequest;

    class AdminRegUserCompanyStoreRequest extends FormRequest
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
                'email'           => 'required|email',
                'phone'           => 'required',
                'street'          => 'required',
                'street_number'   => 'required',
                'country_id'      => 'nullable|integer',
                'city_id'         => 'nullable|integer',
                'zip_code'        => 'nullable',
                'company_name'    => 'required',
                'company_eik'     => 'required',
                'company_vat_eik' => 'nullable',
                'company_mol'     => 'required',
                'company_address' => 'required',
                'is_default'      => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
                    },
                ],
                'is_deleted'      => 'boolean',
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
                'email.required'           => trans('shop::admin.registered_users.email_required'),
                'email.email'              => trans('shop::admin.registered_users.email_email'),
                'phone.required'           => trans('shop::admin.registered_users.phone_required'),
                'street.required'          => trans('shop::admin.registered_users.street_required'),
                'street_number.required'   => trans('shop::admin.registered_users.street_number_required'),
                'country_id.integer'       => trans('shop::admin.registered_users.country_id_integer'),
                'city_id.integer'          => trans('shop::admin.registered_users.city_id_integer'),
                'zip_code'                 => trans('shop::admin.registered_users.zip_code'),
                'company_name.required'    => trans('shop::admin.registered_users.company_name_required'),
                'company_eik.required'     => trans('shop::admin.registered_users.company_eik_required'),
                'company_vat_eik'          => trans('shop::admin.registered_users.company_vat_eik'),
                'company_mol.required'     => trans('shop::admin.registered_users.company_mol_required'),
                'company_address.required' => trans('shop::admin.registered_users.company_address_required'),
                'is_default.boolean'       => trans('shop::admin.registered_users.is_default_boolean'),
                'is_deleted.boolean'       => trans('shop::admin.registered_users.is_deleted_boolean'),
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
