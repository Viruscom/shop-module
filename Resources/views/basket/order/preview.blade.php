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
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}*</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" disabled value="{{ $order->email }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}*</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control" disabled value="{{ $order->first_name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}*</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control" disabled value="{{ $order->last_name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}*</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" disabled value="{{ $order->phone }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Street') }}*</label>

                                <div class="col-md-6">
                                    <input id="street" type="text" class="form-control" disabled value="{{ $order->street }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street_number" class="col-md-4 col-form-label text-md-right">{{ __('Street Number') }}*</label>

                                <div class="col-md-6">
                                    <input id="street_number" type="text" class="form-control" disabled value="{{ $order->street_number }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}*</label>

                                <div class="col-md-6">
                                    <span>{{$order->country->name}}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city_id" class="col-md-4 col-form-label text-md-right">{{ __('City') }}*</label>

                                <div class="col-md-6">
                                    <span>{{$order->city->name}}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="zip_code" class="col-md-4 col-form-label text-md-right">{{ __('ZIP') }}*</label>

                                <div class="col-md-6">
                                    <input type="text" id="zip_code" class="form-control" disabled value="{{ $order->zip_code }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Invoice') }}</label>

                                <div class="col-md-6">
                                    {{$order->has_invoice}}
                                </div>
                            </div>
                            @if($order->has_invoice == 1)
                                <div id="invoice_data">
                                    <div class="form-group row">
                                        <label for="company_name" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}*</label>

                                        <div class="col-md-6">
                                            <input id="company_name" type="text" class="form-control" disabled value="{{ $order->company_name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_eik" class="col-md-4 col-form-label text-md-right">{{ __('EIK') }}*</label>

                                        <div class="col-md-6">
                                            <input id="company_eik" type="text" class="form-control" disabled value="{{ $order->company_eik }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_vat_eik" class="col-md-4 col-form-label text-md-right">{{ __('VAT EIK') }}</label>

                                        <div class="col-md-6">
                                            <input id="company_vat_eik" type="text" class="form-control" disabled value="{{ $order->company_vat_eik }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_mol" class="col-md-4 col-form-label text-md-right">{{ __('Company MOL') }}*</label>

                                        <div class="col-md-6">
                                            <input id="company_mol" type="text" class="form-control" disabled value="{{ $order->company_mol }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="company_address" class="col-md-4 col-form-label text-md-right">{{ __('Company Address') }}*</label>

                                        <div class="col-md-6">
                                            <input id="company_address" type="text" class="form-control" disabled value="{{ $order->company_address }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                            @foreach($order->order_products as $order_product)
                                <tr>
                                    <td>{{$order_product->product->id}}</td>
                                    <td>{{$order_product->product_quantity}}</td>
                                    <td>{{$order_product->product->price}}</td>
                                    <td>{{$order_product->price}}</td>
                                    <td>{{$order_product->vat}}</td>
                                    <td>{{$order_product->vat_applied_price}}</td>
                                    <td>{{$order_product->vat_applied_discounted_price}}</td>
                                    <td>{{$order_product->end_price}}</td>
                                    <td>{{$order_product->end_discounted_price}}</td>
                                    <td>{{$order_product->free_delivery ? 'Yes':'No'}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="11">{{__("Total")}}: {{$order->total}} / {{__("Total Discounted")}}: {{$order->total_discounted}} / {{__('Free delivery')}}: {{$order->total_free_delivery ? 'Yes':'No'}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="col-12">
                            <div>{{__('Delivery Method')}}</div>
                            <label>{{$order->delivery->type}}</label><br>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div>{{__('Payment Method')}}</div>
                            <label>{{$order->payment->type}}</label><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
