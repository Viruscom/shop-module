<?php

    namespace Modules\Shop\Http\Requests\Admin\RegisteredUser;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Rule;

    class AdminRegisteredUserUpdateRequest extends FormRequest
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
            $this->trimInput();

            $rules = [
                'first_name'      => 'required',
                'last_name'       => 'required',
                'email'           => ['required', 'email', Rule::unique('shop_registered_users')->ignore(Request::segment(4))],
                'client_group_id' => 'required|between:1,8',
                'password'        => 'nullable|min:6',
            ];

            if (!empty($this->input('birthday'))) {
                $rules['birthday'] = [
                    'required',
                    'date',
                    'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                ];
            }

            return $rules;
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
                'first_name.required'      => trans('shop::admin.registered_users.first_name_required'),
                'last_name.required'       => trans('shop::admin.registered_users.last_name_required'),
                'email.required'           => trans('shop::admin.registered_users.email_required'),
                'email.email'              => trans('shop::admin.registered_users.email_invalid'),
                'email.unique'             => trans('shop::admin.registered_users.email_unique'),
                'password.required'        => trans('shop::admin.registered_users.password_required'),
                'password.min'             => trans('shop::admin.registered_users.password_min'),
                'client_group_id.required' => trans('shop::admin.registered_users.group_id_required'),
                'client_group_id.between'  => trans('shop::admin.registered_users.group_id_invalid'),
                'birthday.required'        => trans('shop::admin.registered_users.birthday_required'),
                'birthday.date'            => trans('shop::admin.registered_users.birthday_date'),
                'birthday.before_or_equal' => trans('shop::admin.registered_users.birthday_before_or_equal'),
            ];
        }
    }
