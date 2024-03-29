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
                <a href="{{ route('admin.shop.orders') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>
                <strong>Поръчка № {{ $order->id }}</strong>
            </h3>
            <h5>Регистрирана на дата: <strong>{{ $order->created_at }}</strong></h5>
            <hr>
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
                <div class="alert alert-warning">{!! __('shop::admin.orders.warning_invoice_required') !!}</div>
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
                <tr>
                    <td>Искам прибори</td>
                    <td>
                        @if($order->with_utensils)
                            <span class="label label-success">ДА</span>
                        @else
                            <span class="label label-danger">НЕ</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                <tr>
                    <td colspan="2">Коментар към поръчката</td>
                </tr>
                <tr>
                    <td colspan="2">{{ $order->comment }}</td>

                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>
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
                        <td>
                            <p>{{ $order->street . ', № ' . $order->street_number }}</p>
                            <p>
                                @if(!is_null($order->entrance))
                                    {{ 'Вход: '.$order->entrance . ' ' }}
                                @endif
                                @if(!is_null($order->floor))
                                    {{ 'Етаж: '.$order->floor . ' ' }}
                                @endif
                                @if(!is_null($order->apartment))
                                    {{ 'Ап.: '.$order->apartment . ' ' }}
                                @endif
                                @if(!is_null($order->bell_name))
                                    {{ 'Надпис на звънец:: '.$order->bell_name . ' ' }}
                                @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>
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
        <div class="col-md-12">
            <hr>
        </div>
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
                <li>
                    <a data-toggle="tab" href="#history">{{ __('shop::admin.orders.history') }}</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#returns">{{ __('shop::admin.orders.return_requests') }} <span class="m-l-5 badge badge-danger">{{ (!is_null($order->returns) && count($order->returns)>0) ? count($order->returns) : 0 }}</span></a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="orders" class="tab-pane fade in active" style="overflow: auto;">
                    <table class="table table-striped products-table">
                        <thead>
                        <tr>
                            <th>{{ __('shop::admin.orders.image') }}</th>
                            <th>{{ __('shop::admin.orders.product') }}</th>
                            <th>{{ __('shop::admin.orders.quantity') }}</th>
                            <th>{{ __('shop::admin.orders.unit_price') }}</th>
                            <th>{{ __('shop::admin.orders.vat') }}</th>
                            <th>{{ __('shop::admin.orders.unit_price_-with_vat') }}</th>
                            <th>{{ __('shop::admin.orders.total_with_vat') }}</th>
                            <th>{{ __('shop::admin.orders.discounts_total') }}</th>
                            <th>{{ __('shop::admin.orders.unit_price_with_vat_and_discounts') }}</th>
                            <th>{{ __('shop::admin.orders.grand_total_with_vat_and_discounts') }}</th>
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
                            @if($orderProduct->additives->isNotEmpty() || $orderProduct->additiveExcepts->isNotEmpty() || $orderProduct->productCollection->isNotEmpty())
                                <tr class="tr-extensions">
                                    <td colspan="12">
                                        <div style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: space-around;align-items: flex-start;">
                                            <div>
                                                <h5><strong>Добавки</strong></h5>
                                                <p>
                                                @if($orderProduct->additives->isNotEmpty())
                                                    @php
                                                        $additiveTotal = 0;
                                                    @endphp
                                                    <table class="table table-bordered table-extensions">
                                                        <thead>
                                                        <th>Добавка</th>
                                                        <th>Количество</th>
                                                        <th class="text-right">Цена</th>
                                                        <th class="text-right">Общо</th>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($orderProduct->additives as $additive)
                                                            <tr>
                                                                <td>{{ $additive->productAdditive->title }}</td>
                                                                <td>{{ $additive->quantity }}</td>
                                                                <td class="text-right">{{ $additive->price }}</td>
                                                                <td class="text-right">{{ $additive->total }}</td>
                                                            </tr>
                                                            @php
                                                                $additiveTotal+=$additive->total;
                                                            @endphp
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="3" class="text-right">Общо с ДДС:</td>
                                                            <td class="text-right">{{ number_format($additiveTotal, 2, '.', '') }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <div class="alert alert-warning">Няма избрани добавки</div>
                                                    @endif</p>

                                            </div>
                                            <div>
                                                <h5><strong>Без</strong></h5>
                                                <p>
                                                @if($orderProduct->additiveExcepts->isNotEmpty())
                                                    <table class="table table-bordered table-extensions">
                                                        <thead>
                                                        <th>Име</th>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($orderProduct->additiveExcepts as $additive)
                                                            <tr>
                                                                <td>{{ $additive->productAdditive->title }}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <div class="alert alert-warning">Няма избрани добавки за премахване</div>
                                                    @endif</p>

                                            </div>
                                            <div>
                                                <h5><strong>Комбинирано с...</strong></h5>
                                                <p>
                                                @if($orderProduct->productCollection->isNotEmpty())
                                                    @php
                                                        $collectionTotal = 0;
                                                    @endphp
                                                    <table class="table table-bordered table-extensions">
                                                        <thead>
                                                        <th>Снимка</th>
                                                        <th>Име</th>
                                                        <th>Количество</th>
                                                        <th class="text-right">Цена</th>
                                                        <th class="text-right">Общо</th>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($orderProduct->productCollection as $productCollection)
                                                            <tr>
                                                                <td><img src="{{$productCollection->product->getFileUrl()}}" width="25"></td>
                                                                <td>{{ $productCollection->product->title }}</td>
                                                                <td>{{ number_format($productCollection->quantity, 2, '.', '') }}</td>
                                                                <td class="text-right">{{ $productCollection->price }}</td>
                                                                <td class="text-right">{{ $productCollection->total }}</td>
                                                            </tr>
                                                            @php
                                                                $collectionTotal+=$productCollection->total;
                                                            @endphp
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="4" class="text-right">Общо с ДДС:</td>
                                                            <td class="text-right">{{ number_format($collectionTotal, 2, '.', '') }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <div class="alert alert-warning">Няма избрани продукти за колекция</div>
                                                    @endif</p>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot style="border-top: 2px dashed #c3c3c3;">
                        <tr>
                            <th colspan="10" class="text-right">{{ __('shop::admin.orders.total_price_without_discounts') }}:</th>
                            <th class="price-without-discounts">{{ $order->totalEndPriceProducts() }} лв.</th>
                        </tr>
                        <tr>
                            <th colspan="10" class="text-right" style="border: none;">{{ __('shop::admin.orders.discounts_total') }}:</th>
                            <th class="total-discounts" style="border: none;">{{ $order->totalDiscountsAmount() }} лв.</th>
                        </tr>
                        <tr>
                            <th colspan="10" class="text-right" style="border: none;">{{ __('shop::admin.orders.total_price_after_discounts') }}:</th>
                            <th class="total-with-discounts" style="border: none;">{{ $order->totalEndDiscountedPriceWithAdditivesAndCollection() }} лв.</th>
                        </tr>
                        <tr>
                            <th colspan="10" class="text-right" style="border: none;">{{ __('shop::admin.orders.delivery') }}:</th>
                            <th class="shipment-amount" style="border: none;"><span>{{ $order->getFixedDeliveryPrice() }}</span> лв.</th>
                        </tr>

                        <tr>
                            <th colspan="10" class="text-right" style="border: none;">{{ __('shop::admin.orders.grand_total_with_discounts_with_vat_and_delivery') }}:</th>
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
                    <div class="text-right"><a href="{{ route('admin.shop.orders.documents.create', ['order_id' =>$order->id]) }}" class="btn btn-success">{{ __('shop::admin.order_documents.add') }}</a></div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{ __('shop::admin.order_documents.file') }}</th>
                            <th>{{ __('shop::admin.order_documents.document') }}</th>
                            <th>{{ __('shop::admin.order_documents.comment') }}</th>
                            <th class="text-right">{{ __('shop::admin.common.actions') }}</th>
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
                                        <a href="{{ route('admin.shop.orders.documents.send', ['order_id' => $order->id, 'document_id' => $document->id]) }}" role="button" class="btn btn-xs btn-info tooltips" data-toggle="tooltip" data-placement="left" title="" data-original-title="Изпрати към клиента"><i class="fas fa-paper-plane"></i></a>
                                        <a href="{{ route('admin.shop.orders.documents.delete', ['order_id' => $order->id, 'document_id' => $document->id]) }}" role="button" class="btn btn-xs btn-danger" data-toggle="confirmation"><i class="fas fa-trash-alt"></i></a>
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
                <div id="history" class="tab-pane fade in" style="overflow: auto;">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{ __('shop::admin.order_history.activity') }}</th>
                            <th class="text-right">{{ __('shop::admin.order_history.date_of_event') }}</th>
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
                                <td colspan="3" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div id="returns" class="tab-pane fade in" style="overflow: auto;">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="max-width: 50px">№</th>
                            <th>{{ __('shop::admin.returned_products.status_of_return') }}</th>
                            <th>{{ __('shop::admin.returned_products.order_number') }}</th>
                            <th>{{ __('shop::admin.returned_products.date_and_hour') }}</th>
                            <th>{{ __('shop::admin.common.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!is_null($order->returns) && count($order->returns))
                            @foreach($order->returns as $return)
                                <tr class="t-row">
                                    <td style="max-width: 50px;">RE-{{ $return->id }}</td>
                                    <td>{{ $return->statusHumanReadable() }}</td>
                                    <td>{{ $return->order->id }}</td>
                                    <td>{{ Carbon::parse($return->created_at)->format('d.m.Y H:i:s') }}</td>
                                    <td class="pull-right">
                                        <a href="{{ route('orders.returns.show', ['id' => $return->id]) }}" class="btn btn-primary" role="button"><i class="fas fa-binoculars"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="no-table-rows">{{ __('shop::admin.returned_products.no_return_requests') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
