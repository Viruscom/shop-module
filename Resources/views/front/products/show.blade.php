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

                    <form method="post" enctype="multipart/form-data" id="" action="">
                        <div class="products-collection">
                            <img src="{{ asset('front/assets/icons/plus-big.svg') }}" alt="">

                            <div class="products-list">
                                <div class="box">
                                    <div class="box-image-wrapper">
                                        <a href=""></a>

                                        <div class="box-image parent-image-wrapper" style="background-image: url(&quot;assets/images/wish.png&quot;);">
                                            <img src="{{ asset('front/assets/images/wish.png') }}" alt="" class="bg-image">
                                        </div>
                                    </div>

                                    <div class="box-content">
                                        <h3>
                                            <a href="">Shampoo for all hair types and scalp</a>
                                        </h3>

                                        <div class="prod-price">
                                            <span class="price-old">25.00 лв.</span>

                                            <span class="price-new">23.00 лв.</span>
                                        </div>
                                    </div>

                                    <div class="checkboxes-wrapper">
                                        <label class="checkbox-wrapper">
                                            <input type="checkbox" id="defaultAddress">

                                            <span class="checkmark"></span>

                                            <span class="check-text">Добавено</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="box">
                                    <div class="box-image-wrapper missing-prod">
                                        <a href=""></a>

                                        <div class="box-image parent-image-wrapper" style="background-image: url(&quot;assets/images/wish.png&quot;);">
                                            <img src="{{ asset('front/assets/images/wish.png') }}" alt="" class="bg-image">
                                        </div>
                                    </div>

                                    <div class="box-content">
                                        <h3>
                                            <a href="">Shampoo for all hair types and scalp</a>
                                        </h3>

                                        <div class="prod-price">
                                            <span>25.00 лв.</span>
                                        </div>
                                    </div>

                                    <div class="checkboxes-wrapper">
                                        <label class="checkbox-wrapper">
                                            <input type="checkbox" id="defaultAddress">

                                            <span class="checkmark"></span>

                                            <span class="check-text">Добавено</span>
                                        </label>
                                    </div>

                                    <p class="title-warning">Продуктът не е наличен!</p>
                                </div>

                                <div class="box">
                                    <div class="box-image-wrapper">
                                        <a href=""></a>

                                        <div class="box-image parent-image-wrapper" style="background-image: url(&quot;assets/images/wish.png&quot;);">
                                            <img src="{{ asset('front/assets/images/wish.png') }}" alt="" class="bg-image">
                                        </div>
                                    </div>

                                    <div class="box-content">
                                        <h3>
                                            <a href="">Shampoo for all hair types and scalp</a>
                                        </h3>

                                        <div class="prod-price">
                                            <span class="price-old">25.00 лв.</span>

                                            <span class="price-new">23.00 лв.</span>
                                        </div>
                                    </div>

                                    <div class="checkboxes-wrapper">
                                        <label class="checkbox-wrapper">
                                            <input type="checkbox" id="defaultAddress">

                                            <span class="checkmark"></span>

                                            <span class="check-text">Добавено</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="box">
                                    <div class="box-image-wrapper">
                                        <a href=""></a>

                                        <div class="box-image parent-image-wrapper" style="background-image: url(&quot;assets/images/wish.png&quot;);">
                                            <img src="{{ asset('front/assets/images/wish.png') }}" alt="" class="bg-image">
                                        </div>
                                    </div>

                                    <div class="box-content">
                                        <h3>
                                            <a href="">Shampoo for all hair types and scalp</a>
                                        </h3>

                                        <div class="prod-price">
                                            <span class="price-old">25.00 лв.</span>

                                            <span class="price-new">23.00 лв.</span>
                                        </div>
                                    </div>

                                    <div class="checkboxes-wrapper">
                                        <label class="checkbox-wrapper">
                                            <input type="checkbox" id="defaultAddress">

                                            <span class="checkmark"></span>

                                            <span class="check-text">Добавено</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="collection-info">
                                <h3>Направи комплект</h3>

                                <p>Спестете като купите основния продукт в комплект с някой друг от показаните:</p>

                                <ul>
                                    <li>
                                        <p>Цена по отделно</p>

                                        <strong>
                                            125.00
                                            <span>ЛВ.</span>
                                        </strong>
                                    </li>

                                    <li>
                                        <p>Спестявате</p>

                                        <strong>
                                            15.00
                                            <span>ЛВ.</span>
                                        </strong>
                                    </li>

                                    <li class="total">
                                        <p>Цена в комплект</p>

                                        <strong>
                                            110.00
                                            <span>ЛВ.</span>
                                        </strong>
                                    </li>
                                </ul>

                                <button type="submit" class="btn btn-icon btn-black" value="Поръчай">
                                    <img src="{{ asset('front/assets/icons/cart-empty.svg') }}" alt="" width="21.5">

                                    <span>add to cart</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="article-body" data-aos="fade-up" data-aos-delay="200">
                    <div class="article-inner">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque
                            ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                            Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. </p>

                        <h3>Lorem ipsum dolor sit amet, consectetur</h3>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque
                            ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p>

                        <h3>Lorem ipsum dolor sit amet, consectetur</h3>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque
                            ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p>

                        <h3>Lorem ipsum dolor sit amet, consectetur</h3>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque
                            ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p>
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

                        <div class="product-actions">
                            <a href="" class="link-more-big">Request</a>
                        </div>
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
