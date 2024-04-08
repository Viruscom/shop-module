@php
    use Modules\Shop\Entities\Basket\Basket;use Modules\Shop\Entities\Orders\Order;
    $deliveryPrice = $basket->total_free_delivery ? '0.00' : number_format((float)Order::FIXED_DELIVERY_PRICE, 2,'.','');

@endphp<h3 class="title-main title-border">@lang('shop::front.basket.summary')</h3>

<div class="col-inner">
    <div class="summary-boxes">
        <div class="box">
            <div class="box-row">
                <span>@lang('shop::front.basket.products_prices')</span>

                <strong>{{ number_format($basket->total_default, 2, '.', '') }} лв.</strong>
            </div>

            <div class="box-row">
                <span>{{ __('shop::front.basket.total_discounts') }}</span>

                <strong>- {{number_format($basket->total_default - $basket->total_discounted, 2, '.', '')}} лв.</strong>
            </div>

            <div class="box-row">
                <span>@lang('shop::front.basket.delivery')</span>

                <strong>{{ $deliveryPrice }} лв.</strong>
            </div>
        </div>

        <div class="box">
            <div class="box-row box-row-big">
                <span>{{ __('shop::front.basket.total_with_vat') }}</span>

                <strong>{{ number_format($basket->total_discounted + $deliveryPrice, 2, '.', '') }} лв.</strong>
            </div>

            <div class="box-row">
                <div class="checkboxes-wrapper">
                    @if(!is_null($termsOfUse))
                        @php
                            $termsOfUseTranslated = $termsOfUse->parent->translate($languageSlug);
                        @endphp
                        @if(!is_null($termsOfUseTranslated))
                            <label class="checkbox-wrapper">
                                <input type="checkbox" id="privacy" name="checkbox_privacy_agree" required>

                                <span class="checkmark"></span>

                                <span class="check-text">Прочетох и съм съгласен с това, което е описано в  <a href="{{ $termsOfUseTranslated->parent->href() }}" target="_blank"><strong>{{ $termsOfUseTranslated->title }}*</strong></a></span>
                            </label>
                        @endif
                    @endif
                </div>
            </div>

            <div class="box-row">
                <div class="checkboxes-wrapper">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" id="adds" name="checkbox_email_ads_agree">

                        <span class="checkmark"></span>

                        <span class="check-text">Съгласен съм да получавам електронен бюлетин по e-mail</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="box-actions">
            <button type="submit" class="submit-button" value="@lang('shop::front.basket.order')">@lang('shop::front.basket.order')</button>

            <a href="{{ url()->previous() }}" class="btn btn-outline">{{ __('admin.back') }}</a>
        </div>
    </div>
</div>
