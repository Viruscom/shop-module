<div class="boxes boxes-type-2">
    @foreach($products as $product)
        <div class="box" data-aos="fade-up">
            <div class="box-statuses">
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
            </div>

            <div class="box-image-wrapper">
                <a href="{{ $product->getUrl($languageSlug) }}"></a>

                <div class="box-image parent-image-wrapper">
                    <img src="{{ $product->getFileUrl() }}" alt="{{ $product->title }}" class="bg-image">
                </div>
            </div>
            <div class="box-content">
                <h3>
                    <a href="{{ $product->getUrl($languageSlug) }}">{{ $product->title }}</a>
                </h3>

                <div class="box-inner">
                    <span>{{ $product->measure_unit_value }} {{ $product->measureUnit->title }}</span>

                    <div class="box-prices">
                        @if($product->hasDiscounts())
                            <p class="old-price"><strong>{{ $product->getVatPrice($country, $city) }}</strong> <span>{{ __('front.currency') }}</span></p>

                            <p><strong class="final-price" data-additions-value=0 data-initial-value="{{$product->getVatDiscountedPrice($country, $city)}}">{{$product->getVatDiscountedPrice($country, $city)}}</strong> <span>{{ __('front.currency') }}</span></p>
                        @else
                            <p><strong class="final-price" data-additions-value=0 data-initial-value="{{$product->getVatPrice($country, $city)}}">{{$product->getVatPrice($country, $city)}}</strong> <span>{{ __('front.currency') }}</span></p>
                        @endif
                    </div>
                </div>
            </div>

            <a href="{{ $product->getUrl($languageSlug) }}" class="btn btn-outline">{{ __('front.products.choose') }}</a>
        </div>
    @endforeach
</div>
