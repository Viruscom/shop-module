@extends('layouts.app')

@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/plugins/foundation-datepicker/datepicker.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
    <link href="{{ asset('admin/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/shop/js/order.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap-confirmation.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/foundation-datepicker/datepicker.js') }}"></script>
    <script>
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            container: 'body',
        });
        $(".select2").select2({language: "bg"});

        $(document).ready(function () {

            var table = $('.example').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                language: {
                    "sProcessing": "Обработка на резултатите...",
                    "sLengthMenu": "Показване на _MENU_ резултата",
                    "sZeroRecords": "Няма намерени резултати",
                    "sInfo": "Показване на резултати от _START_ до _END_ от общо _TOTAL_",
                    "sInfoEmpty": "Показване на резултати от 0 до 0 от общо 0",
                    "sInfoFiltered": "(филтрирани от общо _MAX_ резултата)",
                    "sInfoPostFix": "",
                    "sSearch": "Търсене:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Първа",
                        "sPrevious": "Предишна",
                        "sNext": "Следваща",
                        "sLast": "Последна"
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                placement: 'auto',
                trigger: 'hover',
                html: true
            });
        });
    </script>
@endsection

@section('content')
    <form action="{{ url('admin/shop/orders/store') }}" method="POST" data-form-type="store">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="hidden">
            <input type="text" name="payment_address_id" value="0">
            <input type="text" name="shipment_address_id" value="0">
            <input type="text" name="firm_account_id" value="0">
            <input type="text" name="client_group_id" value="1">
            <input type="text" name="client_id" value="">
            <input type="text" name="status_id" id="order_status_id" class="form-control col-md-12 hidden" value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_WAITING }}">
        </div>
        <div class="row">
            <h2 class="col-md-9 pull-left" style="display: flex;flex-direction: column;">
                Поръчка № {{ $orderNumber }}
            </h2>
            <div class="col-md-3 pull-right">
                {{--            <a href="{{ url('/') }}" class="btn btn-primary pull-right">Изпрати за изпълнение</a>--}}
                <label for="order_status_id" class="form-label col-md-12 text-right">Статус</label>
                <p class="form-control col-md-12" disabled>{{ trans('administration_messages.order_status_' . \App\Models\Shop_Models\Orders\Order::$STATUS_WAITING) }}</p>
                <input type="text" name="bill_of_lading" class="form-control" placeholder="Въведете товарителница">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <h4>Клиент / Гост</h4>
                <div class="choose-client-guest-btns">
                    <div class="btn btn-primary add-guest">Въведи гост</div>
                    <div class="btn btn-primary add-client">Въведи клиент</div>
                </div>
                <div class="choose-guest">

                </div>
                <div class="choose-client hidden">
                    <select name="client_id" id="client_id_select" class="form-control select2">
                        <option value="">--- Моля, изберете ---</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-xs-12">
                <h4>Метод на плащане</h4>
                <select name="payment_type_id" id="payment_type_id_select" class="form-control select2">
                    <option value="">--- Моля, изберете ---</option>
                    <option value="{{ \App\Models\Shop_Models\Orders\Order::$PAYMENT_TYPE_CASH_ON_DELIVERY }}">{{ trans('administration_messages.order_payment_type_1') }}</option>
                    <option value="{{ \App\Models\Shop_Models\Orders\Order::$PAYMENT_TYPE_BANK_TRANSFER }}">{{ trans('administration_messages.order_payment_type_2') }}</option>
                </select>
            </div>

            <div class="col-md-4 col-xs-12">
                <h4>Начин на доставка</h4>
                <select name="shipment_type_id" id="shipment_type_id_select" class="form-control select2">
                    <option value="">--- Моля, изберете ---</option>
                    <option value="1">{!! trans('administration_messages.delivery_type_1') !!}</option>
                    <option value="2">{!! trans('administration_messages.delivery_type_2') !!}</option>
                </select>
            </div>
        </div>
        <div class="row m-t-40">
            <div class="col-md-6">
                <table class="table table-striped payment-addresses-table">
                    <thead>
                    <tr>
                        <th style="display: flex; justify-content: space-between;align-items: center; padding-right: 0;">
                            <div>Адрес на плащане</div>
                            <div class="btn btn-sm btn-success add-payment-address-btn">Добави адрес</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="add-payment-address hidden">
                    <h5>Въвеждане на нов адрес на плащане</h5>
                    <div class="bg-e8 p-10"></div>
                </div>
            </div>

            <div class="col-md-6">
                <table class="table table-striped shipment-addresses-table">
                    <thead>
                    <tr>
                        <th style="display: flex; justify-content: space-between;align-items: center; padding-right: 0;">
                            <div>Адрес на доставка</div>
                            <div class="btn btn-sm btn-success add-shipment-address-btn">Добави адрес</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="add-shipment-address hidden">
                    <h5>Въвеждане на нов адрес на доставка</h5>
                    <div class="bg-e8 p-10"></div>
                </div>
            </div>
        </div>
        <div class="row m-t-40">
            <div class="col-md-12" style="display: flex;justify-content: space-between;align-items: center;">
                <h4>Фирмени данни</h4>
                <div class="btn btn-sm btn-success add-firm-account-btn">Добави фирма</div>
            </div>
            <div class="col-md-12 col-xs-12">
                <table class="table table-striped firm-accounts-table">
                    <thead>
                    <tr>
                        <th>Фирма</th>
                        <th>М.О.Л.</th>
                        <th>ЕИК</th>
                        <th>ЕИК по ДДС</th>
                        <th>Адрес по регистрация</th>
                        <th>Телефон</th>
                        <th class="text-right">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="7" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="add-firm-account hidden">
                    <h5>Въвеждане на нова фирма</h5>
                    <div class="bg-e8 p-10"></div>
                </div>
            </div>
        </div>
        <div class="row m-t-40">
            <div class="col-sm-12 col-xs-12">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#orders">Продукти</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="orders" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-4 pull-right text-right m-b-10"><span class="btn btn-success add-product" data-toggle="modal" data-target="#add_product_modal">Добави продукт</span></div>
                        </div>
                        <table class="table table-striped products-table">
                            <thead>
                            <tr>
                                <th>Снимка</th>
                                <th>Продукт</th>
                                <th>Ед.цена с ДДС</th>
                                <th>Количество</th>
                                <th>Общо</th>
                                <th>Отстъпки (общо)</th>
                                <th>Обща цена с отстъпки</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--                        @if(count($order->products))--}}
                            {{--                            @php--}}
                            {{--                                $grandTotalDiscounts = 0;--}}
                            {{--                                $grandTotalVat = 0;--}}
                            {{--                                $grandTotal = 0;--}}
                            {{--                                $grandTotalWithDiscounts = 0;--}}
                            {{--                            @endphp--}}
                            {{--                            @foreach($order->products as $product)--}}
                            {{--                                <tr class="t-row" data-toggle="popover" data-content="<img class= 'thumbnail img-responsive' src='{{ $product->product->fullImageFilePathUrl() }}'/>" data-original-title="" title="">--}}
                            {{--                                    <td>--}}
                            {{--                                        <img src="{{ $product->product->fullImageFilePathUrl() }}" width="60">--}}
                            {{--                                    </td>--}}
                            {{--                                    <td>{{ $product->product->defaultTranslation()->title }}</td>--}}
                            {{--                                    <td>{{ number_format($product->unit_price, 2,',',' ') }} @lang('messages.bgn')</td>--}}
                            {{--                                    <td>{{ $product->quantity }}</td>--}}
                            {{--                                    <td>{{ number_format($product->total, 2,',',' ') }} @lang('messages.bgn')</td>--}}
                            {{--                                    <td>{{ number_format($product->discounts, 2,',',' ') }} @lang('messages.bgn')</td>--}}
                            {{--                                    <td>{{ number_format($product->total_with_discounts, 2,',',' ') }} @lang('messages.bgn')</td>--}}
                            {{--                                </tr>--}}
                            {{--                                @php--}}
                            {{--                                    $grandTotalDiscounts+= $product->discounts;--}}
                            {{--                                    $grandTotal+= $product->total;--}}
                            {{--                                    $grandTotalWithDiscounts+= $product->total_with_discounts;--}}
                            {{--                                @endphp--}}
                            {{--                            @endforeach--}}
                            {{--                        @else--}}
                            {{--                            <tr>--}}
                            {{--                                <td colspan="7" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>--}}
                            {{--                            </tr>--}}
                            {{--                        @endif--}}
                            {{--                        </tbody>--}}
                            {{--                        <tfoot style="border-top: 2px dashed #c3c3c3;">--}}
                            {{--                        <tr>--}}
                            {{--                            <th colspan="6" class="text-right">Общо цена без отстъпки:</th>--}}
                            {{--                            <th>{{ number_format($grandTotal, 2,',',' ') }} @lang('messages.bgn')</th>--}}
                            {{--                        </tr>--}}
                            {{--                        <tr>--}}
                            {{--                            <th colspan="6" class="text-right" style="border: none;">Общо отстъпки:</th>--}}
                            {{--                            <th style="border: none;">{{ number_format($grandTotalDiscounts, 2,',',' ') }} @lang('messages.bgn')</th>--}}
                            {{--                        </tr>--}}
                            {{--                        <tr>--}}
                            {{--                            <th colspan="6" class="text-right" style="border: none;">Общо цена след отстъпки:</th>--}}
                            {{--                            <th style="border: none;">{{ number_format($grandTotalWithDiscounts, 2,',',' ') }} @lang('messages.bgn')</th>--}}
                            {{--                        </tr>--}}
                            {{--                        <tr>--}}
                            {{--                            <th colspan="6" class="text-right" style="border: none;">Доставка:</th>--}}
                            {{--                            <th style="border: none;">{{ ($order->shipment_amount == 0) ? 'Безплатна' : number_format($order->shipment_amount, 2,',',' ') }} @lang('messages.bgn')</th>--}}
                            {{--                        </tr>--}}

                            {{--                        <tr>--}}
                            {{--                            <th colspan="6" class="text-right" style="border: none;">Крайна цена с ДДС и доставка:</th>--}}
                            {{--                            <th style="border: none;">{{ ($order->shipment_amount == 0) ? 'Безплатна' : number_format($order->shipment_amount+$grandTotalWithDiscounts, 2,',',' ') }} @lang('messages.bgn')</th>--}}
                            {{--                        </tr>--}}
                            {{--                        </tfoot>--}}
                            </tbody>
                            <tfoot style="border-top: 2px dashed #c3c3c3;">
                            <tr>
                                <th colspan="6" class="text-right">Общо цена без отстъпки:</th>
                                <th class="price-without-discounts">0,00 лв.</th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right" style="border: none;">Отстъпки по продукти:</th>
                                <th class="discounts-on-products" style="border: none;">0,00 лв.</th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right" style="border: none;">Други отстъпки:</th>
                                <th class="other-discounts" style="border: none;">0,00 лв.</th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right" style="border: none;">Общо отстъпки:</th>
                                <th class="total-discounts" style="border: none;">0,00 лв.</th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right" style="border: none;">Общо цена след отстъпки:</th>
                                <th class="total-with-discounts" style="border: none;">0,00 лв.</th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right" style="border: none;">Доставка:</th>
                                <th class="shipment-amount" style="border: none;"><span>3,00</span> лв.</th>
                            </tr>

                            <tr>
                                <th colspan="6" class="text-right" style="border: none;">Крайна цена (с ДДС) и доставка:</th>
                                <th class="grand-total-with-vat-and-shipment-amount" style="border: none;">0,00 лв.</th>
                            </tr>

                            {{--                            //TODO: Add inputs 'total, total_discounts,vat,total_with_vat'--}}

                            </tfoot>
                        </table>
                        <div class="hidden">
                            <input type="text" name="total" class="price-without-discounts-input">
                            <input type="text" name="total_discounts" class="discounts-on-products-input">
                            <input type="text" name="vat" class="vat-input">
                            <input type="text" name="total_with_vat" class="total-with-vat-input">
                            <input type="text" name="shipment_amount" class="shipment-amount-input">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9 submit-wrapper-div">

                </div>
            </div>
        </div>
    </form>
    <!-- The Modal -->
    <div id="add_product_modal" class="modal in">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Добавяне на Продукт</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="searchbar_product" class="form-label">Търсене</label>
                        <input type="text" class="searchbar-product form-control" id="searchbar_product" placeholder="Търсете по: Име на продукт, продуктов код, наличност, марка и единична цена" autocomplete="off">
                    </div>
                    <div class="col-md-12 m-t-10 border-light">
                        <div class="col-md-12 product-div-wrapper">
                            @forelse($products as $product)
                                <div class="product-div col-md-2" product_id="{{ $product->id }}">
                                    <div class="image">
                                        <img src="{{ $product->fullImageFilePathUrl() }}" class="img-thumbnail">
                                    </div>
                                    <div class="info-wrapper">
                                        <div class="title">{{ $product->translations()->where('language_id', 1)->first()->title }}</div>
                                        <div class="product-code">Продуктов код (ID номер): {{ $product->sku }}</div>
                                        <div class="stock">Наличност: <span>{{ $product->units_in_stock }}</span> бр.</div>
                                        <div class="brand">Марка: {{ $product->brand->translations()->where('language_id', 1)->first()->title }}</div>
                                        <div class="unit-price">Ед.Цена с ДДС: {{ $product->formatedPrice($product->price) }} лв.</div>
                                        <div class="unit-price-without-vat">Ед.Цена без ДДС: {{ $product->price }} лв.</div>
                                        <div class="actions-wrapper row">
                                            <div class="col-md-12 error-message"></div>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control quantity-input" value="1" min="1" step="1">
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <span class="btn btn-success add-product-btn">Добави</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12 no-table-rows" style="padding: 15px;">{{ trans('administration_messages.no_recourds_found') }}</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
@endsection
