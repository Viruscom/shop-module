@php use Carbon\Carbon; @endphp
@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    @include('shop::front.partials.registered_user_head')
    <div class="page-wrapper">
        {{--        @include('shop::front.registered_users.profile.breadcrumbs')--}}
        <section class="settings-page">
            <div class="shell">
                @include('shop::front.registered_users.profile.partials.menu')

                <div class="page-content-shop">
                    <div class="page-top">
                        <h3 class="page-title">Поръчка #{{ $order->id }}</h3>

                        <a href="{{ route('shop.dashboard', ['languageSlug' => $languageSlug]) }}" class="btn btn-outline">{{ __('admin.back') }}</a>
                    </div>

                    <div class="box-cols">
                        <div class="col col-1of2">
                            <p>
                                {{ __('shop::front.registered_user_profile.order_date') }}: <strong>{{ Carbon::parse($order->created_at)->format('d.m.Y') }}</strong>
                            </p>

                            <p>
                                {{ __('shop::front.registered_user_profile.order_status') }}: <strong>{{ $order->getReadableShipmentStatus() }}</strong>
                            </p>
                        </div>

                        <div class="col col-1of2">
                            <p>
                                {{ __('shop::front.registered_user_profile.delivery_method') }}: <strong>{{ $order->getReadableShipmentMethod() }}</strong>
                            </p>

                            <p>
                                {{ __('shop::front.registered_user_profile.payment_method') }}: <strong>{{ $order->getReadablePaymentMethod() }}</strong>
                            </p>
                        </div>
                    </div>

                    <div class="accordions-wrapper">
                        <div class="accordion">
                            <div class="accordion-top">
                                <h3>{{ __('shop::front.registered_user_profile.documents') }}</h3>
                            </div>

                            <div class="accordion-body">
                                @if($order->documents->isNotEmpty())
                                    <ul class="download-elements">
                                        @foreach($order->documents as $order)
                                            <li class="hover-images">
                                                <a href="{{ $document->fullImageFilePathUrl() }}" target="_blank">
                                                    {{ $document->name }}
                                                    <img src="{{ asset('front/assets/icons/download-black.svg') }}" alt="">
                                                    <img src="{{ asset('front/assets/icons/download-red.svg') }}" alt="">
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-danger">@lang('admin.no-records')</div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="box-cols">
                        <div class="col col-1of2">
                            <div class="box-text">
                                <div class="box-content">
                                    <h4>{{ __('shop::front.registered_user_profile.shipping_address') }}</h4>

                                    <p>{{ $order->street . ', № ' . $order->street_number }}</p>

                                    <p>{{ $order->city->name }} {{ $order->zip_code }} </p>
                                </div>
                            </div>
                        </div>

                        <div class="col col-1of2">
                            <div class="box-text">
                                <div class="box-content">
                                    <h4>{{ __('shop::front.registered_user_profile.billing_address') }}</h4>
                                    @if($order->invoice_required)
                                        <h3>{{ $order->company_name }}</h3>
                                        <p>{{ $order->company_mol }}</p>
                                        <p>{{ $order->company_eik }}</p>
                                        <p>{{ ($order->company_vat_eik =='') ? 'Няма': '' }}</p>
                                        <p>{{ $order->company_address }}</p>
                                    @else
                                        <tr>
                                            <p>{{ trans('shop::admin.registered_users.no_companies') }}</p>
                                        </tr>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="title-border">{{ __('shop::front.registered_user_profile.order_comments') }}</h5>

                    <div class="options-list">
                        @if($order->with_utensils)
                            <p><strong>Искам прибори.</strong></p>
                        @endif

                        @if(!is_null($order->comment))
                            <p>{!! $order->comment !!}</p>
                        @endif
                    </div>

                    <h3>{{ __('shop::front.registered_user_profile.your_order') }}:</h3>

                    <div class="table-wrapper">
                        <div class="table-holder">

                            <table class="table-order table-order-prod">
                                <thead>
                                <th>SKU номер</th>
                                <th>Продукт</th>
                                <th class="align-right">Брой</th>
                                <th class="align-right">Ед. цена (лв.)</th>
                                <th class="align-right">Общо (лв.)</th>
                                </thead>

                                <tbody>
                                @foreach($order->order_products as $orderProduct)
                                    <tr class="{{ !$loop->first && !$loop->last ? 'border-row': '' }}">
                                        <td>{{ $orderProduct->product->sku }}</td>

                                        <td>
                                            <h4>
                                                <a href="{{ $orderProduct->product->getUrl($languageSlug) }}">{{ $orderProduct->product->title }} / <strong>{{ $orderProduct->product->measure_unit_value }} {{ $orderProduct->product->measureUnit->title }}</strong></a>
                                            </h4>
                                        </td>

                                        <td class="align-right">
                                            <strong>{{ $orderProduct->product_quantity }}</strong>
                                        </td>

                                        @if($orderProduct->vat_applied_default_price !== $orderProduct->vat_applied_discounted_price)
                                            <td class="align-right">{{$orderProduct->vat_applied_discounted_price}} {{ __('front.currency') }}</td>
                                        @else
                                            <td class="align-right">{{ $orderProduct->vat_applied_default_price }} {{ __('front.currency') }}</td>
                                        @endif

                                        <td class="align-right">
                                            <strong>{{ $orderProduct->end_discounted_price }} {{ __('front.currency') }}</strong>
                                        </td>
                                    </tr>



                                    @if($orderProduct->additives->isNotEmpty() || $orderProduct->additiveExcepts->isNotEmpty() || $orderProduct->productCollection->isNotEmpty())

                                        @if($orderProduct->additives->isNotEmpty())
                                            @php
                                                $additiveTotal = 0;
                                            @endphp
                                            <tr class="no-padding">
                                                <td></td>

                                                <td>
                                                    <div class="addition-box addition-box-green">
                                                        <h4>Добавки:</h4>
                                                    </div>
                                                </td>

                                                <td class="align-right"></td>

                                                <td class="align-right"></td>

                                                <td class="align-right"></td>
                                            </tr>

                                            @foreach($orderProduct->additives as $additive)
                                                <tr class="no-padding">
                                                    <td></td>

                                                    <td>
                                                        <div class="addition-box addition-box-green">
                                                            <div class="box-row">
                                                                <span>+</span>

                                                                <p>{{ $additive->productAdditive->title }}</p>

                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="align-right">
                                                        <strong>{{ $additive->quantity }}</strong>
                                                    </td>

                                                    <td class="align-right">{{ $additive->price }} лв.</td>

                                                    <td class="align-right">
                                                        <strong>{{ $additive->total }} лв.</strong>
                                                    </td>
                                                </tr>
                                                @php
                                                    $additiveTotal+=$additive->total;
                                                @endphp
                                            @endforeach
                                        @endif


                                        @if($orderProduct->additiveExcepts->isNotEmpty())
                                            <tr>
                                                <td></td>

                                                <td>
                                                    <div class="addition-box addition-box-orange">
                                                        <h4>Без:</h4>

                                                        <p>
                                                            @foreach($orderProduct->additiveExcepts as $additive)
                                                                {{ $additive->productAdditive->title }}
                                                                @if(!$loop->last)
                                                                    {{ ', ' }}
                                                                @endif
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                </td>

                                                <td class="align-right"></td>

                                                <td class="align-right"></td>

                                                <td class="align-right"></td>
                                            </tr>
                                        @endif

                                        @if($orderProduct->productCollection->isNotEmpty())
                                            @php
                                                $collectionTotal = 0;
                                            @endphp
                                            <tr class="{{ $orderProduct->additiveExcepts->isEmpty() ? '':'no-padding' }}">
                                                <td></td>

                                                <td>
                                                    <div class="addition-box">
                                                        <h4>Комбинирай с...</h4>
                                                    </div>
                                                </td>

                                                <td class="align-right"></td>

                                                <td class="align-right"></td>

                                                <td class="align-right"></td>
                                            </tr>

                                            @foreach($orderProduct->productCollection as $productCollection)
                                                <tr class="no-padding">
                                                    <td>{{ $productCollection->product->sku }}</td>

                                                    <td>
                                                        <div class="addition-box">
                                                            <div class="box-row">
                                                                <span>+</span>

                                                                <p>{{ $productCollection->product->title }}</p>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="align-right">{{ number_format($productCollection->quantity, 2, '.', '') }}</td>

                                                    <td class="align-right">{{ $productCollection->price }} лв.</td>

                                                    <td class="align-right">{{ $productCollection->total }} лв.</td>
                                                </tr>
                                                @php
                                                    $collectionTotal+=$productCollection->total;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-footer">
                            <div class="table-total">
                                <ul>
                                    <li>
                                        <span>Сума:</span>

                                        <span>{{ $order->totalEndDiscountedPriceWithAdditivesAndCollection() }} лв.</span>
                                    </li>

                                    <li>
                                        <span>Доставка:</span>

                                        <span>{{ $order->getFixedDeliveryPrice() }} лв.</span>
                                    </li>
                                </ul>

                                <ul>
                                    <li>
                                        <strong>Обща сума с ДДС:</strong>

                                        <strong>{{ $order->grandTotalWithDiscountsVatAndDelivery() }} лв.</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
