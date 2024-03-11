<?php

namespace Modules\Shop\Http\Requests\Front\RegisteredUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonalDataUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // or implement your own authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name'       => ['required'],
            'last_name'        => ['required'],
            'email'            => ['required', 'email', Rule::unique('shop_registered_users')->ignore(decrypt($this->id))],
            'current_password' => ['required'],
        ];

        if ($this->filled('new_password')) {
            $rules['new_password']         = ['required'];
            $rules['confirm_new_password'] = ['required', 'same:new_password'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required'           => trans('shop::front.registered_user_profile.first_name_required'),
            'last_name.required'            => trans('shop::front.registered_user_profile.last_name_required'),
            'email.required'                => trans('shop::front.registered_user_profile.email_required'),
            'email.email'                   => trans('shop::front.registered_user_profile.email_invalid'),
            'email.unique'                  => trans('shop::front.registered_user_profile.email_taken'),
            'current_password.required'     => trans('shop::front.registered_user_profile.current_password_required'),
            'new_password.required'         => trans('shop::front.registered_user_profile.new_password_required'),
            'confirm_new_password.required' => trans('shop::front.registered_user_profile.confirm_new_password_required'),
            'confirm_new_password.same'     => trans('shop::front.registered_user_profile.confirm_new_password_mismatch'),
        ];
    }

}
