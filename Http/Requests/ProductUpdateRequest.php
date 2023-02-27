<?php

namespace Modules\Shop\Http\Requests;

use App\Helpers\LanguageHelper;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    protected $LANGUAGES;

    public function __construct()
    {
        $this->LANGUAGES = LanguageHelper::getActiveLanguages();
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
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $this->trimInput();

        return [
            'weight' => ['nullable', 'min:0.01', 'max:99999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'width'  => ['nullable', 'min:0.01', 'max:99999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'height' => ['nullable', 'min:0.01', 'max:99999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'length' => ['nullable', 'min:0.01', 'max:99999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }
    public function trimInput(): void
    {
        $trim_if_string = function ($var) {
            return is_string($var) ? trim($var) : $var;
        };
        $this->merge(array_map($trim_if_string, $this->all()));
    }
    public function messages(): array
    {
        return [
            'weight.regex' => 'Полето за тегло трябва да е от типа 0.00',
            'weight.min'   => 'Полето за тегло трябва да е минимум 0.01',
            'weight.max'   => 'Полето за тегло трябва да е максимум 99999.99',

            'width.regex' => 'Полето за широчина трябва да е от типа 0.00',
            'width.min'   => 'Полето за широчина трябва да е минимум 0.01',
            'width.max'   => 'Полето за широчина трябва да е максимум 99999.99',

            'height.regex' => 'Полето за височина трябва да е от типа 0.00',
            'height.min'   => 'Полето за височина трябва да е минимум 0.01',
            'height.max'   => 'Полето за височина трябва да е максимум 99999.99',

            'length.regex' => 'Полето за височина трябва да е от типа 0.00',
            'length.min'   => 'Полето за височина трябва да е минимум 0.01',
            'length.max'   => 'Полето за височина трябва да е максимум 99999.99',
        ];
    }
}
