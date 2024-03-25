<div class="box box-orange">
    <h4>{{ __('front.products.izvadi_big') }}</h4>

    @if($product->additivesCollection(true)->isNotEmpty())
        <div class="box-checkboxes">
            @foreach($product->additivesCollection(true) as $additive)
                <label class="checkbox-wrapper">
                    <input type="checkbox" name="additivesExcept[{{$additive->id}}][selected]">
                    <span class="checkmark"></span>
                    <span class="check-text">{{ $additive->title }}</span>
                </label>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Няма асоциирани добавки за изваждане</div>
    @endif
</div>
