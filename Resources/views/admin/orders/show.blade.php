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
    <div class="row m-b-20">
        <h3 class="col-md-9 pull-left" style="display: flex;flex-direction: column;">
            <b>Поръчка № {{ $order->id }}</b>
            <span style="font-size: 15px;margin-top: 5px; color: #9e9e9e;">Пристигнала на: {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s') }}</span>
            <div style="margin-top: 15px;font-weight: 500;">
                <span style="font-size: 16px;">Статус: </span>
                <span style="background: {{ $order->getStatusClass($order->status()) }};padding: 4px; color: #000000; font-size: 16px;max-width: 216px;margin-top: 10px;text-align: center;">{{ $order->statusHumanReadable() }}</span>
            </div>
        </h3>
        <div class="col-md-3 pull-right">
            {{--            <a href="{{ url('/') }}" class="btn btn-primary pull-right">Изпрати за изпълнение</a>--}}
            <label for="order_status_id" class="form-label col-md-12 text-right">Промени статус</label>
            <select name="status_id" id="order_status_id" class="select2 form-control col-md-12 select-order-status" style="width: 1005;">
                <option value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_WAITING }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_WAITING) ? 'selected': '' }}>{!! trans('administration_messages.order_status_1') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_CANCELED }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_CANCELED) ? 'selected': '' }}>{!! trans('administration_messages.order_status_2') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_EXPIRED }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_EXPIRED) ? 'selected': '' }}>{!! trans('administration_messages.order_status_3') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_REFUSED }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_REFUSED) ? 'selected': '' }}>{!! trans('administration_messages.order_status_4') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_UNSUCCESSFUL }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_UNSUCCESSFUL) ? 'selected': '' }}>{!! trans('administration_messages.order_status_5') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_RESTORED }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_RESTORED) ? 'selected': '' }}>{!! trans('administration_messages.order_status_6') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_DISPUTED_CARD_PAYMENT }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_DISPUTED_CARD_PAYMENT) ? 'selected': '' }}>{!! trans('administration_messages.order_status_7') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_DISPUTED_PAYMENT }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_DISPUTED_PAYMENT) ? 'selected': '' }}>{!! trans('administration_messages.order_status_8') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_PAID }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_PAID) ? 'selected': '' }}>{!! trans('administration_messages.order_status_9') !!}</option>
                <option value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_COMPLETED }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_COMPLETED) ? 'selected': '' }}>{!! trans('administration_messages.order_status_10') !!}</option>
            </select>

            <div class="m-t-10 text-right">
                <h4>Товарителница</h4>
                <p>{!! ($order->bill_of_lading) ?? '<span class="text-purple">Няма добавена товарителница</span>' !!}</p>
            </div>
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
                    <td><strong>{{ $order->name }}</strong></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><strong><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></strong></td>
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
                    <td><strong>{{ $order->client_group }}</strong></td>
                </tr>
                <tr>
                    <td>Телефон</td>
                    <td><strong><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></strong></td>
                </tr>
                @if(!is_null($order->client_id))
                    <tr>
                        <td>Рожден ден</td>
                        <td><strong>{{ \Carbon\Carbon::parse($order->client->birtday)->format('d.m.Y') }}</strong></td>
                    </tr>
                </tbody>
                @endif
            </table>
        </div>
    </div>
    <div class="row m-t-40">
        <div class="col-md-6">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Данни за плащане</th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Метод на плащане</td>
                    <td class="payment-type-td-text">{{ trans('administration_messages.order_payment_type_'.$order->payment_type_id) }}</td>
                </tr>
                <tr>
                    <td>Начин на доставка</td>
                    <td class="delivery-type-td-text">{{ trans('administration_messages.delivery_type_' . $order->delivery_type) }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Данни за доставка</th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Адрес на плащане</td>
                    <td>{{ ($order->i_want_invoice) ? $order->invoice_recipient_city . ', ' .$order->invoice_recipient_address : $order->shipment_address }}</td>
                </tr>
                <tr>
                    <td>Адрес на доставка</td>
                    <td>{{ $order->city . ', ' . $order->shipment_address }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if($order->shipment_different_recipient_checkbox)
        <div class="row m-0" style="background: #fff2cd;padding: 10px;">
            <div class="alert alert-warning"><strong>Внимание!</strong> Данните за контакт на получателя са различни</div>
            <h4>Данни за контакт на получател</h4>
            <table class="table striped">
                <thead>
                <tr>
                    <th>Име на получател</th>
                    <th>Телефон на получател</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $order->shipment_different_recipient_name }}</td>
                    <td>{{ $order->shipment_different_recipient_phone }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    @endif
    <div class="row m-t-40">
        <div class="col-md-9 col-sm-9">
            <h4>Фирмени данни</h4>
        </div>
        <div class="col-md-12 col-xs-12">
            <table class="table table-striped example">
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
                @php
                    $firmAccount = ($order->firm_account_id) ? $order->firmAccount() : null;
                @endphp
                @if($order->invoice_recipient_name != '')
                    <tr class="t-row">
                        <td>{{ $order->invoice_recipient_name }}</td>
                        <td>{{ $order->invoice_recipient_mol }}</td>
                        <td>{{ $order->invoice_recipient_uik }}</td>
                        <td>{{ $order->invoice_recipient_vat }}</td>
                        <td>{{ $order->invoice_recipient_city . ', ' .$order->invoice_recipient_address }}</td>
                        <td>{{ $order->invoice_recipient_phone }}</td>
                        <td class="text-right"><a href="https://www.google.bg/maps/place/{{ $order->invoice_recipient_city . ' ' .$order->invoice_recipient_address }}" class="btn btn-primary" target="_blank"><i class="fas fa-map-marked-alt"></i></a></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="7" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>
    </div>
    <div class="row m-t-40">
        <div class="col-sm-12 col-xs-12">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#orders">Продукти</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#documents">Документи</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="orders" class="tab-pane fade in active overflow-auto">
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
                        @if(count($order->products))
                            @foreach($order->products as $product)
                                <tr class="t-row" data-toggle="popover" data-content="<img class= 'thumbnail img-responsive' src='{{ $product->product->fullImageFilePathUrl() }}'/>" data-original-title="" title="">
                                    <td>
                                        <img src="{{ $product->product->fullImageFilePathUrl() }}" width="60">
                                    </td>
                                    <td>{{ $product->product->defaultTranslation->title }}</td>
                                    <td>{{ number_format($product->unit_price, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ number_format($product->total, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>{{ number_format($product->discounts, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>{{ number_format($product->total_with_discounts, 2,',',' ') }} @lang('messages.bgn')</td>
                                </tr>
                                @php
                                    $grandTotalDiscounts+= $product->discounts;
                                    $grandTotal+= $product->total;
                                    $grandTotalWithDiscounts+= $product->total_with_discounts;
                                @endphp
                            @endforeach
                        @endif
                        @php
                            $firstCollectionProduct = $order->collectionProducts()->first();
                            $mainProduct = ($firstCollectionProduct) ? $order->collectionProducts()->first()->mainProduct : null;
                        @endphp

                        @if(!is_null($mainProduct))
                            <tr class="collection-product" data-toggle="popover" data-content="<img class= 'thumbnail img-responsive' src='{{ $mainProduct->fullImageFilePathUrl() }}'/>" data-original-title="" title="">
                                <td>
                                    <img src="{{ $mainProduct->fullImageFilePathUrl() }}" width="60">
                                </td>
                                <td>{{ $mainProduct->getTranslation($language)->title }}</td>
                                <td>
                                    <p class="main-price {{ ($mainProduct->getCalculatedDiscounts()) ? 'price-old': '' }}">
                                        <b>{{ $mainProduct->formatedPrice($mainProduct->price) }}</b> @lang('messages.bgn') </p>

                                    @if($mainProduct->getCalculatedDiscounts())
                                        <p class="new-price">
                                            <b>{{ $mainProduct->formatedPrice($mainProduct->price-$mainProduct->getCalculatedDiscounts()) }}</b> @lang('messages.bgn') </p>
                                    @endif
                                </td>
                                <td>{{ ($firstCollectionProduct->quantity > 0) ? $firstCollectionProduct->quantity : 1 }}</td>
                                <td>{{ number_format($mainProduct->formatedPrice($mainProduct->price) * (($firstCollectionProduct->quantity > 0) ? $firstCollectionProduct->quantity : 1), 2,',',' ') }} @lang('messages.bgn')</td>
                                <td>{{ number_format(($mainProduct->price-$mainProduct->getCalculatedDiscounts()) * $firstCollectionProduct->quantity, 2,',',' ') }} @lang('messages.bgn')</td>
                                <td>{{ number_format($mainProduct->formatedPrice(($mainProduct->price-$mainProduct->getCalculatedDiscounts()) * $firstCollectionProduct->quantity), 2,',',' ') }} @lang('messages.bgn')</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="collection-product"><h4>В комплект с:</h4></td>
                            </tr>

                            @foreach($order->collectionProducts as $collectionProduct)
                                <tr class="collection-product" data-toggle="popover" data-content="<img class= 'thumbnail img-responsive' src='{{ $collectionProduct->product->fullImageFilePathUrl() }}'/>" data-original-title="" title="">
                                    <td>
                                        <img src="{{ $collectionProduct->product->fullImageFilePathUrl() }}" width="60">
                                    </td>
                                    <td>{{ $collectionProduct->product->defaultTranslation->title }}</td>
                                    <td>
                                        {{ number_format($collectionProduct->price, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>{{ ($collectionProduct->quantity > 0) ? $collectionProduct->quantity : 1 }}</td>
                                    <td>{{ number_format($collectionProduct->price*$collectionProduct->quantity, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>{{ number_format(($collectionProduct->price-$collectionProduct->price_with_discount)*$collectionProduct->quantity, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>{{ number_format($collectionProduct->price_with_discount*$collectionProduct->quantity, 2,',',' ') }} @lang('messages.bgn')</td>
                                </tr>

                                @php
                                    $collectionProductsSubTotalWithoutDiscounts+= $collectionProduct->price * $collectionProduct->quantity;
                                                    $collectionProductsSubTotal+= ($collectionProduct->price_with_discount != '')
                                                                    ? $collectionProduct->price_with_discount * $collectionProduct->quantity
                                                                    : $collectionProduct->price * $collectionProduct->quantity;
                                @endphp

                            @endforeach
                            @php
                                $collectionProductsSubTotalWithoutDiscounts+=  $mainProduct->formatedPrice($mainProduct->price * $collectionProduct->quantity);
                                        $collectionProductsSubTotal+= ($mainProduct->getCalculatedDiscounts())
                                                        ?  $mainProduct->formatedPrice(($mainProduct->price-$mainProduct->getCalculatedDiscounts()) * $collectionProduct->quantity)
                                                        :  $mainProduct->formatedPrice($mainProduct->price * $collectionProduct->quantity);
                            @endphp
                        @endif

                        </tbody>
                        <tfoot style="border-top: 2px dashed #c3c3c3;">
                        <tr>
                            <th colspan="6" class="text-right">Общо цена без отстъпки:</th>
                            <th>{{ number_format($grandTotal+$collectionProductsSubTotalWithoutDiscounts, 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right" style="border: none;">Отстъпки по продукти:</th>
                            <th style="border: none;">{{ number_format($grandTotalDiscounts+($collectionProductsSubTotalWithoutDiscounts-$collectionProductsSubTotal), 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right" style="border: none;">Други отстъпки:</th>
                            <th style="border: none;">{{ number_format($order->cart_only_discounts, 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right" style="border: none;">Общо отстъпки:</th>
                            <th style="border: none;">{{ number_format($grandTotalDiscounts+($collectionProductsSubTotalWithoutDiscounts-$collectionProductsSubTotal+$order->cart_only_discounts), 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right" style="border: none;">Общо цена след отстъпки:</th>
                            <th style="border: none;">{{ number_format($grandTotalWithDiscounts+$collectionProductsSubTotal-$order->cart_only_discounts, 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right" style="border: none;">Доставка:</th>
                            <th style="border: none;">{{ ($order->shipment_amount == 0) ? '0.00' : number_format($order->shipment_amount, 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>

                        <tr>
                            <th colspan="6" class="text-right" style="border: none;">Крайна цена (с ДДС) и доставка:</th>
                            <th style="border: none;">{{ number_format($order->shipment_amount+$grandTotalWithDiscounts+$collectionProductsSubTotal-$order->cart_only_discounts, 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>
                        </tfoot>

                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                <th>Приложени отстъпки</th>
                                <th class="text-right">Стойност</th>
                                </thead>
                                <tbody>
                                @if($order->shipment_amount == 0)
                                    <tr>
                                        <td>Безплатна доставка</td>
                                        <td class="text-right"></td>
                                    </tr>
                                @endif
                                @if(!is_null($order->promo_code))
                                    <tr>
                                        <td>Промокод</td>
                                        <td class="text-right">{{ $order->promo_code }}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="documents" class="tab-pane fade in overflow-auto">
                    <div class="row">
                        <div class="col-md-4 pull-right text-right m-b-10"><a href="{{ url('/admin/shop/orders/'.$order->id.'/documents/create') }}" class="btn btn-success">Добави документ</a></div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Файл</th>
                            <th>Документ</th>
                            <th>Коментар</th>
                            <th class="text-right">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($order->documents))
                            @foreach($order->documents as $document)
                                <tr class="t-row">
                                    <td>
                                        <a href="{{ $document->fullImageFilePathUrl() }}" target="_blank"><i class="far fa-file-alt"></i></a>
                                    </td>
                                    <td>{{ $document->name }}</td>
                                    <td>{{ $document->comment }}</td>
                                    <td class="text-right">
                                        <a href="{{ url('/admin/shop/orders/'.$order->id.'/documents/'.$document->id.'/send') }}" role="button" class="btn btn-xs btn-info tooltips" data-toggle="tooltip" data-placement="left" title="" data-original-title="Изпрати към клиента"><i class="fas fa-paper-plane"></i></a>
                                        <a href="{{ url('/admin/shop/orders/'.$order->id.'/documents/'.$document->id.'/delete') }}" role="button" class="btn btn-xs btn-danger" data-toggle="confirmation"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="firm_account_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h4>Добавяне на фирмени дани</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <div class="form-group">
                    <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span> Фирма:</label>
                    <input class="form-control col-md-9" type="text" name="name" autocomplete="off">
                </div>
                <div class="form-group">
                    <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span> М.О.Л.:</label>
                    <input class="form-control col-md-9" type="text" name="mol" autocomplete="off">
                </div>
                <div class="form-group">
                    <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span> ЕИК:</label>
                    <input class="form-control col-md-9" type="text" name="eik" autocomplete="off">
                </div>
                <div class="form-group">
                    <label class="control-label p-l-0 p-b-10 col-md-3">ЕИК по ДДС:</label>
                    <input class="form-control col-md-9" type="text" name="eik_dds" autocomplete="off">
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 p-t-b-10 text-left">
                        <span class="btn btn-success firm-account-submit">Запис</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="order_id" value="{{ $order->id }}">
@endsection
