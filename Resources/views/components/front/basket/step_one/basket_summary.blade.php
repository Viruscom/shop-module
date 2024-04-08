<div class="col col-1of3">
    <h3 class="title-main title-border">{{ __('shop::front.basket.summary') }}</h3>

    <div class="col-inner">
        <div class="summary-boxes">
            <div class="box">
                <div class="box-row">
                    <span>{{ __('shop::front.basket.products_prices') }}</span>

                    <strong>{{ $totalDefaultFormatted }} {{ __('front.currency') }}</strong>
                </div>

                <div class="box-row box-row-promo">
                    @if($basket->promo_code)
                        <div class="promo-info">
                            {{ __('shop::front.basket.you_use_promo_code') }}: {{ $basket->promo_code }}
                        </div>
                        <br>
                        <div class="delete-promo-code">
                            <a href="{{ route('basket.delete-promo-code') }}">{{ __('shop::front.basket.delete_promo_code') }}</a>
                        </div>
                    @endif

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
                </div>

                <div class="box-row box-row-warning">
                    <span>{{ __('shop::front.basket.total_discounts') }}</span>

                    <strong>- {{ $totalDiscountsFormatted }} {{ __('front.currency') }}</strong>
                </div>
            </div>

            <div class="box">
                <div class="box-row box-row-big">
                    <span>{{ __('shop::front.basket.total_with_vat') }}</span>

                    <strong>{{ $totalDiscountedFormatted }} {{ __('front.currency') }}</strong>
                </div>

                {{--                                        <p class="shoping-info-discount">Остават ви 85.00 лв до безплатна доставка.</p>--}}

                {{--                                        <p class="shoping-info-discount shoping-info-discount-alt">{{ __('shop::front.basket.shipping_ang_taxes_calc_on_checkout') }}</p>--}}
            </div>

            <div class="box-actions">
                <a href="{{route('basket.order.create')}}" class="btn btn-black">{{ __('shop::front.basket.go_to_checkout') }}</a>

                <a href="{{ WebsiteHelper::homeUrl() }}" class="btn btn-outline">{{ __('shop::front.basket.continue_shipping') }}</a>
            </div>
        </div>
    </div>
</div>
