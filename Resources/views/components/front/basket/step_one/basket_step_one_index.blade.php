<div class="cart-cols">
    <div class="col col-2of3">
        <h3 class="title-main title-border">{!! trans('shop::front.basket.index') !!}</h3>
        <div class="col-inner">
            <div class="product-boxes">
                @foreach($basket->calculated_basket_products as $basketProduct)
                    @php
                        $productPrint = $basketProduct->product_print;
                    @endphp
                    <div class="product-box">
                        <div class="prod-content">
                            <div class="prod-image">
                                <a href="{{ $basketProduct->product->getUrl($languageSlug) }}"></a>
                                <img src="{{ $basketProduct->product->getFileUrl() }}" alt="">
                            </div>

                            <div class="prod-inner">
                                <div class="prod-inner-top">
                                    <h3>
                                        <a href="{{ $basketProduct->product->getUrl($languageSlug) }}">{{ $basketProduct->product->title }} / <strong>{{ $basketProduct->product->measure_unit_value }} {{ $basketProduct->product->measureUnit->title }}</strong></a>
                                    </h3>

                                    <x-shop::front.basket.step_one.basket_step_one_favicon :language-slug="$languageSlug" :basket-product="$basketProduct"/>
                                </div>

                                <div class="prod-inner-content">
                                    <x-shop::front.basket.step_one.basket_step_one_quantity :basketProduct="$basketProduct"/>

                                    <div class="prod-prices">
                                        <span>ед. цена</span>

                                        <x-shop::front.basket.step_one.basket_step_one_unit_price :basketProduct="$basketProduct"/>
                                    </div>

                                    <div class="prod-actions">
                                        <span>стойност</span>

                                        <x-shop::front.basket.step_one.basket_step_one_product_amount :basketProduct="$basketProduct"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="prod-additions">
                            {{--                            @if($basketProduct->additives->isNotEmpty())--}}
                            {{--                                <div class="addition-box addition-box-green">--}}
                            {{--                                    <h4>Добавки:</h4>--}}

                            {{--                                    @foreach($basketProduct->additives as $additive)--}}
                            {{--                                        <div class="box-row">--}}
                            {{--                                            <span>+</span>--}}

                            {{--                                            <p>--}}
                            {{--                                                {{ $additive->productAdditive->title }} </p>--}}

                            {{--                                            <div class="aside">--}}
                            {{--                                                <p class="quantity">{{ $basketProduct->product_quantity * $additive->quantity }}</p>--}}
                            {{--                                                <p>{{ number_format($additive->price, 2, '.', '') }} {{ __('front.currency') }}</p>--}}
                            {{--                                                <form action="{{ route('basket.products.remove-extension') }}" method="post">--}}
                            {{--                                                    @csrf--}}
                            {{--                                                    <input type="hidden" name="product_id" value="{{ $basketProduct->id }}">--}}
                            {{--                                                    <input type="hidden" name="product_print" value="{{ is_null($basketProduct->product_print) ? '' : $basketProduct->product_print }}">--}}
                            {{--                                                    <input type="hidden" name="extension_id" value="{{ $additive->id }}">--}}
                            {{--                                                    <input type="hidden" name="extension_type" value="additives">--}}
                            {{--                                                    <button type="submit" class="remove-prod"></button>--}}
                            {{--                                                </form>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </div>--}}
                            {{--                            @endif--}}

                            {{--                            @if($basketProduct->additiveExcepts->isNotEmpty())--}}
                            {{--                                <div class="addition-box addition-box-orange">--}}
                            {{--                                    <h4>Без:</h4>--}}

                            {{--                                    <p>--}}
                            {{--                                        @foreach($basketProduct->additiveExcepts as $additive)--}}
                            {{--                                            {{$additive->productAdditive->title}}--}}
                            {{--                                            @if(!$loop->last)--}}
                            {{--                                                {{ ', ' }}--}}
                            {{--                                            @endif--}}
                            {{--                                        @endforeach--}}
                            {{--                                    </p>--}}
                            {{--                                </div>--}}
                            {{--                            @endif--}}

                            @if($basketProduct->productCollection->isNotEmpty())
                                <div class="addition-box">
                                    <h4>Комбинирай с...</h4>

                                    @foreach($basketProduct->productCollection as $collectionProduct)
                                        <div class="box-row">
                                            <span>+</span>

                                            <p>
                                                {{ $collectionProduct->product->title }} </p>

                                            <div class="aside">
                                                <p class="quantity">{{ $basketProduct->product_quantity }}</p>
                                                <p>{{ number_format($collectionProduct->price, 2, '.', '') }} {{ __('front.currency') }}</p>
                                                <form action="{{ route('basket.products.remove-extension') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $basketProduct->id }}">
                                                    <input type="hidden" name="product_print" value="{{ is_null($basketProduct->product_print) ? '' : $basketProduct->product_print }}">
                                                    <input type="hidden" name="extension_id" value="{{ $collectionProduct->id }}">
                                                    <input type="hidden" name="extension_type" value="collection">
                                                    <button type="submit" class="remove-prod"></button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="prod-box-total">
                            <p>
                                Крайна цена:
                                <strong>{{ number_format($basketProduct->end_discounted_price_with_add_and_coll, 2, '.', '') }} {{ __('front.currency') }}</strong>
                            </p>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

        <x-shop::front.basket.step_one.basket_summary :basket="$basket"/>
</div>
