@extends('layouts.front.app')

@section('content')
    <div class="page-wrapper">
        @include('shop::basket.breadcrumbs')

        <div class="cart-wrapper">
            <div class="shell">
                @include('front.notify')
                <div class="cart-cols">
                    <div class="col col-2of3">
                        <h3 class="title-main title-border">{!! trans('shop::front.basket.index') !!}</h3>

                        <div class="col-inner">
                            {{--                            <div class="box-warning">--}}
                            {{--                                <p>Някои от избраните продукти в момента не са налични.</p>--}}
                            {{--                            </div>--}}

                            {{--                            <div class="box-info">--}}
                            {{--                                <img src="{{ asset('front/assets/icons/gift-box.svg') }}" alt="">--}}

                            {{--                                <p>--}}
                            {{--                                    Изберете <strong>2 подаръка</strong> от нашите предложения в периода 01-31 януари--}}
                            {{--                                </p>--}}
                            {{--                            </div>--}}

                            <div class="product-boxes">
                                @if(is_null($basket) || $basket->basket_products->count()<1)
                                    <div class="box-warning">
                                        <p>@lang('shop::front.basket.empty_basket')</p>
                                    </div>
                                @else
                                    @foreach($basket->calculated_basket_products as $basketProduct)
                                        <div class="product-box">
                                            <div class="prod-content">
                                                <div class="prod-image">
                                                    <a href="{{ $basketProduct->product->getUrl($languageSlug) }}"></a>
                                                    <img src="{{ $basketProduct->product->getFileUrl() }}" alt="">
                                                </div>

                                                <div class="prod-inner">
                                                    <h3><a href="{{ $basketProduct->product->getUrl($languageSlug) }}">{{ $basketProduct->product->title }}</a></h3>

                                                    <div class="prod-prices">
                                                        @if($basketProduct->vat_applied_default_price !== $basketProduct->vat_applied_discounted_price)
                                                            <p class="main-price price-old">
                                                                <b>{{ $basketProduct->vat_applied_default_price }}</b> лв. </p>

                                                            <p class="new-price">
                                                                <b>{{$basketProduct->vat_applied_discounted_price}}</b> лв. </p>
                                                        @else
                                                            <p class="new-price">
                                                                <b>{{ $basketProduct->vat_applied_default_price }}</b> лв. </p>
                                                        @endif

                                                        <p class="new-price">
                                                            <b>Стойност: {{ $basketProduct->vat_applied_default_price }}</b> лв. </p>
                                                    </div>

                                                    <div class="prod-qty hover-images">
                                                        <div class="input-group">
                                                            <a href="" data-quantity="minus" data-field="quantity">-</a>

                                                            <input class="input-group-field" type="number" name="quantity" value="{{$basketProduct->product_quantity}}">

                                                            <a href="" data-quantity="plus" data-field="quantity">+</a>
                                                        </div>

                                                        <a href="" class="prod-fav">
                                                            <img src="{{ asset('front/assets/icons/heart-alt.svg') }}" alt="">

                                                            <img src="{{ asset('front/assets/icons/heart-alt-hover.svg') }}" alt="">
                                                        </a>
                                                    </div>

                                                    <div class="prod-actions">
                                                        <a href="" class="remove-prod">@lang('shop::front.basket.remove_product')</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- prod EXTRAS -->
                                            @if($basketProduct->isInCollection)
                                                <div class="prod-extras">
                                                    <h4>В комплект с:</h4>

                                                    <div class="product-box">
                                                        <div class="prod-content">
                                                            <div class="prod-image">
                                                                <a href=""></a>
                                                                <img src="assets/images/prod-img.png" alt="">
                                                            </div>

                                                            <div class="prod-inner">
                                                                <h3><a href="">Shampoo for all hair types</a></h3>

                                                                <div class="prod-prices">
                                                                    <p class="main-price price-old">
                                                                        <b>25.00</b> лв. </p>

                                                                    <p class="new-price">
                                                                        <b>23.00</b> лв. </p>
                                                                </div>

                                                                <div class="prod-actions">
                                                                    <a href="" class="remove-prod">Remove</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="product-box">
                                                        <div class="prod-content">
                                                            <div class="prod-image">
                                                                <a href=""></a>
                                                                <img src="assets/images/prod-img.png" alt="">
                                                            </div>

                                                            <div class="prod-inner">
                                                                <h3><a href="">Shampoo for all hair types</a></h3>

                                                                <div class="prod-prices">
                                                                    <p class="main-price price-old">
                                                                        <b>25.00</b> лв. </p>

                                                                    <p class="new-price">
                                                                        <b>23.00</b> лв. </p>
                                                                </div>

                                                                <div class="prod-actions">
                                                                    <a href="" class="remove-prod">Remove</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h4 class="title-warning">Продуктът не е наличен!</h4>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <tr>
                                            <td></td>
                                            <td>{{$basketProduct->product->price}}</td>
                                            <td></td>
                                            <td>{{$basketProduct->vat}}</td>
                                            <td>{{$basketProduct->vat_applied_price}}</td>
                                            <td>{{$basketProduct->vat_applied_discounted_price}}</td>
                                            <td>{{$basketProduct->end_price}}</td>
                                            <td>{{$basketProduct->end_discounted_price}}</td>
                                            <td>{{$basketProduct->free_delivery ? 'Yes':'No'}}</td>
                                            <td>
                                                <form method="post" action="{{route('basket.products.add')}}">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$basketProduct->product->id}}">
                                                    <input type="hidden" name="product_quantity" value="-1">
                                                    <span class="btn btn-warning" onclick="$(this).closest('form').submit();">Decrement</span>
                                                </form>
                                                <form method="post" action="{{route('basket.products.add')}}">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$basketProduct->product->id}}">
                                                    <span class="btn btn-success" onclick="$(this).closest('form').submit();">Increment</span>
                                                </form>
                                                <form method="post" action="{{route('basket.products.add')}}">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$basketProduct->product->id}}">
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
                                            <a href="" class="btn btn-success">{{__('Order')}}</a>
                                        </td>
                                    </tr>
                                @endif

                            </div>

                            {{--                            <div class="product-boxes gift-boxes">--}}
                            {{--                                <h3>Your gifts</h3>--}}

                            {{--                                <div class="product-box">--}}
                            {{--                                    <div class="prod-content">--}}
                            {{--                                        <div class="prod-image">--}}
                            {{--                                            <a href=""></a>--}}
                            {{--                                            <img src="assets/images/prod-img.png" alt="">--}}
                            {{--                                        </div>--}}

                            {{--                                        <div class="prod-inner">--}}
                            {{--                                            <h3>Shampoo for all hair types and scalps for</h3>--}}

                            {{--                                            <div class="prod-prices">--}}
                            {{--                                                <p class="main-price">--}}
                            {{--                                                    <b>0.00</b> лв.--}}
                            {{--                                                </p>--}}
                            {{--                                            </div>--}}

                            {{--                                            <div class="prod-gift-info">--}}
                            {{--                                                <img src="assets/icons/gift-box.svg" alt="">--}}

                            {{--                                                <span class="info-wrapper">--}}
                            {{--													<strong>Подарък</strong>--}}

                            {{--													<span class="info-text">При поръчка над 75 лв избери 2 подаръка</span>--}}
                            {{--												</span>--}}
                            {{--                                            </div>--}}

                            {{--                                            <div class="prod-actions">--}}
                            {{--                                                <a href="" class="remove-prod">Remove</a>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            {{--                                <div class="product-box">--}}
                            {{--                                    <div class="prod-content">--}}
                            {{--                                        <div class="prod-image missing-prod">--}}
                            {{--                                            <a href=""></a>--}}
                            {{--                                            <img src="assets/images/prod-img.png" alt="">--}}
                            {{--                                        </div>--}}

                            {{--                                        <div class="prod-inner">--}}
                            {{--                                            <h3>Shampoo for all hair types and scalps for</h3>--}}

                            {{--                                            <div class="prod-prices">--}}
                            {{--                                                <p class="main-price">--}}
                            {{--                                                    <b>0.00</b> лв.--}}
                            {{--                                                </p>--}}
                            {{--                                            </div>--}}

                            {{--                                            <div class="prod-gift-info">--}}
                            {{--                                                <img src="assets/icons/gift-box.svg" alt="">--}}

                            {{--                                                <span class="info-wrapper">--}}
                            {{--													<strong>Подарък</strong>--}}

                            {{--													<span class="info-text">При поръчка над 75 лв избери 2 подаръка</span>--}}
                            {{--												</span>--}}
                            {{--                                            </div>--}}

                            {{--                                            <div class="prod-actions">--}}
                            {{--                                                <a href="" class="remove-prod">Remove</a>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}

                            {{--                                    <h4 class="title-warning">Продуктът не е наличен!</h4>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>

                    <div class="col col-1of3">
                        <h3 class="title-main title-border">Обобщение</h3>

                        <div class="col-inner">
                            <div class="summary-boxes">
                                <div class="box">
                                    <div class="box-row">
                                        <span>Цена на продуктите</span>

                                        <strong>{{$basket->total_default}} лв.</strong>
                                    </div>

                                    <div class="box-row box-row-promo">
                                        <div class="promo-info">
                                            Кодът ви е добавен успешно!
                                        </div>

                                        <div class="promo-info promo-info-warning">
                                            Кодът не е валиден или е грешен.
                                        </div>

                                        <div class="form-wrapper form-wrapper-alt">
                                            <form method="post" enctype="multipart/form-data" action="{{ route('basket.apply-promo-code') }}">
                                                @csrf
                                                <div class="form-body">
                                                    <div class="form-row">
                                                        <div class="input-container">
                                                            <input id="promo-code" class="promo-code" type="text" name="promo_code" placeholder="Код за отстъпка">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-footer">
                                                    <button type="submit" class="submit-button" value="приложи">приложи</button>
                                                </div>
                                            </form>
                                        </div>

                                        @if($basket->promo_code)
                                            <div class="promo-info">
                                                Вие ползвате Промо код: {{ $basket->promo_code }}
                                            </div>
                                            <br>
                                            <div class="delete-promo-code">
                                                <a href="{{ route('basket.delete-promo-code') }}">Изтрий промо код</a>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="box-row box-row-warning">
                                        <span>Общо отстъпки</span>

                                        <strong>- {{$basket->total_default - $basket->total_discounted}} лв.</strong>
                                    </div>
                                </div>

                                <div class="box">
                                    <div class="box-row box-row-big">
                                        <span>Общо с ДДС</span>

                                        <strong>{{ $basket->total_discounted }} лв.</strong>
                                    </div>

                                    <p>Остават ви 85.00 лв до безплатна доставка.</p>

                                    <p>{{ __('shop::front.basket.shipping_ang_taxes_calc_on_checkout') }}</p>
                                </div>

                                <div class="box-actions">
                                    <a href="{{route('basket.order.create')}}" class="btn btn-black">{{ __('shop::front.basket.go_to_checkout') }}</a>

                                    <a href="" class="btn btn-outline">{{ __('shop::front.basket.continue_shipping') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



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
                                @foreach($basket->calculated_basket_products as $basketProduct)
                                    <tr>
                                        <td>{{$basketProduct->product->id}}</td>
                                        <td>{{$basketProduct->product_quantity}}</td>
                                        <td>{{$basketProduct->product->price}}</td>
                                        <td>{{$basketProduct->price}}</td>
                                        <td>{{$basketProduct->vat}}</td>
                                        <td>{{$basketProduct->vat_applied_price}}</td>
                                        <td>{{$basketProduct->vat_applied_discounted_price}}</td>
                                        <td>{{$basketProduct->end_price}}</td>
                                        <td>{{$basketProduct->end_discounted_price}}</td>
                                        <td>{{$basketProduct->free_delivery ? 'Yes':'No'}}</td>
                                        <td>
                                            <form method="post" action="{{route('basket.products.add')}}">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$basketProduct->product->id}}">
                                                <input type="hidden" name="product_quantity" value="-1">
                                                <span class="btn btn-warning" onclick="$(this).closest('form').submit();">Decrement</span>
                                            </form>
                                            <form method="post" action="{{route('basket.products.add')}}">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$basketProduct->product->id}}">
                                                <span class="btn btn-success" onclick="$(this).closest('form').submit();">Increment</span>
                                            </form>
                                            <form method="post" action="{{route('basket.products.add')}}">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$basketProduct->product->id}}">
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
