@php use App\Helpers\WebsiteHelper; @endphp
<link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
<form action="{{ route('admin.shop.orders.edit_products_save', ['id' => $order->id]) }}" method="POST">
    @csrf

    <div class="page-wrapper">

        <div class="cart-wrapper">
            <div class="container-fluid">
                @if(is_null($basket) || $basket->basket_products->count()<1)
                    <div class="snackbar-wrapper">
                        <div class="snackbar snackbar-error">@lang('shop::front.basket.empty_basket')</div>
                    </div>
                @else
                    <div class="cart-cols">
                        <div class="col col-2of3">
                            <h3 class="title-main title-border" style="display: flex;justify-content: space-between;">
                                <span>{!! trans('shop::front.basket.index') !!}</span>
                                <button type="button" class="btn btn-success btn-sm add-product-btn2" data-toggle="modal" data-target="#myModal">Добави продукт</button>
                                @include('shop::admin.orders.add_products_modal')
                            </h3>
                            <div class="col-inner">
                                <div class="product-boxes">
                                    @if(!is_null($basket) || $basket->basket_products->count()>=1)
                                        @foreach($basket->calculated_basket_products as $basketProduct)
                                            @php
                                                $productPrint = $basketProduct->product_print;
                                            @endphp
                                            <div class="product-box">
                                                <div class="prod-content">
                                                    <div class="prod-image">
                                                        <a href="{{ $basketProduct->product->getUrl($languageSlug) }}" target="_blank"></a>
                                                        <img src="{{ $basketProduct->product->getFileUrl() }}" alt="" width="90">
                                                    </div>

                                                    <div class="prod-inner">
                                                        <div class="prod-inner-top">
                                                            <h3>
                                                                <a href="{{ $basketProduct->product->getUrl($languageSlug) }}" target="_blank">{{ $basketProduct->product->title }} / <strong>{{ $basketProduct->product->measure_unit_value }} {{ $basketProduct->product->measureUnit->title }}</strong></a>
                                                            </h3>
                                                            @if(!Auth::guard('shop')->guest() && !$basketProduct->product->isInFavoriteProducts())
                                                                <form action="{{ route('shop.registered_user.account.favorites.store', ['languageSlug' => $languageSlug, 'id' => $basketProduct->product->id]) }}" method="post">
                                                                    @csrf
                                                                    <button type="submit" class="prod-fav" style="height: 20px;"></button>
                                                                </form>
                                                            @endif

                                                            @if(!Auth::guard('shop')->guest() && $basketProduct->product->isInFavoriteProducts())
                                                                <form action="{{ route('shop.registered_user.account.favorites.delete', ['languageSlug' => $languageSlug, 'id' => $basketProduct->product->id]) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="prod-fav active" style="height: 20px;"></button>
                                                                </form>
                                                            @endif

                                                        </div>

                                                        <div class="prod-inner-content">
                                                            <div class="prod-qty hover-images">
                                                                <div class="input-group-prod">
                                                                    <form action="{{ route('admin.shop.orders.edit_products_add_product', ['id' => $order->id]) }}" method="post" class="d-inline-block">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id" value="{{ $basketProduct->product->id }}">
                                                                        <input type="hidden" name="product_print" value="{{ is_null($basketProduct->product_print) ? '' : $basketProduct->product_print }}">
                                                                        <input type="hidden" name="product_quantity" value="-1">
                                                                        <a href="#" data-quantity="minus" data-field="quantity" onclick="$(this).closest('form').submit();">-</a>
                                                                    </form>

                                                                    <input class="input-group-field" type="number" name="quantity" value="{{$basketProduct->product_quantity}}" readonly="">

                                                                    <form action="{{ route('admin.shop.orders.edit_products_add_product', ['id' => $order->id]) }}" method="post" class="d-inline-block">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id" value="{{ $basketProduct->product->id }}">
                                                                        <input type="hidden" name="product_print" value="{{ is_null($basketProduct->product_print) ? '' : $basketProduct->product_print }}">
                                                                        <a href="#" data-quantity="plus" data-field="quantity" onclick="$(this).closest('form').submit();">+</a>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="prod-prices">
                                                                <span>ед. цена</span>
                                                                @if($basketProduct->vat_applied_default_price !== $basketProduct->vat_applied_discounted_price)
                                                                    <p class="main-price price-old">
                                                                        {{ number_format($basketProduct->vat_applied_default_price, 2, '.', '') }} {{ __('front.currency') }} </p>

                                                                    <p class="new-price">
                                                                        {{ number_format($basketProduct->vat_applied_discounted_price, 2, '.', '')}} {{ __('front.currency') }} </p>
                                                                @else
                                                                    <p class="main-price">
                                                                        {{ number_format($basketProduct->vat_applied_default_price, 2, '.', '') }} {{ __('front.currency') }} </p>
                                                                @endif
                                                            </div>

                                                            <div class="prod-actions">
                                                                <span>стойност</span>

                                                                <div class="prod-actions-inner">
                                                                    <div class="prod-total">{{ number_format($basketProduct->end_discounted_price, 2, '.', '') }} {{ __('front.currency') }}</div>
                                                                    <form action="{{ route('admin.shop.orders.edit_products_add_product', ['id' => $order->id]) }}" method="post" class="d-inline-block">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id" value="{{ $basketProduct->product->id }}">
                                                                        <input type="hidden" name="product_print" value="{{ is_null($basketProduct->product_print) ? '' : $basketProduct->product_print }}">
                                                                        <input type="hidden" name="product_quantity" value="0">
                                                                        <button class="remove-prod" type="submit">X</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="prod-additions">
                                                    @if($basketProduct->additives->isNotEmpty())
                                                        <div class="addition-box addition-box-green">
                                                            <h4>Добавки:</h4>

                                                            @foreach($basketProduct->additives as $additive)
                                                                <div class="box-row">
                                                                    <span>+</span>

                                                                    <p>
                                                                        {{ $additive->productAdditive->title }} </p>

                                                                    <div class="aside">
                                                                        <p class="quantity">{{ $basketProduct->product_quantity * $additive->quantity }}</p>
                                                                        <p>{{ number_format($additive->price, 2, '.', '') }} {{ __('front.currency') }}</p>
                                                                        <form action="{{ route('admin.shop.orders.edit_products_remove_extension', ['id' => $order->id]) }}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="product_id" value="{{ $basketProduct->id }}">
                                                                            <input type="hidden" name="product_print" value="{{ is_null($basketProduct->product_print) ? '' : $basketProduct->product_print }}">
                                                                            <input type="hidden" name="extension_id" value="{{ $additive->id }}">
                                                                            <input type="hidden" name="extension_type" value="additives">
                                                                            <button type="submit" class="remove-prod">X</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    @if($basketProduct->additiveExcepts->isNotEmpty())
                                                        <div class="addition-box addition-box-orange">
                                                            <h4>Без:</h4>

                                                            <p>
                                                                @foreach($basketProduct->additiveExcepts as $additive)
                                                                    {{$additive->productAdditive->title}}
                                                                    @if(!$loop->last)
                                                                        {{ ', ' }}
                                                                    @endif
                                                                @endforeach
                                                            </p>
                                                        </div>
                                                    @endif

                                                    @if($basketProduct->productCollection->isNotEmpty())
                                                        <div class="addition-box">
                                                            <h4>Комбинирай с...</h4>

                                                            @foreach($basketProduct->productCollection as $collectionProduct)
                                                                <div class="box-row">
                                                                    <span>+</span>

                                                                    <p>
                                                                        {{ $collectionProduct->product->title }} </p>

                                                                    <div class="aside">
                                                                        <p class="quantity">{{ $basketProduct->product_quantity }}</p>
                                                                        <p>{{ number_format($collectionProduct->price, 2, '.', '') }} {{ __('front.currency') }}</p>
                                                                        <form action="{{ route('admin.shop.orders.edit_products_remove_extension', ['id' => $order->id]) }}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="product_id" value="{{ $basketProduct->id }}">
                                                                            <input type="hidden" name="product_print" value="{{ is_null($basketProduct->product_print) ? '' : $basketProduct->product_print }}">
                                                                            <input type="hidden" name="extension_id" value="{{ $collectionProduct->id }}">
                                                                            <input type="hidden" name="extension_type" value="collection">
                                                                            <button type="submit" class="remove-prod">X</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="prod-box-total">
                                                    <p>
                                                        Крайна цена:
                                                        <strong>{{ number_format($basketProduct->end_discounted_price_with_add_and_coll, 2, '.', '') }} {{ __('front.currency') }}</strong>
                                                    </p>
                                                </div>
                                                {{--                                                <div class="prod-gifts prod-gifts-inner">--}}
                                                {{--                                                    <h3>Вашите подаръци:</h3>--}}

                                                {{--                                                    <div class="prod-gift">--}}
                                                {{--                                                        <div class="prod-gift-img">--}}
                                                {{--                                                            <a href="">--}}
                                                {{--                                                                <img src="assets/images/gift-1.png" alt="">--}}
                                                {{--                                                            </a>--}}
                                                {{--                                                        </div>--}}

                                                {{--                                                        <div class="prod-gift-content">--}}
                                                {{--                                                            <div class="prod-gift-content-inner">--}}
                                                {{--                                                                <h3>--}}
                                                {{--                                                                    <a href="">Домашна лимоната / <strong>200 мл</strong></a>--}}
                                                {{--                                                                </h3>--}}

                                                {{--                                                                <img src="assets/icons/gift.svg" alt="">--}}
                                                {{--                                                            </div>--}}

                                                {{--                                                            <div class="prod-gift-aside">--}}
                                                {{--                                                                <p>0.00 лв.</p>--}}
                                                {{--                                                            </div>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}

                                                {{--                                                    <div class="prod-gift">--}}
                                                {{--                                                        <div class="prod-gift-img">--}}
                                                {{--                                                            <a href="">--}}
                                                {{--                                                                <img src="assets/images/gift-1.png" alt="">--}}
                                                {{--                                                            </a>--}}
                                                {{--                                                        </div>--}}

                                                {{--                                                        <div class="prod-gift-content">--}}
                                                {{--                                                            <div class="prod-gift-content-inner">--}}
                                                {{--                                                                <h3>--}}
                                                {{--                                                                    <a href="">Домашна лимоната / <strong>200 мл</strong></a>--}}
                                                {{--                                                                </h3>--}}

                                                {{--                                                                <img src="assets/icons/gift.svg" alt="">--}}
                                                {{--                                                            </div>--}}

                                                {{--                                                            <div class="prod-gift-aside">--}}
                                                {{--                                                                <p>0.00 лв.</p>--}}
                                                {{--                                                            </div>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col col-1of3">
                            <h3 class="title-main title-border">{{ __('shop::front.basket.summary') }}</h3>

                            <div class="col-inner">
                                <div class="summary-boxes">
                                    <div class="box">
                                        <div class="box-row">
                                            <span>{{ __('shop::front.basket.products_prices') }}</span>

                                            <strong>{{ number_format($basket->total_default, 2, '.', '') }} {{ __('front.currency') }}</strong>
                                        </div>

                                        <div class="box-row box-row-promo">
                                            @if($basket->promo_code)
                                                <div class="promo-info">
                                                    {{ __('shop::front.basket.you_use_promo_code') }}: {{ $basket->promo_code }}
                                                </div>
                                                <div class="delete-promo-code">
                                                    <a href="{{ route('admin.shop.orders.edit_products_delete_promo_code', ['id' => $order->id]) }}">{{ __('shop::front.basket.delete_promo_code') }}</a>
                                                </div>
                                            @endif

                                            <div class="form-wrapper form-wrapper-alt">
                                                <form method="post" enctype="multipart/form-data" action="{{ route('admin.shop.orders.edit_products_apply_promo_code', ['id' => $order->id]) }}">
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
                                        </div>

                                        <div class="box-row box-row-warning">
                                            <span>{{ __('shop::front.basket.total_discounts') }}</span>

                                            <strong>- {{number_format($basket->total_default - $basket->total_discounted, 2, '.', '')}} {{ __('front.currency') }}</strong>
                                        </div>
                                    </div>

                                    <div class="box">
                                        <div class="box-row box-row-big">
                                            <span>{{ __('shop::front.basket.total_with_vat') }}</span>

                                            <strong>{{ number_format($basket->total_discounted, 2, '.', '') }} {{ __('front.currency') }}</strong>
                                        </div>

                                        {{--                                        <p class="shoping-info-discount">Остават ви 85.00 лв до безплатна доставка.</p>--}}

                                        {{--                                        <p class="shoping-info-discount shoping-info-discount-alt">{{ __('shop::front.basket.shipping_ang_taxes_calc_on_checkout') }}</p>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 p-0">
                        <div class="bg-grey top-search-bar" style="margin-bottom: 0px;">
                            <div class="action-mass-buttons pull-right">
                                <button type="submit" class="btn btn-lg btn-success margin-bottom-10">{{ __('admin.save') }}</button>
                                <a href="{{ route('admin.shop.orders.edit_products_cancel', ['id' => $order->id]) }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</form>
