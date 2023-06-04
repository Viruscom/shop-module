<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email'         => 'required|email',
            'first_name'    => 'required|string|min:2|max:255',
            'last_name'     => 'required|string|min:2|max:255',
            'phone'         => 'required|string|min:2|max:255',
            'street'        => 'required|string|min:2',
            'street_number' => 'required|string|min:2',
            'country_id'    => 'required|exists:countries,id',
            'city_id'       => 'required|exists:cities,id,country_id,' . $this->country_id,
            'zip_code'      => 'required|string|min:2|max:255',
            'payment_id'    => 'required|exists:payments,id,active,1',
            'delivery_id'   => 'required|exists:deliveries,id,active,1'
        ];

        if ($this->has('invoice_required') && $this->invoice_required) {
            $rules['company_name']    = 'required|string|min:2|max:255';
            $rules['company_eik']     = 'required|string|min:2|max:255';
            $rules['company_mol']     = 'required|string|min:2|max:255';
            $rules['company_address'] = 'required|string|min:2|max:255';
        }

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
