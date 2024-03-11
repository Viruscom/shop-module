@php
    $product->load('getCollection');
    $groupedProducts = $product->getGroupedByCategoryCollection($languageSlug);
@endphp
<div class="combinations-wrapper">
    <h3>{{ __('front.products.combinate_with') }}</h3>
    @if($groupedProducts->isNotEmpty())
        @foreach($groupedProducts as $categoryName=>$categoryProducts)
            <div class="box-combinations">
                <h4>{{ $categoryName }}</h4>

                <div class="combinations">
                    @foreach($categoryProducts as $pivotProduct)
                        @php
                            $product = $pivotProduct->product;
                        @endphp

                        <div class="combo-box">
                            <img src="{{$product->getFileUrl()}}" alt="{{ $product->title }}">

                            <h4>{{$product->title}} / <strong>{{ $product->measure_unit_value }} {{ $product->measureUnit->title }}</strong></h4>

                            <label class="checkbox-wrapper">
                                <input type="checkbox" name="selectedCollectionPivotProduct[]" class="combination-input" value="{{ $pivotProduct->additional_product_id }}" price="{{ $pivotProduct->price_with_discount }}">
                                <span class="checkmark"></span>
                                <span class="check-text">{{ $pivotProduct->price_with_discount }} {{ __('front.currency') }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">Няма асоциирана колекция</div>
    @endif
</div>
