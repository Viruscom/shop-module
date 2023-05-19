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
    @include('front.partials.breadcrumbs')
    @php
        $product = $viewArray['currentModel']->parent;
        $category = $viewArray['currentModel']->parent->category;
    @endphp

    <div class="page-product">
        <div class="shell">
            <div class="page-prod-head">
                <div class="label" data-aos="fade-up" data-aos-delay="50"></div>

                <h3 data-aos="fade-up" data-aos-delay="100">{{ $category->title }}</h3>
            </div>
        </div>

{{--      Icons here --}}

        <div class="shell">
            <div class="prod-elements">
                <div class="prod-image-wrapper" data-aos="fade-up" data-aos-delay="50">
                    <a href="#"></a>

                    <div class="prod-image parent-image-wrapper">
                        <img src="{{ $product->getFileUrl() }}" alt="" class="bg-image">
                    </div>
                </div>

                <div class="prod-content">
                    <h3 data-aos="fade-up" data-aos-delay="50">{{ $viewArray['currentModel']->title }}</h3>

                    <div class="prod-info">
                        <p data-aos="fade-up" data-aos-delay="50">
                            <span>{{ __('shop::front.product.category') }}:</span>{{ $category->title }} </p>

                        <p data-aos="fade-up" data-aos-delay="100">
                            <span>{{ __('shop::front.product.weight') }}:</span>{{ $product->weight }} </p>
                    </div>

                    <div class="page-price" data-aos="fade-up" data-aos-delay="150">
{{--                        <div class="price price-old">--}}
{{--                            {{ __('front.from') }} <strong>98.00</strong> <span>{{ __('front.currency') }}</span>--}}
{{--                        </div>--}}

                        <div class="price">
{{--                            {{ __('front.from') }} --}}
                            <strong>{{ $product->getPrice() }}</strong> <span>{{ __('front.currency') }}</span>
                        </div>
                    </div>

                    <a href="" class="btn btn-prod" data-aos="fade-up" data-aos-delay="200">
                        <span>inquiry</span>

                        <i class="arrow-right"></i>
                    </a>
                </div>
            </div>

            <p data-aos="fade-up" data-aos-delay="50">
                Nulla elit quam, porta ac urna eu, eleifend commodo nisi. Nulla elementum nunc sed felis pretium, et viverra urna sollicitudin. Donec convallistempus sollicitudin. Phasellus ac tellus sit amet nulla tempus viverra ac at metus. Donec scelerisque ac felis vel pellentesque. Suspendisse pulvinar venenatis diam, id efficitur mauris tincidunt et. Nulla laoreet lorem sed scelerisque tempor. In hac habitasse platea dictumst. Maecenas augue ligula, elementum nec purus vitae, malesuada dictum erat. Sed venenatis et nunc sed sagittis. Mauris aliquet sagittis pretium. Nulla laoreet lorem
                sed scelerisque tempor. </p>

@include('shop::front.products.additional_fields')
        </div>
    </div>



    <div class="page-gallery" data-aos="fade-up" data-aos-delay="100">
        @include('front.partials.content.inner_gallery')
    </div>

    @if(!is_null($product->getPreviousProductUrl($languageSlug)) || !is_null($product->getNextProductUrl($languageSlug)))
        <div class="page-nav">
            @if(!is_null($product->getPreviousProductUrl($languageSlug)))
                <a href="{{ $product->getPreviousProductUrl($languageSlug) }}" data-aos="fade-up" data-aos-delay="100" class="page-prev">
                    <span>{{ __('shop::front.product.previous') }}</span>
                </a>
            @endif

            @if(!is_null($product->getNextProductUrl($languageSlug)))
                    <a href="{{ $product->getNextProductUrl($languageSlug) }}" data-aos="fade-up" data-aos-delay="100" class="page-next">
                        <span>{{ __('shop::front.product.next') }}</span>
                    </a>
            @endif
        </div>
    @endif



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

                    <h3 class="article-title" data-aos="fade-up" data-aos-delay="150"></h3>
                </div>

                <div class="product-wrapper">
                    <div class="product-main">
                        <div class="prod-aside">
                            <div class="prod-image">
                                <img src="" alt="" class="">
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
                                    <p class="price-old"><b>25.00</b> лв.</p>

                                    <p class="price-new"><b>{{ $product->getPrice() }}</b> лв.</p>
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


    </section>

@endsection
