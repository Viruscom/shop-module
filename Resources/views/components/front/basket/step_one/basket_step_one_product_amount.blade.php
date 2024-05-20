<div class="prod-actions-inner">
    <div class="prod-total">{{ $endDiscountedPrice }} {{ __('front.currency') }}</div>
    <form action="{{ route('basket.products.add') }}" method="post" class="form-remove-prod">
        @csrf
        <input type="hidden" name="product_id" value="{{ $basketProductId }}">
        <input type="hidden" name="product_print" value="{{ $productPrint }}">
        <input type="hidden" name="product_quantity" value="0">
        <button class="remove-prod" type="submit"></button>
    </form>
</div>
