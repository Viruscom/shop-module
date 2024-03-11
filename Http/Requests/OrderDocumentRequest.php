<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderDocumentRequest extends FormRequest
{
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

        return [
            'name'    => 'required',
            'comment' => 'required',
            'file'    => 'required',
        ];
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
            'name.required'    => trans('shop::admin.order_documents.name_required'),
            'comment.required' => trans('shop::admin.order_documents.comment_required'),
            'file.required'    => trans('shop::admin.order_documents.file_required'),
        ];
    }
}
