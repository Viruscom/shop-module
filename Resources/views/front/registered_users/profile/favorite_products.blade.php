@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    @include('shop::front.partials.registered_user_head')
    <div class="page-wrapper">
        <section class="settings-page settings-page-wishlist">
            <div class="shell">
                @include('shop::front.registered_users.profile.partials.menu')

                <div class="page-content">
                    <h3 class="page-title">{{ __('front.products.favorites') }}</h3>

                    <div class="boxes boxes-type-2 boxes-type-2-alt">
                        @forelse($registeredUser->favoriteProducts as $favorite)
                            <div class="box" data-aos="fade-up">
                                <div class="box-statuses">
                                    <div class="status status-tooltip">
                                        <i class="custom-icon icon-leaf"></i>

                                        <div class="status-text">{{ __('front.products.status_vegan') }}</div>
                                    </div>

                                    <div class="status status-tooltip">
                                        <i class="custom-icon icon-fire"></i>

                                        <div class="status-text">{{ __('front.products.status_hot') }}</div>
                                    </div>

                                    @if($favorite->product->isNewProduct())
                                        <div class="status status-new">
                                            <span>{{ __('front.products.status_new') }}</span>
                                        </div>
                                    @endif

                                    @if($favorite->product->hasDiscounts())
                                        <div class="status status-tooltip status-discount">
                                            <span>{{ __('front.products.status_promo') }}</span>

                                            <div class="status-text">-{{ $favorite->product->getPercentDiscountsLabel($country, $city) }}%</div>
                                        </div>
                                    @endif
                                </div>

                                <div class="box-image-wrapper">
                                    <a href="{{ $favorite->product->getUrl($languageSlug) }}"></a>

                                    <div class="box-image parent-image-wrapper">
                                        <img src="{{ $favorite->product->getFileUrl() }}" alt="{{ $favorite->product->title }}" class="bg-image">
                                    </div>
                                </div>

                                <div class="box-content">
                                    <h3>
                                        <a href="{{ $favorite->product->getUrl($languageSlug) }}">{{ $favorite->product->title }}</a>
                                    </h3>

                                    <div class="box-inner">
                                        <span>{{ $favorite->product->measure_unit_value }} {{ $favorite->product->measureUnit->title }}</span>

                                        <div class="box-prices">
                                            @if($favorite->product->hasDiscounts())
                                                <p class="old-price"><strong>{{ $favorite->product->getVatPrice($country, $city) }}</strong> <span>{{ __('front.currency') }}</span></p>

                                                <p><strong>{{$favorite->product->getVatDiscountedPrice($country, $city)}}</strong> <span>{{ __('front.currency') }}</span></p>
                                            @else
                                                <p><strong>{{$favorite->product->getVatPrice($country, $city)}}</strong> <span>{{ __('front.currency') }}</span></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="box-actions">
                                    <div class="hover-images">
                                        <a href="" class="btn-icon">
                                            <img src="{{ asset('front/assets/icons/heart-filled.svg') }}" alt="" width="19">

                                            <img src="{{ asset('front/assets/icons/heart-filled-white.svg') }}" alt="" width="19">

                                            {{ __('front.products.delete_from_favorites') }}
                                        </a>
                                    </div>

                                    <a href="" class="btn-filled btn-icon">
                                        <img src="{{ asset('front/assets/icons/cart.svg') }}" alt="">
                                        {{ __('front.products.add') }}
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="snackbar-wrapper">
                                <div class="snackbar snackbar-error">@lang('admin.no-records')</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
