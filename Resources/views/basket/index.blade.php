@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Basket
                        <div class="col-12">
                            <form method="POST" action="{{route('user.location.set')}}">
                                @csrf
                                <div class="form-group row">
                                    <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

                                    <div class="col-md-6">
                                        <select id="country_id" class="form-control @error('country_id') is-invalid @enderror" name="country_id" autofocus>
                                            <option value="">{{__('Select')}}</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{session()->get('country_id')==$country->id ? "selected":""}}>{{$country->name}}</option>
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
                                    <label for="city_id" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                                    <div class="col-md-6">
                                        <select id="city_id" class="form-control @error('city_id') is-invalid @enderror" name="city_id" autofocus>
                                            <option value="">{{__('Select')}}</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}" {{session()->get('city_id')==$city->id ? "selected":""}}>{{$city->name}}</option>
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
                                    <label for="zip_code" class="col-md-4 col-form-label text-md-right">{{ __('ZIP') }}</label>

                                    <div class="col-md-6">
                                        <input type="text" id="zip_code" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" value="{{ session()->get('zip_code') }}" autocomplete="zip_code" autofocus>

                                        @error('zip_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary float-right">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
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
                                <td>ACTION</td>
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
                                        <td>
                                            <form method="post" action="{{route('basket.products.add')}}">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$basket_product->product->id}}">
                                                <input type="hidden" name="product_quantity" value="-1">
                                                <span class="btn btn-warning" onclick="$(this).closest('form').submit();">Decrement</span>
                                            </form>
                                            <form method="post" action="{{route('basket.products.add')}}">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$basket_product->product->id}}">
                                                <span class="btn btn-success" onclick="$(this).closest('form').submit();">Increment</span>
                                            </form>
                                            <form method="post" action="{{route('basket.products.add')}}">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$basket_product->product->id}}">
                                                <input type="hidden" name="product_quantity" value="0">
                                                <span class="btn btn-danger" onclick="$(this).closest('form').submit();">Delete</span>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="11">{{__("Total")}}: {{$basket->total}} / {{__("Total Discounted")}}: {{$basket->total_discounted}} / {{__('Free delivery')}}: {{$basket->total_free_delivery ? 'Yes':'No'}}</td>
                                </tr>
                                <tr>
                                    <td colspan="11">
                                        <a href="{{route('basket.order.create')}}" class="btn btn-success">{{__('Order')}}</a>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
