@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/plugins/cubeportfolio/css/cubeportfolio.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/plugins/cubeportfolio/css/remove_padding.css') }}">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('/front/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/front/plugins/cubeportfolio/js/main.js') }}"></script>
@endsection
@section('content')
    @php
        $product = $viewArray['currentModel']->parent;
    @endphp
    <section class="section-top-container">
        @include('shop::front.partials.choose_address_head')

        @include('front.partials.breadcrumbs')

        <div class="top-nav-pages hover-images">
            <a href="{{ $product->category->getUrl($languageSlug) }}" data-aos="fade-up" data-aos-delay="100">
                <img src="{{ asset('front/assets/icons/arrow.svg') }}" alt="">

                <img src="{{ asset('front/assets/icons/arrow-red.svg') }}" alt="">

                {{ __('admin.common.back') }}
            </a>
        </div>
    </section>

    <div class="shell">
        <div class="product-main-data">
            <div class="prod-image-wrapper">
                <div class="box-statuses">
                    @if($product->isVeganProduct())
                        <div class="status status-tooltip">
                            <i class="custom-icon icon-leaf"></i>

                            <div class="status-text">{{ __('front.products.status_vegan') }}</div>
                        </div>
                    @endif
                    @if($product->isHotProduct())
                        <div class="status status-tooltip">
                            <i class="custom-icon icon-fire"></i>

                            <div class="status-text">{{ __('front.products.status_hot') }}</div>
                        </div>
                    @endif

                    @if($product->isNewProduct())
                        <div class="status status-new">
                            <span>{{ __('front.products.status_new') }}</span>
                        </div>
                    @endif

                    @if($product->hasDiscounts())
                        <div class="status status-tooltip status-discount">
                            <span>{{ __('front.products.status_promo') }}</span>

                            <div class="status-text">-{{ $product->getPercentDiscountsLabel($country, $city) }}%</div>
                        </div>
                    @endif

                </div>

                <div class="box-image parent-image-wrapper">
                    <img src="{{ $product->getFileUrl() }}" alt="{{ $viewArray['currentModel']->title }}" class="bg-image">
                </div>
            </div>

            <div class="prod-content">
                <h3>{{ $viewArray['currentModel']->title }}</h3>
                {!! $viewArray['currentModel']->description !!}

                @include('front.partials.content.after_description_modules', ['model' => $viewArray['currentModel']])
                @include('front.partials.content.additional_titles_and_texts', ['model' => $viewArray['currentModel']])

                <div class="net-weight">{{ $product->measure_unit_value }} {{ $product->measureUnit->title }}</div>

                <x-shop::front.products.add_to_favorites :languageSlug="$languageSlug" :product="$product"/>

                <div class="box-prices">
                    {{ __('front.products.end_price') }}:

                    @if($product->hasDiscounts())
                        <p class="old-price"><strong>{{ $product->getVatPrice($country, $city) }}</strong> <span>{{ __('front.currency') }}</span></p>

                        <p><strong class="final-price" data-additions-value=0 data-initial-value="{{$product->getVatDiscountedPrice($country, $city)}}">{{$product->getVatDiscountedPrice($country, $city)}}</strong> <span>{{ __('front.currency') }}</span></p>
                    @else
                        <p><strong class="final-price" data-additions-value=0 data-initial-value="{{$product->getVatPrice($country, $city)}}">{{$product->getVatPrice($country, $city)}}</strong> <span>{{ __('front.currency') }}</span></p>
                    @endif
                </div>

                <form action="{{ route('basket.products.add') }}" method="POST" class="form-product">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <div class="input-group">
                        <a href="" class="minus-btn disabled" data-quantity="minus" data-field="quantity"></a>

                        <input class="input-group-field" type="number" name="product_quantity" value="1" readonly>

                        <a href="" class="plus-btn" data-quantity="plus" data-field="quantity"></a>
                    </div>

                    <button type="submit" class="submit-button">
                        <i class="custom-icon icon-cart"></i>

                        {{ __('front.products.add') }}
                    </button>

            </div>
        </div>

        <div class="prod-features">
            <div class="prod-cols">
                <div class="col-1of3">
                    @if($product->additivesCollection(false)->isNotEmpty())
                        <div class="box box-green">
                            <h4>{{ __('front.products.add_big_letter') }}</h4>
                            @foreach($product->additivesCollection(false) as $additive)
                                <div class="box-row">
                                    <label class="checkbox-wrapper">
                                        <input type="checkbox" name="additivesAdd[{{$additive->id}}][selected]" class="addition-input" data-input-id="1">
                                        <span class="checkmark"></span>
                                        <span class="check-text">{{ $additive->title }}</span>
                                    </label>

                                    <select class="select-custom select-count" name="additivesAdd[{{$additive->id}}][quantity]" data-prev-value="1" data-select-id="1">
                                        <option value="1.00" selected>1</option>
                                        <option value="2.00">2</option>
                                        <option value="3.00">3</option>
                                        <option value="4.00">4</option>
                                        <option value="5.00">5</option>
                                    </select>

                                    <div class="box-price">
                                        <span data-addition-price="1">{{ $additive->price }}</span> {{ __('front.currency') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($product->additivesCollection(true)->isNotEmpty())
                        <div class="box box-orange">
                            <h4>{{ __('front.products.izvadi_big') }}</h4>

                            <div class="box-checkboxes">
                                @foreach($product->additivesCollection(true) as $additive)
                                    <label class="checkbox-wrapper">
                                        <input type="checkbox" name="additivesExcept[{{$additive->id}}][selected]">
                                        <span class="checkmark"></span>
                                        <span class="check-text">{{ $additive->title }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(array_key_exists('Icons', $activeModules) && $viewArray['currentModel']['Icons']['0']->isNotEmpty())
                        <div class="box">
                            <h4>{{ __('front.products.alergens') }}</h4>
                            @include('shop::front.products.alergens', ['icons' => $viewArray['currentModel']['Icons']['0']])
                        </div>
                    @endif
                </div>

                <div class="col-2of3">
                    @include('shop::front.partials.product_collections.collection', ['model' => $viewArray['currentModel']])
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
