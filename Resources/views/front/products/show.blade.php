@extends('layouts.front.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/plugins/cubeportfolio/css/cubeportfolio.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/plugins/cubeportfolio/css/remove_padding.css') }}">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('/front/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/front/plugins/cubeportfolio/js/main.js') }}"></script>
@endsection
@section('content')
    @include('front.partials.inner_header')
    @include('front.partials.breadcrumbs')
    @php
        $product = $viewArray['currentModel']->parent;
    @endphp
    <section class="section-article">
        <article class="article-single">
            <div class="shell">
                <div class="article-head">
                    <div class="article-info">
                        <p class="brand" data-aos="fade-up" data-aos-delay="50">
                            <a href="">Brilliance</a>
                        </p>

                        <p class="path" data-aos="fade-up" data-aos-delay="50">
                            <a href="" class="link-more link-more-alt">Products</a>
                        </p>
                    </div>

                    <h3 class="article-title" data-aos="fade-up" data-aos-delay="150">{{ $viewArray['currentModel']->title }}</h3>
                </div>

                <div class="product-wrapper">
                    <div class="product-main">
                        <div class="prod-aside">
                            <div class="prod-image">
                                <img src="{{ $product->getFileUrl() }}" alt="" class="">
                            </div>

                            <div class="promos-wrapper">
                                <span class="promo">2 = 1</span>

                                <span class="promo">-25 %</span>
                                @if($product->isNewProduct())
                                    <span class="promo promo-new">NEW</span>
                                @endif
                            </div>
                        </div>

                        <div class="prod-content">
                            <form method="post" enctype="multipart/form-data" id="" action="{{ route('basket.products.add') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <div class="prod-price">
                                    @if($product->hasDiscounts())
                                        <p class="price-old"><b>{{ $product->getVatPrice($country, $city) }}</b> лв.</p>

                                        <p class="price-new"><b>{{$product->getVatDiscountedPrice($country, $city)}}</b> лв.</p>
                                    @else
                                        <p class="price-new"><b>{{$product->getVatPrice($country, $city)}}</b> лв.</p>
                                    @endif

                                </div>
                                <div class="prod-info">
                                    <p>
                                        {{ __('shop::front.product.sku') }}:
                                        <strong>{{$product->sku}}</strong>
                                    </p>

                                    <p>
                                        {{ __('shop::front.product.barcode') }}:
                                        <strong>{{$product->barcode}}</strong>
                                    </p>

                                    <p>
                                        {{ __('shop::front.product.brand') }}:
                                        <strong>{{$product->brand->title}}</strong>
                                    </p>

                                    <p>
                                        {{ __('shop::front.product.category') }}:
                                        <strong>{{$product->category->title}}</strong>
                                    </p>
                                </div>

                                <p class="out-of-stock">
                                    {{ __('shop::front.product.availability') }}:

                                    <strong>out of stock</strong>
                                </p>

                                <div class="quantity-discounts">
                                    {!! $product->getProductQuantityDiscountHtml() !!}
                                </div>

                                <div class="free-delivery-discount">
                                    {!! $product->getFreeDeliveryDiscountHtml() !!}
                                </div>

                                <div class="input-group-wrapper">
                                    <div class="input-group">
                                        <a href="" data-quantity="minus" data-field="quantity">-</a>

                                        <input class="input-group-field" type="number" name="quantity" value="1">

                                        <a href="" data-quantity="plus" data-field="quantity">+</a>
                                    </div>

                                    {{--                                    <div class="qty-wrapper">--}}
                                    {{--                                        <span>50</span> ml--}}
                                    {{--                                    </div>--}}
                                </div>

                                <p>Subtotal: 75.00 BGN</p>

                                <div class="prod-content-actions">
                                    <!-- <a href="" class="btn btn-icon btn-black">
                                        <img src="assets/icons/cart-white.svg" alt="" width="21.5">
                                        <img src="assets/icons/cart-white.svg" alt="" width="21.5">

                                        <span>add to cart</span>
                                    </a> -->

                                    <button type="submit" class="btn btn-icon btn-black" value="Поръчай">
                                        <img src="{{ asset('front/assets/icons/cart-empty.svg') }}" alt="" width="21.5">

                                        <span>{{__('shop::front.product.add_to_cart')}}</span>
                                    </button>

                                    @if(!Auth::guard('shop')->guest())
                                        <a href="" class="btn btn-icon">
                                            <img src="{{ asset('front/assets/icons/heart-alt.svg') }}" alt="" width="21.21">

                                            <span>{{__('shop::front.product.add_to_wishlist')}}</span>
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    @include('shop::front.partials.product_collections.collection', ['model' => $viewArray['currentModel']])
                </div>

                <div class="article-body" data-aos="fade-up" data-aos-delay="200">
                    <div class="article-inner">
                        {!! $viewArray['currentModel']->description !!}

                        @include('front.partials.content.after_description_modules', ['model' => $viewArray['currentModel']])
                        @include('front.partials.content.additional_titles_and_texts', ['model' => $viewArray['currentModel']])
                    </div>

                    <div class="article-product-info">
                        <div class="product-info">
                            <p class="quantity">50<span class="currency">ml</span></p>

                            <p class="price">
								<span class="old-price">
									93.00<span class="currency">&euro;</span>
								</span>

                                <span>68.00<span class="currency">&euro;</span></span>
                            </p>
                        </div>

                        {{--                        <div class="product-actions">--}}
                        {{--                            <a href="" class="link-more-big">Request</a>--}}
                        {{--                        </div>--}}
                    </div>

                    <!-- <div class="article-dates">
                        <p>08.03.2020</p>

                        <p>26.03.2020</p>
                    </div> -->
                </div>
            </div>
        </article>

        @include('front.partials.content.inner_gallery')
    </section>

@endsection
