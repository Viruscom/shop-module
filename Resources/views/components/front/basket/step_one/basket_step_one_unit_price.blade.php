@if($vatAppliedDefaultPrice !== $vatAppliedDiscountedPrice)
    <p class="main-price price-old">
        {{ $vatAppliedDefaultPrice }} {{ __('front.currency') }} </p>

    <p class="new-price">
        {{ $vatAppliedDiscountedPrice }} {{ __('front.currency') }} </p>
@else
    <p class="main-price">
        {{ $vatAppliedDefaultPrice }} {{ __('front.currency') }} </p>
@endif
