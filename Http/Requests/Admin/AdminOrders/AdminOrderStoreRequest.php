<?php

    namespace Modules\Shop\Http\Requests\Admin\AdminOrders;

    use Illuminate\Foundation\Http\FormRequest;

    class AdminOrderStoreRequest extends FormRequest
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
            $rules = [
                'firm_account_id' => 'required|numeric',
                'country_id'      => 'required|numeric',
                'city_id'         => 'required|numeric',
                'new_address'     => 'required|string',
                'street'          => 'required|string|max:255',
                'street_number'   => 'required|string|max:255',
                'zip_code'        => 'required|string|max:255',
            ];

            if (empty($this->input('client_id'))) {
                $rules += [
                    'first_name' => 'required|string|max:255',
                    'last_name'  => 'required|string|max:255',
                    'email'      => 'required|email',
                    'phone'      => 'required|string',
                ];
            }

            if ($this->input('firm_account_id') != 0 && !$this->has('firmAccount')) {
            } elseif ($this->has('firmAccount')) {
                $rules += [
                    'firmAccount.country'              => 'required|string|max:255',
                    'firmAccount.city'                 => 'required|string|max:255',
                    'firmAccount.registration_address' => 'required|string|max:255',
                    'firmAccount.phone'                => 'nullable|string',
                    'firmAccount.title'                => 'required|string|max:255',
                    'firmAccount.mol'                  => 'required|string|max:255',
                    'firmAccount.eik'                  => 'required|string|max:255',
                    'firmAccount.vat'                  => 'nullable|string',
                ];
            }

            return $rules;
        }

        /**
         * Get custom messages for validator errors.
         *
         * @return array
         */
        public function messages()
        {
            return [
                'first_name.required'                       => 'Името на госта е задължително.',
                'last_name.required'                        => 'Фамилията на госта е задължителна.',
                'email.required'                            => 'E-mail адресът на госта е задължителен.',
                'email.email'                               => 'E-mail адресът трябва да е валиден.',
                'phone.required'                            => 'Телефонният номер на госта е задължителен.',
                'firmAccount.country.required'              => 'Държавата за фирмената сметка е задължителна.',
                'firmAccount.city.required'                 => 'Градът за фирмената сметка е задължителен.',
                'firmAccount.registration_address.required' => 'Адресът на регистрация на фирмата е задължителен.',
                'firmAccount.phone.nullable'                => 'Телефонът на фирмата е незадължителен.',
                'firmAccount.title.required'                => 'Името на фирмата е задължително.',
                'firmAccount.mol.required'                  => 'М.О.Л. на фирмата е задължителен.',
                'firmAccount.eik.required'                  => 'ЕИК на фирмата е задължителен.',
                'firmAccount.vat.nullable'                  => 'Булстат по ДДС на фирмата е незадължителен.',
                'country_id.required'                       => 'Полето за идентификационния номер на държавата е задължително.',
                'city_id.required'                          => 'Полето за идентификационния номер на града е задължително.',
                'new_address.required'                      => 'Полето за адрес е задължително.',
                'street.required'                           => 'Полето за улица е задължително.',
                'street_number.required'                    => 'Полето за номер на улицата е задължително.',
                'zip_code.required'                         => 'Полето за пощенски код е задължително.',
            ];
        }
    }
