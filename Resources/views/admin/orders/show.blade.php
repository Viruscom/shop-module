@php use Carbon\Carbon;use Modules\Shop\Entities\Orders\Order; @endphp@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/foundation-datepicker/datepicker.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
    <link href="{{ asset('admin/assets/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/shop/js/order.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/foundation-datepicker/datepicker.js') }}"></script>
    <script>
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
    @include('shop::admin.orders.breadcrumbs')
    @include('admin.notify')
    <div class="col-xs-12 p-0">
        <div class="bg-grey top-search-bar">
            <div class="action-mass-buttons pull-right">
                <a href="{{ url()->previous() }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3><strong>Поръчка № {{ $order->id }}</strong></h3>
            <h3 class="text-purple">Клиент</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td>Име и фамилия</td>
                    <td><strong>{{ $order->first_name. ' '. $order->last_name }}</strong></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><strong><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></strong></td>
                </tr>
                <tr>
                    <td>Парола</td>
                    <td><strong>*******</strong></td>
                </tr>
                <tr>
                    <td>Клиентска група</td>
                    <td><strong>{{ $order->client_group }}</strong></td>
                </tr>
                <tr>
                    <td>Телефон</td>
                    <td><strong><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></strong></td>
                </tr>
                @if(!is_null($order->user_id))
                    <tr>
                        <td>Рожден ден</td>
                        <td><strong>{{ Carbon::parse($order->user->birtday)->format('d.m.Y') }}</strong></td>
                    </tr>
                </tbody>
                @endif</tbody>
            </table>
            @if($order->invoice_required)
                <div class="alert alert-warning"><strong>Внимание! </strong>Клиентът изисква фактура.</div>
            @endif
        </div>
        <div class="col-md-6 col-xs-12">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td>@lang('shop::admin.orders.status')</td>
                    <td style="background: {{ $order->getShipmentStatusClass($order->shipment_status) }};color: #000000;">{{ $order->getReadableShipmentStatus() }}</td>
                </tr>
                <tr>
                    <td>@lang('shop::admin.orders.payment_status')</td>
                    <td style="background: {{ $order->getPaymentStatusClass($order->payment_status) }}; color: #000000;">{{ $order->getReadablePaymentStatus() }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <hr>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3 class="text-purple">Плащане</h3>
            <div>
                <h4>Метод на плащане</h4>
                <div class="form-control">{{ $order->getReadablePaymentMethod() }}</div>
            </div>
            <div class="m-t-10">
                <table class="table table-striped payment-addresses-table">
                    <thead>
                    <tr>
                        <th style="display: flex; justify-content: space-between;align-items: center; padding-right: 0;">
                            <h4>Адрес на плащане</h4>
                        </th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <h3 class="text-purple">Доставка</h3>
            <div>
                <h4>Метод на доставка</h4>
                <div class="form-control">{{ $order->getReadableShipmentMethod() }}</div>
            </div>
            <div class="m-t-10">
                <table class="table table-striped shipment-addresses-table">
                    <thead>
                    <tr>
                        <th style="display: flex; justify-content: space-between;align-items: center; padding-right: 0;">
                            <h4>Адрес на доставка</h4>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $order->street . ', № ' . $order->street_number }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <hr>
    </div>

    <div class="row">
        <div class="col-md-12" style="display: flex;justify-content: space-between;align-items: center;">
            <h3 class="text-purple">Фирмени данни</h3>
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
                </tr>
                </thead>
                <tbody>
                @if($order->invoice_required)
                    <tr>
                        <td>{{ $order->company_name }}</td>
                        <td>{{ $order->company_mol }}</td>
                        <td>{{ $order->company_eik }}</td>
                        <td>{{ ($order->company_vat_eik =='') ? 'Няма': '' }}</td>
                        <td>{{ $order->company_address }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="5" class="no-table-rows">{{ trans('shop::admin.registered_users.no_companies') }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <hr>
    </div>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#orders">@lang('shop::admin.orders.products')</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#documents">@lang('shop::admin.orders.documents')</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="orders" class="tab-pane fade in active" style="overflow: auto;">
                    <table class="table table-striped products-table">
                        <thead>
                        <tr>
                            <th>Снимка</th>
                            <th>Продукт</th>
                            <th>Количество</th>
                            <th>Ед.цена</th>
                            <th>ДДС</th>
                            <th>Ед.цена с ДДС</th>
                            <th>Общо с ДДС</th>
                            <th>Отстъпки (общо)</th>
                            <th>Ед.Цена с ДДС и отстъпки</th>
                            <th>Обща цена с отстъпки и ДДС</th>
                            <th>@lang('shop::admin.orders.free_delivery')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->order_products as $orderProduct)
                            <tr>
                                <td><img src="{{ $orderProduct->product->getFileUrl() }}" width="45"></td>
                                <td>{{ $orderProduct->product->title }}</td>
                                <td>{{ $orderProduct->product_quantity }}</td>
                                <td>{{ $orderProduct->price }}</td>
                                <td>{{ $orderProduct->vat }}</td>
                                <td>{{ $orderProduct->vat_applied_price }}</td>
                                <td>{{ $orderProduct->end_price }}</td>
                                <td>{{ $orderProduct->discounts_amount }}</td>
                                <td>{{ $orderProduct->vat_applied_discounted_price }}</td>
                                <td>{{ $orderProduct->end_discounted_price }}</td>
                                <td>
                                    @if($orderProduct->free_delivery)
                                        <label class="label label-success">@lang('shop::admin.orders.free_delivery_label_yes')</label>
                                    @else
                                        <label class="label label-success">@lang('shop::admin.orders.free_delivery_label_no')</label>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot style="border-top: 2px dashed #c3c3c3;">
                        <tr>
                            <th colspan="10" class="text-right">ДДС (общо):</th>
                            <th class="price-without-discounts">{{ $order->totalVatProducts() }} лв.</th>
                        </tr>
                        <tr>
                            <th colspan="10" class="text-right">Цена без отстъпки (общо):</th>
                            <th class="price-without-discounts">{{ $order->totalEndPriceProducts() }} лв.</th>
                        </tr>
                        <tr>
                            <th colspan="10" class="text-right" style="border: none;">Отстъпки (общо):</th>
                            <th class="total-discounts" style="border: none;">{{ $order->totalDiscountsAmount() }} лв.</th>
                        </tr>
                        <tr>
                            <th colspan="10" class="text-right" style="border: none;">Цена след отстъпки (общо):</th>
                            <th class="total-with-discounts" style="border: none;">{{ $order->totalEndDiscountedPrice() }} лв.</th>
                        </tr>
                        <tr>
                            <th colspan="10" class="text-right" style="border: none;">Доставка:</th>
                            <th class="shipment-amount" style="border: none;"><span>3,00</span> лв.</th>
                        </tr>

                        <tr>
                            <th colspan="10" class="text-right" style="border: none;">Крайна цена с отстъпки, ДДС и доставка:</th>
                            <th class="grand-total-with-vat-and-shipment-amount" style="border: none;">{{ $order->grandTotalWithDiscountsVatAndDelivery() }} лв.</th>
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
                <div id="documents" class="tab-pane fade" style="overflow: auto;">
                    <div class="text-right"><a href="{{ url('/admin/shop/orders/'.$order->id.'/documents/create') }}" class="btn btn-success">Добави документ</a></div>
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
                                <td colspan="4" class="no-table-rows">{{ trans('shop::admin.order_documents.no_records') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
