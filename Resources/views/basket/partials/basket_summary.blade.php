@php use Modules\Shop\Entities\Basket; @endphp
<h3 class="title-main title-border">@lang('shop::front.basket.summary')</h3>

<div class="col-inner">
    <div class="summary-boxes">
        <div class="box box-accordion">
            <div class="box-top">
                <h3 class="box-title title-accordion">@lang('shop::front.basket.products') ({{ Basket::productsCount() }})</h3>
            </div>

            <div class="box-content">
                <div class="product-boxes product-boxes-alt">
                    @foreach($basket->basket_products as $basketProduct)
                        <div class="product-box">
                            <div class="prod-content">
                                <div class="prod-image">
                                    <a href="{{ $basketProduct->product->getUrl($languageSlug) }}"></a>
                                    <img src="{{ $basketProduct->product->getFileUrl() }}" alt="">
                                </div>

                                <div class="prod-inner">
                                    <h3><a href="{{ $basketProduct->product->getUrl($languageSlug) }}">{{ $basketProduct->product->title }}</a></h3>

                                    <div class="prod-info">
                                        <div class="prod-qty">
                                            Брой <strong>{{ $basketProduct->product_quantity }}</strong>
                                        </div>

                                        <div class="prod-prices">
                                            <p class="main-price">
                                                <b>{{ $basketProduct->product->getPrice() }}</b> лв.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-row">
                <span>@lang('shop::front.basket.products_prices')</span>

                <strong>840.00  лв.</strong>
            </div>

            <div class="box-row">
                <span>@lang('shop::front.basket.delivery')</span>

{{--                <strong>{{$basket_product->free_delivery ? trans('shop:front.basket.free_delivery') :'3.00  лв.'}}</strong>--}}
            </div>
        </div>

        <div class="box">
            <div class="box-row box-row-big">
                <span>Общо с ДДС</span>

                <strong>655.00  лв.</strong>
            </div>

            <div class="box-row box-row-warning">
                <span>Спестявате</span>

                <strong>3.00  лв.</strong>
            </div>

            <div class="box-row">
                <div class="checkboxes-wrapper">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" id="privacy">

                        <span class="checkmark"></span>

                        <span class="check-text">Прочетох и съм съгласен с това, което е описано в <a href="" target="_blank"><strong>Общи условия*</strong></a></span>
                    </label>
                </div>
            </div>

            <div class="box-row">
                <div class="checkboxes-wrapper">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" id="adds">

                        <span class="checkmark"></span>

                        <span class="check-text">Съгласен съм да получавам електронен бюлетин по e-mail</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="box-actions">
            <button type="submit" class="submit-button" value="Поръчай">Поръчай</button>

            <a href="" class="btn btn-outline">Back</a>
        </div>
    </div>
</div>
