@extends('layouts.front.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Order</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('errors'))
                            <div class="alert alert-danger" role="alert">
                                {{ print_r(session('errors')) }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{route('basket.order.store')}}">
                            @csrf
                            <input type="hidden" name="total" value="{{$basket->total}}">
                            <input type="hidden" name="total_discounted" value="{{$basket->total_discounted}}">
                            <input type="hidden" name="total_free_delivery" value="{{$basket->total_free_delivery ? 1:0}}">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}*</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}*</label>

                                    <div class="col-md-6">
                                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}*</label>

                                    <div class="col-md-6">
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}*</label>

                                    <div class="col-md-6">
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Street') }}*</label>

                                    <div class="col-md-6">
                                        <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" required autocomplete="street" autofocus>

                                        @error('street')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="street_number" class="col-md-4 col-form-label text-md-right">{{ __('Street Number') }}*</label>

                                    <div class="col-md-6">
                                        <input id="street_number" type="text" class="form-control @error('street_number') is-invalid @enderror" name="street_number" value="{{ old('street_number') }}" required autocomplete="street_number" autofocus>

                                        @error('street_number')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}*</label>

                                    <div class="col-md-6">
                                        <select id="country_id" class="form-control @error('country_id') is-invalid @enderror" name="country_id" required autofocus>
                                            <option value="">{{__('Select')}}</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{old('country_id')==$country->id ? "selected":""}}>{{$country->name}}</option>
                                            @endforeach
                                        </select>

                                        @error('country_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="city_id" class="col-md-4 col-form-label text-md-right">{{ __('City') }}*</label>

                                    <div class="col-md-6">
                                        <select id="city_id" class="form-control @error('city_id') is-invalid @enderror" name="city_id" required autofocus>
                                            <option value="">{{__('Select')}}</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}" {{old('city_id')==$city->id ? "selected":""}}>{{$city->name}}</option>
                                            @endforeach
                                        </select>

                                        @error('city_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="zip_code" class="col-md-4 col-form-label text-md-right">{{ __('ZIP') }}*</label>

                                    <div class="col-md-6">
                                        <input type="text" id="zip_code" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" value="{{ is_null(old('zip_code')) ? session()->get('zip_code'):old('zip_code') }}" autocomplete="zip_code" required autofocus>

                                        @error('zip_code')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Invoice') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control @error('has_invoice') is-invalid @enderror" name="has_invoice" required autocomplete="has_invoice" autofocus onchange="hasInvoice(this)">
                                            <option value="0" {{old('has_invoice')==0 ? "selected='selected'":""}}>{{__('No')}}</option>
                                            <option value="1" {{old('has_invoice')==1 ? "selected='selected'":""}}>{{__('Yes')}}</option>
                                        </select>

                                        @error('has_invoice')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div id="invoice_data" style="display: {{old('has_invoice')==1 ? 'block':'none'}}">
                                    <div class="form-group row">
                                        <label for="company_name" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}*</label>

                                        <div class="col-md-6">
                                            <input id="company_name" type="text" class="invoice-required form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" {{old('has_invoice')==1 ? 'required':''}} autocomplete="company_name" autofocus>

                                            @error('company_name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_eik" class="col-md-4 col-form-label text-md-right">{{ __('EIK') }}*</label>

                                        <div class="col-md-6">
                                            <input id="company_eik" type="text" class="invoice-required  form-control @error('company_eik') is-invalid @enderror" name="company_eik" value="{{ old('company_eik') }}" {{old('has_invoice')==1 ? 'required':''}} autocomplete="company_eik" autofocus>

                                            @error('company_eik')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_vat_eik" class="col-md-4 col-form-label text-md-right">{{ __('VAT EIK') }}</label>

                                        <div class="col-md-6">
                                            <input id="company_vat_eik" type="text" class="form-control @error('company_vat_eik') is-invalid @enderror" name="company_vat_eik" value="{{ old('company_vat_eik') }}" autocomplete="company_vat_eik" autofocus>

                                            @error('company_vat_eik')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_mol" class="col-md-4 col-form-label text-md-right">{{ __('Company MOL') }}*</label>

                                        <div class="col-md-6">
                                            <input id="company_mol" type="text" class="invoice-required form-control @error('company_mol') is-invalid @enderror" name="company_mol" value="{{ old('company_mol') }}" {{old('has_invoice')==1 ? 'required':''}} autocomplete="company_mol" autofocus>

                                            @error('company_mol')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_address" class="col-md-4 col-form-label text-md-right">{{ __('Company Address') }}*</label>

                                        <div class="col-md-6">
                                            <input id="company_address" type="text" class="invoice-required form-control @error('company_address') is-invalid @enderror" name="company_address" value="{{ old('company_address') }}" {{old('has_invoice')==1 ? 'required':''}} autocomplete="company_address" autofocus>

                                            @error('company_address')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>{{__('Products')}}</div>
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <td>Product ID</td>
                                    <td>Quantity</td>
                                    <td>Single Price</td>
                                    <td>Single Quantity Price</td>
                                    <td>VAT</td>
                                    <td>Single VAT Price</td>
                                    <td>Single VAT Discounted Price</td>
                                    <td>End Price</td>
                                    <td>End Discounted Price</td>
                                    <td>Free delivery</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(is_null($basket) || $basket->basket_products->count()<1)
                                    <tr>
                                        <td colspan="11">{{__("No data")}}</td>
                                    </tr>
                                @else
                                    @foreach($basket->calculated_basket_products as $basket_product)
                                        <tr>
                                            <td>{{$basket_product->product->id}}</td>
                                            <td>{{$basket_product->product_quantity}}</td>
                                            <td>{{$basket_product->product->price}}</td>
                                            <td>{{$basket_product->price}}</td>
                                            <td>{{$basket_product->vat}}</td>
                                            <td>{{$basket_product->vat_applied_price}}</td>
                                            <td>{{$basket_product->vat_applied_discounted_price}}</td>
                                            <td>{{$basket_product->end_price}}</td>
                                            <td>{{$basket_product->end_discounted_price}}</td>
                                            <td>{{$basket_product->free_delivery ? 'Yes':'No'}}</td>

                                    @endforeach
                                    <tr>
                                        <td colspan="11">{{__("Total")}}: {{$basket->total}} / {{__("Total Discounted")}}: {{$basket->total_discounted}} / {{__('Free delivery')}}: {{$basket->total_free_delivery ? 'Yes':'No'}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <hr>
                            <div class="col-12">
                                <div class="@error('delivery_id') is-invalid @enderror">{{__('Delivery Method')}}
                                    @error('delivery_id')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                                @foreach($deliveryMethods as $deliveryMethod)
                                    <input type="radio" name="delivery_id" value="{{$deliveryMethod->id}}">
                                    <label>{{$deliveryMethod->type}}</label><br>
                                @endforeach
                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="@error('payment_id') is-invalid @enderror">{{__('Payment Method')}}
                                    @error('payment_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                @foreach($paymentMethods as $paymentMethod)
                                    <input type="radio" name="payment_id" value="{{$paymentMethod->id}}" required>
                                    <label>{{$paymentMethod->type}}</label><br>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary float-left">{{ __('Finish') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function hasInvoice(el) {
            if ($(el).val() == 1) {
                $('#invoice_data').css('display', 'block');
                $('.invoice-required').attr('required', 'required');
            } else {
                $('#invoice_data').css('display', 'none');
                $('.invoice-required').removeAttr('required');
            }
        }
    </script>
@endsection
