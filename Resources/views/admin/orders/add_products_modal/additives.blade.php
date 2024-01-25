    <div class="box box-green extensions">
        <h4>{{ __('front.products.add_big_letter') }}</h4>
        @if($product->additivesCollection(false)->isNotEmpty())
            @foreach($product->additivesCollection(false) as $additive)
                <div class="box-row">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="additivesAdd[{{$additive->id}}][selected]" class="addition-input" data-input-id="1">
                        <span class="checkmark"></span>
                        <span class="check-text">{{ $additive->title }}</span>
                    </label>

                    <div class="quantity-price">
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
                </div>
            @endforeach
        @else
            <div class="alert alert-info">Няма асоциирани добавки</div>
        @endif
    </div>
