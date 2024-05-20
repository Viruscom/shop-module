<div class="prod-qty hover-images">
    <div class="input-group-prod">
        <form action="{{ route('basket.products.add') }}" method="post" class="form-minus">
            @csrf
            <input type="hidden" name="product_id" value="{{ $basketProduct->product->id }}">
            <input type="hidden" name="product_print" value="{{ is_null($basketProduct->product_print) ? '' : $basketProduct->product_print }}">
            <input type="hidden" name="product_quantity" value="-1">
            <button data-quantity="minus" data-field="quantity" onclick="$(this).closest('form').submit();">-</button>
        </form>

        <input class="input-group-field" type="number" name="quantity" value="{{$basketProduct->product_quantity}}" readonly="">

        <form action="{{ route('basket.products.add') }}" method="post" class="form-plus">
            @csrf
            <input type="hidden" name="product_id" value="{{ $basketProduct->product->id }}">
            <input type="hidden" name="product_print" value="{{ is_null($basketProduct->product_print) ? '' : $basketProduct->product_print }}">
            <button data-quantity="plus" data-field="quantity" onclick="$(this).closest('form').submit();">+</button>
        </form>
    </div>
</div>
