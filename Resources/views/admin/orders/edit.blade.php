@extends('layouts.app')

@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/plugins/foundation-datepicker/datepicker.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
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
                <a href="{{ url()->previous() }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i
                        class="fa fa-reply"></i></a>
            </div>
        </div>
    </div>
    <div class="row m-b-20">
        <h3 class="col-md-9 pull-left" style="display: flex;flex-direction: column;">
            <b>Поръчка № {{ $order->strPadOrderId() }}</b>
            <span
                style="font-size: 15px;margin-top: 5px; color: #9e9e9e;">Пристигнала на: {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i:s') }}</span>
            <div style="margin-top: 15px;font-weight: 500;">
                <span style="font-size: 16px;">Статус: </span>
                <span
                    style="background: {{ $order->getStatusClass($order->status()) }};padding: 4px; color: #000000; font-size: 16px;max-width: 216px;margin-top: 10px;text-align: center;">{{ $order->statusHumanReadable() }}</span>
            </div>
        </h3>
        <div class="col-md-3 pull-right">
            @if($order->status_id != \App\Models\Shop_Models\Orders\Order::$STATUS_COMPLETED)
                <label for="order_status_id" class="form-label col-md-12 text-right">Промени статус</label>
                <select name="status_id" id="order_status_id" class="select2 form-control col-md-12 select-order-status"
                        style="width: 1005;">
                    <option
                        value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_WAITING }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_WAITING) ? 'selected': '' }}>{!! trans('administration_messages.order_status_1') !!}</option>
                    <option
                        value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_CANCELED }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_CANCELED) ? 'selected': '' }}>{!! trans('administration_messages.order_status_2') !!}</option>
                    <option
                        value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_EXPIRED }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_EXPIRED) ? 'selected': '' }}>{!! trans('administration_messages.order_status_3') !!}</option>
                    <option
                        value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_REFUSED }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_REFUSED) ? 'selected': '' }}>{!! trans('administration_messages.order_status_4') !!}</option>
                    <option
                        value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_UNSUCCESSFUL }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_UNSUCCESSFUL) ? 'selected': '' }}>{!! trans('administration_messages.order_status_5') !!}</option>
                    <option
                        value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_RESTORED }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_RESTORED) ? 'selected': '' }}>{!! trans('administration_messages.order_status_6') !!}</option>
                    <option
                        value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_DISPUTED_CARD_PAYMENT }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_DISPUTED_CARD_PAYMENT) ? 'selected': '' }}>{!! trans('administration_messages.order_status_7') !!}</option>
                    <option
                        value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_DISPUTED_PAYMENT }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_DISPUTED_PAYMENT) ? 'selected': '' }}>{!! trans('administration_messages.order_status_8') !!}</option>
                    <option
                        value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_PAID }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_PAID) ? 'selected': '' }}>{!! trans('administration_messages.order_status_9') !!}</option>
                    <option
                        value="{{ \App\Models\Shop_Models\Orders\Order::$STATUS_COMPLETED }}" {{ ($order->status_id == \App\Models\Shop_Models\Orders\Order::$STATUS_COMPLETED) ? 'selected': '' }}>{!! trans('administration_messages.order_status_10') !!}</option>
                </select>
            @endif
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
                    <th class="text-right"><span class="btn green btn-sm" role="button" data-toggle="modal"
                                                 data-target="#change_payment_modal"><i
                                class="fas fa-pencil-alt"></i></span></th>
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
                    <th class="text-right"><a href="" class="btn green btn-sm" role="button" data-toggle="modal"
                                              data-target="#change_shipment_modal"><i class="fas fa-pencil-alt"></i></a>
                    </th>
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
            <div class="alert alert-warning"><strong>Внимание!</strong> Данните за контакт на получателя са различни
            </div>
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
        <div class="col-md-6">
            <form action="{{ route('orders.payment-update', ['id' => $order->id]) }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th colspan="2">Регистрация на плащане с виртуален ПОС терминал</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($order->payment_type_id == \App\Models\Shop_Models\Orders\Order::$PAYMENT_TYPE_MYPOS)
                        <tr>
                            <td>№ документ (електронен бон)</td>
                            <td class="text-right"><span>{{ str_pad($vrNumber->value, 10, '0', STR_PAD_LEFT) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Дата на плащане</td>
                            <td class="text-right"><input type="date" name="vr_date"
                                                          value="{{ old('vr_date') ?? $order->vr_date }}"></td>
                        </tr>
                        <tr>
                            <td>ID на транзакцията</td>
                            <td class="text-right"><input type="text" name="vr_transaction_number" class="text-right"
                                                          value="{{ old('vr_transaction_number') ?? $order->vr_transaction_number }}">
                            </td>
                        </tr>
                        <tr>
                            <td>Начин на плащане</td>
                            <td class="text-right">{{ trans('administration_messages.order_payment_type_'.$order->payment_type_id) }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2" class="no-table-rows">Издаването на електронен бон е възможно при плащане с
                                Виртуален ПОС терминал
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                @if($order->payment_type_id == \App\Models\Shop_Models\Orders\Order::$PAYMENT_TYPE_MYPOS)
                    <button type="submit" name="submit" value="submit" class="btn save-btn margin-bottom-10 pull-right">
                        <i class="fas fa-save"></i> запиши
                    </button>
                @endif
            </form>
            @if($order->vr_date != '' && $order->vr_transaction_number != '' && $order->payment_type_id == \App\Models\Shop_Models\Orders\Order::$PAYMENT_TYPE_MYPOS)
                <div class="row" style="margin-top: 80px;">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2">Виртуална бележка / електронен бон</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="2">Генерираните виртуални бележки се записват в Документи.</td>
                            </tr>
                            </tbody>
                        </table>
                        <form action="{{ route('orders.virtual-receipt-generate', ['id' => $order->id]) }}"
                              method="POST" class="pull-right">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" name="submit" value="submit"
                                    class="btn green margin-bottom-10 pull-right">Генерирай виртуална бележка
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <form action="{{ route('orders.return-update', ['id' => $order->id]) }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th colspan="2">Връщане на поръчка / пари</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Върната сума</td>
                        <td class="text-right"><input type="text" name="returned_amount" class="text-right"
                                                      value="{{ old('returned_amount') ?? $order->returned_amount }}">
                        </td>
                    </tr>
                    <tr>
                        <td>Дата на връщане на сумата</td>
                        <td class="text-right"><input type="date" name="date_of_return"
                                                      value="{{ old('date_of_return') ?? $order->date_of_return }}">
                        </td>
                    </tr>
                    <tr>
                        <td>Начин на връщане на сумата</td>
                        <td class="text-right">
                            <select name="type_of_return">
                                <option
                                    value="По платежна сметка" {{ $order->type_of_return == 'По платежна сметка' ? 'selected' : '' }}>
                                    По платежна сметка
                                </option>
                                <option value="По карта" {{ $order->type_of_return == 'По карта' ? 'selected' : '' }}>По
                                    карта
                                </option>
                                <option value="В брой" {{ $order->type_of_return == 'В брой' ? 'selected' : '' }}>В
                                    брой
                                </option>
                                <option value="Друг" {{ $order->type_of_return == 'Друг' ? 'selected' : '' }}>Друг
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="comment">Коментар за връщане на поръчка / пари</label><textarea
                                name="return_comment" id="comment" rows="7"
                                style="width: 100%">{{ $order->return_comment }}</textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <button type="submit" name="submit" value="submit" class="btn save-btn margin-bottom-10 pull-right"><i
                        class="fas fa-save"></i> запиши
                </button>
            </form>
        </div>
    </div>
    <div class="row m-t-40">
        <div class="col-sm-12" style="display: flex;justify-content: space-between;">
            <h4>Фирмени данни</h4>
            <div class="text-right"><a href="" class="btn green btn-sm" role="button" data-toggle="modal"
                                       data-target="#firm_account_modal"><i class="fas fa-pencil-alt"></i></a></div>
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
                        <td class="invoice_recipient_name">{{ $order->invoice_recipient_name }}</td>
                        <td class="invoice_recipient_mol">{{ $order->invoice_recipient_mol }}</td>
                        <td class="invoice_recipient_uik">{{ $order->invoice_recipient_uik }}</td>
                        <td class="invoice_recipient_vat">{{ $order->invoice_recipient_vat }}</td>
                        <td class="invoice_recipient_full_address">{{ $order->invoice_recipient_city . ', ' .$order->invoice_recipient_address }}</td>
                        <td class="invoice_recipient_phone">{{ $order->invoice_recipient_phone }}</td>
                        <td class="text-right"><a
                                href="https://www.google.bg/maps/place/{{ $order->invoice_recipient_city . ' ' .$order->invoice_recipient_address }}"
                                class="btn btn-primary invoice_recipient_full_address_href" target="_blank"><i
                                    class="fas fa-map-marked-alt"></i></a></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="7"
                            class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
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
                <li>
                    <a data-toggle="tab" href="#history">История</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#returns">Заявки за връщане <span
                            class="m-l-5 badge badge-danger">{{ (!is_null($order->returns) && count($order->returns)>0) ? count($order->returns) : 0 }}</span></a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="orders" class="tab-pane fade in overflow-auto active">
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
                                <tr class="t-row" data-toggle="popover"
                                    data-content="<img class= 'thumbnail img-responsive' src='{{ $product->product->fullImageFilePathUrl() }}'/>"
                                    data-original-title="" title="">
                                    <td>
                                        <img src="{{ $product->product->fullImageFilePathUrl() }}" width="45">
                                    </td>
                                    <td>{{ $product->product->defaultTranslation->title }}</td>
                                    <td>{{ number_format($product->unit_price, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>
                                        <div>
                                            <input type="number" value="{{ $product->quantity }}" min="1"
                                                   product_id="{{$product->product->id}}" order_id="{{$order->id}}"
                                                   class="product-upd-quantity-input" style="width: 70px">
                                            <span class="m-l-5 upd-quantity"><i class="fas fa-sync-alt"
                                                                                style="color: forestgreen;"></i></span>
                                        </div>
                                    </td>
                                    <td>{{ number_format($product->total, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>{{ number_format($product->discounts, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>
                                        {{ number_format($product->total_with_discounts, 2,',',' ') }} @lang('messages.bgn')
                                    </td>
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
                            <tr class="collection-product" data-toggle="popover"
                                data-content="<img class= 'thumbnail img-responsive' src='{{ $mainProduct->fullImageFilePathUrl() }}'/>"
                                data-original-title="" title="">
                                <td>
                                    <img src="{{ $mainProduct->fullImageFilePathUrl() }}" width="60">
                                </td>
                                <td>{{ $mainProduct->getTranslation($language)->title }}</td>
                                <td>
                                    <p class="main-price {{ ($mainProduct->getCalculatedDiscounts()) ? 'price-old': '' }}">
                                        <b>{{ $mainProduct->formatedPrice($mainProduct->price) }}</b> @lang('messages.bgn')
                                    </p>

                                    @if($mainProduct->getCalculatedDiscounts())
                                        <p class="new-price">
                                            <b>{{ $mainProduct->formatedPrice($mainProduct->price-$mainProduct->getCalculatedDiscounts()) }}</b> @lang('messages.bgn')
                                        </p>
                                    @endif
                                </td>
                                <td>{{ ($firstCollectionProduct->quantity > 0) ? $firstCollectionProduct->quantity : 1 }}</td>
                                <td>{{ number_format($mainProduct->formatedPrice($mainProduct->price) * (($firstCollectionProduct->quantity > 0) ? $firstCollectionProduct->quantity : 1), 2,',',' ') }} @lang('messages.bgn')</td>
                                <td>
                                    {{ number_format(($mainProduct->price-$mainProduct->getCalculatedDiscounts()) * $firstCollectionProduct->quantity, 2,',',' ') }} @lang('messages.bgn')
                                    <a href="#" class="btn btn-danger btn-sm pull-right"><i
                                            class="fas fa-trash"></i></a>
                                </td>
                                <td>
                                    {{ number_format($mainProduct->formatedPrice(($mainProduct->price-$mainProduct->getCalculatedDiscounts()) * $firstCollectionProduct->quantity), 2,',',' ') }} @lang('messages.bgn')</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="collection-product"><h4>В комплект с:</h4></td>
                            </tr>

                            @foreach($order->collectionProducts as $collectionProduct)
                                <tr class="collection-product" data-toggle="popover"
                                    data-content="<img class= 'thumbnail img-responsive' src='{{ $collectionProduct->product->fullImageFilePathUrl() }}'/>"
                                    data-original-title="" title="">
                                    <td>
                                        <img src="{{ $collectionProduct->product->fullImageFilePathUrl() }}" width="60">
                                    </td>
                                    <td>{{ $collectionProduct->product->defaultTranslation->title }}</td>
                                    <td>
                                        {{ number_format($collectionProduct->price, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>{{ ($collectionProduct->quantity > 0) ? $collectionProduct->quantity : 1 }}</td>
                                    <td>{{ number_format($collectionProduct->price*$collectionProduct->quantity, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>{{ number_format(($collectionProduct->price-$collectionProduct->price_with_discount)*$collectionProduct->quantity, 2,',',' ') }} @lang('messages.bgn')</td>
                                    <td>
                                        {{ number_format($collectionProduct->price_with_discount*$collectionProduct->quantity, 2,',',' ') }} @lang('messages.bgn')
                                    </td>
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
                            <th style="border: none;">{{ ($order->shipment_amount == 0) ? 'Безплатна' : number_format($order->shipment_amount, 2,',',' ') }} @lang('messages.bgn')</th>
                        </tr>

                        <tr>
                            <th colspan="6" class="text-right" style="border: none;">Крайна цена (с ДДС) и доставка:
                            </th>
                            <th style="border: none;">{{ ($order->shipment_amount == 0) ? 'Безплатна' : number_format($order->shipment_amount+$grandTotalWithDiscounts+$collectionProductsSubTotal-$order->cart_only_discounts, 2,',',' ') }} @lang('messages.bgn')</th>
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

                <div id="documents" class="tab-pane fade in overflow-auto">
                    <div class="row">
                        <div class="col-md-4 pull-right text-right m-b-10"><a
                                href="{{ url('/admin/shop/orders/'.$order->id.'/documents/create') }}"
                                class="btn btn-success">Добави документ</a></div>
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
                                        <a href="{{ $document->fullImageFilePathUrl() }}" target="_blank"><i
                                                class="far fa-file-alt"></i> виж</a>
                                    </td>
                                    <td>{{ $document->name }}</td>
                                    <td>{{ $document->comment }}</td>
                                    <td class="text-right">
                                        <a href="{{ url('/admin/shop/orders/'.$order->id.'/documents/'.$document->id.'/send') }}"
                                           role="button" class="btn btn-xs btn-info tooltips" data-toggle="tooltip"
                                           data-placement="left" title="" data-original-title="Изпрати към клиента"><i
                                                class="fas fa-paper-plane"></i></a>
                                        <a href="{{ url('/admin/shop/orders/'.$order->id.'/documents/'.$document->id.'/delete') }}"
                                           role="button" class="btn btn-xs btn-danger" data-toggle="confirmation"><i
                                                class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4"
                                    class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <div id="history" class="tab-pane fade in overflow-auto">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Активност</th>
                            <th class="text-right">Дата на събитие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($order->history))
                            @foreach($order->history as $activity)
                                <tr class="t-row">
                                    <td>{!! $activity->activity_name !!}</td>
                                    <td class="text-right">{{ $activity->created_at }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3"
                                    class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <div id="returns" class="tab-pane fade in overflow-auto">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="max-width: 50px">№</th>
                            <th>Статус на връщането</th>
                            <th>Поръчка №</th>
                            <th>Дата и час</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!is_null($order->returns) && count($order->returns))
                            @foreach($order->returns as $return)
                                <tr class="t-row">
                                    <td style="max-width: 50px;">RE-{{ $return->id }}</td>
                                    <td>{{ $return->statusHumanReadable() }}</td>
                                    <td>{{ $return->order->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($return->created_at)->format('d.m.Y H:i:s') }}</td>
                                    <td class="pull-right">
                                        <a href="{{ route('orders.returns.show', ['id' => $return->id]) }}"
                                           class="btn btn-primary" role="button"><i class="fas fa-binoculars"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5"
                                    class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="firm_account_modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" data-dismiss="modal">&times;</span>
                <h4>Редакция на фирмени данни за поръчката</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="display: flex;flex-direction: column;">
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span> Фирма:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_name"
                                   autocomplete="off" value="{{ $order->invoice_recipient_name }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span>
                                М.О.Л.:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_mol"
                                   autocomplete="off" value="{{ $order->invoice_recipient_mol }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span>
                                ЕИК:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_uik"
                                   autocomplete="off" value="{{ $order->invoice_recipient_uik }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3">ЕИК по ДДС:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_vat"
                                   autocomplete="off" value="{{ $order->invoice_recipient_vat }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3">Град по регистрация:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_city"
                                   autocomplete="off" value="{{ $order->invoice_recipient_city }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3">Адрес по регистрация:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_address"
                                   autocomplete="off" value="{{ $order->invoice_recipient_address }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3">Телефон:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_phone"
                                   autocomplete="off" value="{{ $order->invoice_recipient_phone }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 p-t-b-10 text-left" style="display: flex;justify-content: space-between;">
                        <span class="btn btn-success firm-account-submit" order_id="{{ $order->id }}">Запис</span>
                        <span class="btn btn-danger" data-dismiss="modal">Отказ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <a class="hidden current-url-href" href="{{ url()->current() }}"></a>

    <div id="change_payment_modal" class="modal">
        <div class="modal-content" style="width: 50%;">
            <div class="modal-header">
                <h4>Метод на плащане</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 m-t-10 border-light">
                        <select name="payment_type_id" id="payment_type_id_select_modal" class="form-control">
                            <option value="">--- Моля, изберете ---</option>
                            <option
                                value="{{ \App\Models\Shop_Models\Orders\Order::$PAYMENT_TYPE_CASH_ON_DELIVERY }}">{{ trans('administration_messages.order_payment_type_1') }}</option>
                            <option
                                value="{{ \App\Models\Shop_Models\Orders\Order::$PAYMENT_TYPE_BANK_TRANSFER }}">{{ trans('administration_messages.order_payment_type_2') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 p-t-b-10 text-left" style="display: flex;justify-content: space-between;">
                        <span class="btn btn-success change-payment-type-submit"
                              order_id="{{ $order->id }}">Запис</span>
                        <span class="btn btn-danger" data-dismiss="modal">Отказ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="change_shipment_modal" class="modal">
        <div class="modal-content" style="width: 50%;">
            <div class="modal-header">
                <h4>Начин на доставка</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 m-t-10 border-light">
                        <select name="shipment_type_id" id="shipment_type_id_select_modal" class="form-control">
                            <option value="">--- Моля, изберете ---</option>
                            <option value="1">{!! trans('administration_messages.delivery_type_1') !!}</option>
                            <option value="2">{!! trans('administration_messages.delivery_type_2') !!}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 p-t-b-10 text-left" style="display: flex;justify-content: space-between;">
                        <span class="btn btn-success change-shipment-type-submit"
                              order_id="{{ $order->id }}">Запис</span>
                        <span class="btn btn-danger" data-dismiss="modal">Отказ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
