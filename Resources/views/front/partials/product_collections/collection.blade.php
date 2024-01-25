@php
    $product->load('getCollection');
    $groupedProducts = $product->getGroupedByCategoryCollection($languageSlug);
@endphp
@if($groupedProducts->isNotEmpty())
    <div class="combinations-wrapper" style="padding-bottom: 120px;">
        <h3>{{ __('front.products.combinate_with') }}</h3>

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

                            <h4>{{$product->title}} / {{ $product->measure_unit_value }} {{ $product->measureUnit->title }}</h4>

                            <label class="checkbox-wrapper">
                                <input type="checkbox" name="selectedCollectionPivotProduct[]" class="combination-input" value="{{ $pivotProduct->additional_product_id }}" price="{{ $pivotProduct->getVatPrice($country, $city) }}">
                                <span class="checkmark"></span>
                                <span class="check-text">{{ $pivotProduct->getVatPrice($country, $city) }} {{ __('front.currency') }}</span>
                            </label>
                        </div>
                    @endforeach

                </div>
            </div>
        @endforeach
    </div>
@endif
