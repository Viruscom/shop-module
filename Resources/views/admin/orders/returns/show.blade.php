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
    <div class="col-xs-12 p-0">
        <div class="bg-grey top-search-bar">
            <div class="action-mass-buttons pull-right">
                <a href="{{ url()->previous() }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <h2 class="col-md-9 pull-left" style="display: flex;flex-direction: column;">
            Поръчка № {{ $return->order->id }}
            <span style="font-size: 15px;margin-top: 5px; color: #9e9e9e;">Пристигнала на: {{ \Carbon\Carbon::parse($return->order->created_at)->format('d.m.Y H:i:s') }}</span>
        </h2>
        <div class="col-md-3 pull-right">
            <label for="order_return_status_id" class="form-label col-md-12 text-right">Статус на заявката за връщане</label>
            <select name="status_id" id="order_return_status_id" class="select2 form-control col-md-12 select-order-return-status" style="width: 1005;">
                <option value="{{ \App\Models\Shop_Models\Orders\OrderReturn::WAITING_ACTION_STATUS }}" {{ ($return->status_id == \App\Models\Shop_Models\Orders\OrderReturn::WAITING_ACTION_STATUS) ? 'selected': '' }}>{!! trans('administration_messages.order_return_status_1') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\OrderReturn::AWAITING_SHIPMENT_STATUS }}" {{ ($return->status_id == \App\Models\Shop_Models\Orders\OrderReturn::AWAITING_SHIPMENT_STATUS) ? 'selected': '' }}>{!! trans('administration_messages.order_return_status_2') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\OrderReturn::SHIPMENT_HAS_BEEN_RECEIVED_STATUS }}" {{ ($return->status_id == \App\Models\Shop_Models\Orders\OrderReturn::SHIPMENT_HAS_BEEN_RECEIVED_STATUS) ? 'selected': '' }}>{!! trans('administration_messages.order_return_status_3') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\OrderReturn::RETURN_REFUSED_STATUS }}" {{ ($return->status_id == \App\Models\Shop_Models\Orders\OrderReturn::RETURN_REFUSED_STATUS) ? 'selected': '' }}>{!! trans('administration_messages.order_return_status_4') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\OrderReturn::RETURN_COMPLETED_STATUS }}" {{ ($return->status_id == \App\Models\Shop_Models\Orders\OrderReturn::RETURN_COMPLETED_STATUS) ? 'selected': '' }}>{!! trans('administration_messages.order_return_status_5') !!}</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan="2">Информация за клиента</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Име и фамилия</td>
                    <td><strong>{{ $return->order->name }}</strong></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><strong><a href="mailto:{{ $return->order->email }}">{{ $return->order->email }}</a></strong></td>
                </tr>
                <tr>
                    <td>Парола</td>
                    <td><strong>*******</strong></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan="2">Допълнителни данни</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Клиентска група</td>
                    <td><strong>{{ $return->order->client_group }}</strong></td>
                </tr>
                <tr>
                    <td>Телефон</td>
                    <td><strong><a href="tel:{{ $return->order->phone }}">{{ $return->order->phone }}</a></strong></td>
                </tr>
                @if(!is_null($return->order->client_id))
                    <tr>
                        <td>Рожден ден</td>
                        <td><strong>{{ \Carbon\Carbon::parse($return->order->client->birtday)->format('d.m.Y') }}</strong></td>
                    </tr>
                </tbody>
                @endif
            </table>
        </div>
    </div>


    <div class="row m-t-40">
        <div class="col-sm-12 col-xs-12">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#orders">Заявени продукти за връщане</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="orders" class="tab-pane fade in active">
                    <table class="table table-striped example">
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
                        @php
                            $grandTotalDiscounts = 0;
                            $grandTotalVat = 0;
                            $grandTotal = 0;
                            $grandTotalWithDiscounts = 0;
                            $collectionProductsSubTotalWithoutDiscounts = 0;
                            $collectionProductsSubTotal = 0;
                        @endphp
                        @if(count($return->order->products) && count($return->products))
                            @foreach($return->order->products as $product)
                                @foreach($return->products as $returnedProduct)
                                    @if($product->product_id == $returnedProduct->product_id)
                                        @php
                                            $productTotal = $returnedProduct->quantity * $product->unit_price;
                                            $productDiscounts = ($product->discounts/$product->quantity)*$returnedProduct->quantity;
                                            $productTotalWithDiscounts = $productTotal-$productDiscounts;
                                        @endphp
                                        <tr class="t-row" data-toggle="popover" data-content="<img class= 'thumbnail img-responsive' src='{{ $product->product->fullImageFilePathUrl() }}'/>" data-original-title="" title="">
                                            <td>
                                                <img src="{{ $product->product->fullImageFilePathUrl() }}" width="45">
                                            </td>
                                            <td>{{ $product->product->defaultTranslation->title }}</td>
                                            <td>{{ number_format($product->unit_price, 2,',',' ') }} @lang('messages.bgn')</td>
                                            <td>{{ $returnedProduct->quantity }}</td>
                                            <td>{{ number_format($productTotal, 2,',',' ') }} @lang('messages.bgn')</td>
                                            <td>{{ number_format($productDiscounts, 2,',',' ') }} @lang('messages.bgn')</td>
                                            <td>
                                                {{ number_format($productTotalWithDiscounts, 2,',',' ') }} @lang('messages.bgn')
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                @php
                                    $grandTotalDiscounts+= $productDiscounts;
                                    $grandTotal+= $productTotal;
                                    $grandTotalWithDiscounts+= $productTotalWithDiscounts;
                                @endphp
                            @endforeach
                        @endif

                        </tbody>
                        <tfoot style="border-top: 2px dashed #c3c3c3;">
                        <tr>
                            <th colspan="6" class="text-right">Общо цена без отстъпки:</th>
                            <th>{{ number_format($grandTotal, 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right" style="border: none;">Общо отстъпки:</th>
                            <th style="border: none;">{{ number_format($grandTotalDiscounts, 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right" style="border: none;">Крайна цена (с ДДС):</th>
                            <th style="border: none;">{{ number_format($grandTotalWithDiscounts, 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>
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
    <input type="hidden" name="return_id" value="{{ $return->id }}">
    <input type="hidden" name="order_id" value="{{ $return->order->id }}">
@endsection
