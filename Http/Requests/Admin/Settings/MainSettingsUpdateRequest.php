<?php

namespace Modules\Shop\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class MainSettingsUpdateRequest extends FormRequest
{
    protected $LANGUAGES;

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
    public function rules(): array
    {
        $this->trimInput();

        return [
            'shop_orders_email' => 'required|email',
            'sales_countries'   => 'required|array',
            'sales_countries.*' => 'integer|exists:countries,id',
        ];
    }
    public function trimInput(): void
    {
        $trim_if_string = static function ($var) {
            return is_string($var) ? trim($var) : $var;
        };
        $this->merge(array_map($trim_if_string, $this->all()));
    }
    public function messages()
    {
        return [
            'shop_orders_email.required' => trans('shop::admin.main_settings.email_required'),
            'shop_orders_email.email'    => trans('shop::admin.main_settings.email_invalid'),
            'sales_countries.required'   => trans('shop::admin.main_settings.countries_required'),
            'sales_countries.array'      => trans('shop::admin.main_settings.countries_array'),
            'sales_countries.*.integer'  => trans('shop::admin.main_settings.country_id_invalid'),
            'sales_countries.*.exists'   => trans('shop::admin.main_settings.country_not_exists'),
        ];
    }


}
