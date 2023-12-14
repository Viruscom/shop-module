@php use Carbon\Carbon; @endphp@php use App\Models\AdBoxButton; @endphp
<section class="section section-meals">
    <div class="section-head">
        <h3 data-aos="fade-up" data-aos-delay="60">
            {{ __('front.choose') }}
            <span data-aos="fade-up" data-aos-delay="100">{{ __('front.order_small_letters') }}</span>
        </h3>

        <p data-aos="fade-up" data-aos-delay="200">{{ __('front.and_enjoy') }}</p>
    </div>

    <div class="boxes boxes-type-2">
        @foreach($viewArray['shopProductAdBoxes'] as $adBox)
            <div class="box" data-aos="fade-up">
                <div class="box-statuses">
                    @if($adBox->product->isVeganProduct())
                        <div class="status status-tooltip">
                            <i class="custom-icon icon-leaf"></i>

                            <div class="status-text">{{ __('front.products.status_vegan') }}</div>
                        </div>
                    @endif
                    @if($adBox->product->isHotProduct())
                        <div class="status status-tooltip">
                            <i class="custom-icon icon-fire"></i>

                            <div class="status-text">{{ __('front.products.status_hot') }}</div>
                        </div>
                    @endif

                    @if($adBox->product->isNewProduct())
                        <div class="status status-new">
                            <span>{{ __('front.products.status_new') }}</span>
                        </div>
                    @endif

                    @if($adBox->product->hasDiscounts())
                        <div class="status status-tooltip status-discount">
                            <span>{{ __('front.products.status_promo') }}</span>

                            <div class="status-text">-{{ $product->getPercentDiscountsLabel($country, $city) }}%</div>
                        </div>
                    @endif
                </div>

                <div class="box-image-wrapper">
                    <a href="{{ $adBox->product->getUrl($languageSlug) }}"></a>

                    <div class="box-image parent-image-wrapper">
                        <img src="{{ $adBox->product->getFileUrl() }}" alt="{{ $adBox->product->title }}" class="bg-image">
                    </div>
                </div>

                <div class="box-content">
                    <h3>
                        <a href="{{ $adBox->product->getUrl($languageSlug) }}">{{ $adBox->product->title }}</a>
                    </h3>

                    <div class="box-inner">
                        <span>{{ $adBox->product->measure_unit_value }} {{ $adBox->product->measureUnit->title }}</span>

                        <div class="box-prices">
                            @if($adBox->product->hasDiscounts())
                                <p class="old-price"><strong>{{ $adBox->product->getVatPrice($country, $city) }}</strong> <span>{{ __('front.currency') }}</span></p>

                                <p><strong>{{$adBox->product->getVatDiscountedPrice($country, $city)}}</strong> <span>{{ __('front.currency') }}</span></p>
                            @else
                                <p><strong>{{$adBox->product->getVatPrice($country, $city)}}</strong> <span>{{ __('front.currency') }}</span></p>
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ $adBox->product->getUrl($languageSlug) }}" class="btn btn-outline">{{ __('front.choose_big_letter') }}</a>
            </div>
        @endforeach
    </div>

    @if(!is_null($firstProductCategory))
        <div class="section-info">
            <h4 data-aos="fade-up" data-aos-delay="60">{{ __('front.view_all_menu') }}</h4>

            <a href="{{ $firstProductCategory->getUrl($languageSlug) }}" class="btn btn-red" data-aos="fade-up" data-aos-delay="100">{{ __('front.menu') }}</a>
        </div>
    @endif

    @if(!is_null($viewArray['homePage']))
        <div class="section-content" data-aos="fade-up" data-aos-delay="200">
            <p>{!! $viewArray['homePage']->announce !!}</p>
        </div>
    @endif
</section>
