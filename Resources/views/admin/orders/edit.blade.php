@php use Carbon\Carbon;use Modules\Shop\Entities\Orders\Order; @endphp@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/plugins/foundation-datepicker/datepicker.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
    <link href="{{ asset('admin/assets/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
    {{--    <script src="{{ asset('admin/assets/js/shop/order.js') }}"></script>--}}
    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/foundation-datepicker/datepicker.js') }}"></script>
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

            $('#submitCompany').click(function () {
                var form     = $('#addCompanyForm');
                var formData = form.serialize(); // Serialize form data

                $.ajax({
                    url: form.attr('action'), // Replace with your URL
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        var newCompanyRow = '<tr>' +
                            '<td>' + response.company_name + '</td>' +
                            '<td>' + response.company_mol + '</td>' +
                            '<td>' + response.company_eik + '</td>' +
                            '<td>' + (response.company_vat_eik || 'Няма') + '</td>' +
                            '<td>' + response.company_address + '</td>' +
                            '</tr>';
                        $('.firm-accounts-table tbody').html('');
                        $('.firm-accounts-table tbody').html(newCompanyRow);
                        $('#addCompanyModal').modal('hide');
                    },
                    error: function (error) {
                        // Handle error
                        console.log(error);
                    }
                });
            });

            $('.update-order-comment').click(function () {
                var orderId = $(this).attr('order_id');
                var comment = $('textarea[name="comment"]').val();

                $.ajax({
                    url: '{{ route('admin.shop.orders.edit.comment_update', ['id' => $order->id]) }}',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        comment: comment,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert(response.errors.join("\n"));
                        }
                    },
                    error: function (xhr, status, error) {
                        try {
                            var resp = JSON.parse(xhr.responseText);
                            if (resp.errors) {
                                alert(resp.errors.join("\n"));
                            } else {
                                alert('Error updating comment');
                            }
                        } catch (e) {
                            alert('Error updating comment');
                        }
                    }
                });
            });

            $('.update-order-others').click(function () {
                var orderId = $(this).attr('order_id');
                var with_utensils = $('input[name="with_utensils"]').prop('checked');

                $.ajax({
                    url: '{{ route('admin.shop.orders.edit.others_update', ['id' => $order->id]) }}',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        with_utensils: with_utensils,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert(response.errors.join("\n"));
                        }
                    },
                    error: function (xhr, status, error) {
                        try {
                            var resp = JSON.parse(xhr.responseText);
                            if (resp.errors) {
                                alert(resp.errors.join("\n"));
                            } else {
                                alert('Error updating others info');
                            }
                        } catch (e) {
                            alert('Error updating others info');
                        }
                    }
                });
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
    @if(!is_null($order->sent_to_yanak_at))
        <div class="myadmin-alert alert alert-warning notify-position-top d-flex" style="justify-content: space-between;">
            <div>
                <i class="fas fa-engine-warning"></i>
                <strong>Внимание! </strong> Тази поръчка вече е изпращана към Янак на {{ $order->sent_to_yanak_at }}
            </div>
            <a href="#" class="closed"><i class="far fa-times-circle"></i></a>
        </div>
    @endif
    <div class="col-xs-12 p-0">
        <div class="bg-grey top-search-bar">
            <div class="action-mass-buttons pull-right" style="display: flex;">
                <form action="{{ route('admin.shop.yanak.post-order', ['id' => $order->id]) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-lg btn-primary margin-bottom-10 m-r-5">Изпрати към Янак</button>

                </form>
                <a href="{{ route('admin.shop.orders') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>
                <strong>Поръчка № {{ $order->id }}</strong>
            </h3>
            <h5>Регистрирана на дата: <strong>{{ Carbon::parse($order->created_at)->format('d.m.Y H:i:s') }}</strong></h5>
            <hr>
            <h3 class="text-purple">Клиент</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td>{{ __('shop::admin.orders.ordered_from') }}</td>
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
                        <td>{{ __('shop::admin.registered_users.birthday') }}</td>
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
                </tbody>
            </table>
            <br>
            <h4>Промени статусите</h4>
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td style="display: flex;">@lang('shop::admin.orders.status')</td>
                    <td>
                        <form action="{{ route('admin.shop.orders.shipment-status-update', ['id' => $order->id]) }}" method="post">
                            @csrf
                            <div style="display: flex;">
                                <select name="status" class="select2 order_status_select" style="width: 100%;">
                                    <option value="{{ Order::SHIPMENT_WAITING }}">{{ trans('shop::admin.order_shipment_statuses.' . Order::SHIPMENT_WAITING) }}</option>
                                    {{--                                    <option value="{{ Order::SHIPMENT_PROCESSING }}">{{ trans('shop::admin.order_shipment_statuses.' . Order::SHIPMENT_PROCESSING) }}</option>--}}
                                    <option value="{{ Order::SHIPMENT_SENT }}">{{ trans('shop::admin.order_shipment_statuses.' . Order::SHIPMENT_SENT) }}</option>
                                    <option value="{{ Order::SHIPMENT_DELIVERED }}">{{ trans('shop::admin.order_shipment_statuses.' . Order::SHIPMENT_DELIVERED) }}</option>
                                    <option value="{{ Order::SHIPMENT_CANCELED }}">{{ trans('shop::admin.order_shipment_statuses.' . Order::SHIPMENT_CANCELED) }}</option>
                                    <option value="{{ Order::SHIPMENT_RETURNED }}">{{ trans('shop::admin.order_shipment_statuses.' . Order::SHIPMENT_RETURNED) }}</option>
                                </select>
                                <button type="submit" class="btn save-btn m-l-5 pull-right"><i class="fas fa-save"></i></button>
                            </div>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td style="display: flex;">@lang('shop::admin.orders.payment_status')</td>
                    <td>
                        <form action="{{ route('admin.shop.orders.payment-status-update', ['id' => $order->id]) }}" method="post">
                            @csrf
                            <div style="display: flex;">
                                <select name="status" class="select2 order_status_select" style="width: 100%;">
                                    <option value="{{ Order::PAYMENT_PENDING }}">{{ trans('shop::admin.order_payment_statuses.' . Order::PAYMENT_PENDING) }}</option>
                                    <option value="{{ Order::PAYMENT_CANCELED }}">{{ trans('shop::admin.order_payment_statuses.' . Order::PAYMENT_CANCELED) }}</option>
                                    <option value="{{ Order::PAYMENT_REFUND }}">{{ trans('shop::admin.order_payment_statuses.' . Order::PAYMENT_REFUND) }}</option>
                                    <option value="{{ Order::PAYMENT_PARTIAL_COMPENSATION }}">{{ trans('shop::admin.order_payment_statuses.' . Order::PAYMENT_PARTIAL_COMPENSATION) }}</option>
                                    <option value="{{ Order::PAYMENT_PAID }}">{{ trans('shop::admin.order_payment_statuses.' . Order::PAYMENT_PAID) }}</option>
                                </select>
                                <button type="submit" class="btn save-btn m-l-5 pull-right"><i class="fas fa-save"></i></button>
                            </div>
                        </form>
                    </td>
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
            <h3 class="text-purple">{{ __('shop::admin.orders.payment_caption') }}</h3>
            @if(!is_null($order->paid_at))
                <div class="alert alert-success">{{ __('shop::admin.orders.paid_at') }} {{ Carbon::parse($order->paid_at)->format('d.m.Y H:i:s') }}</div>
            @endif
            <div>
                <h4>{{ __('shop::admin.orders.payment') }}</h4>
                <div class="form-control">{{ $order->getReadablePaymentMethod() }}</div>
            </div>
            <div class="m-t-10">
                <table class="table table-striped payment-addresses-table hidden">
                    <thead>
                    <tr>
                        <th style="display: flex; justify-content: space-between;align-items: center; padding-right: 0;">
                            <h4>{{ __('shop::admin.orders.payment_address') }}</h4>
                        </th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <h3 class="text-purple">@lang('shop::admin.orders.delivery')</h3>
            @if(!is_null($order->delivered_at))
                <div class="alert alert-success">{{ __('shop::admin.orders.delivered_at') }} {{ Carbon::parse($order->delivered_at)->format('d.m.Y H:i:s') }}</div>
            @endif
            <div>
                <h4>{{ __('shop::admin.orders.delivery_method') }}</h4>
                <div class="form-control">{{ $order->getReadableShipmentMethod() }}</div>
            </div>
            <div class="m-t-10">
                <table class="table table-striped shipment-addresses-table">
                    <thead>
                    <tr>
                        <th style="display: flex; justify-content: space-between;align-items: center; padding-right: 0;">
                            <h4>{{ __('shop::admin.orders.delivery_address') }}</h4>
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
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="d-flex" style="align-items: flex-end;justify-content: space-between;">
                <h3 class="text-purple">Коментар към поръчката</h3>
                <div class="text-right">
                    <div class="btn save-btn update-order-comment" order_id="{{ $order->id }}"><i class="fas fa-save"></i></div>
                </div>
            </div>
            <div class="form-group description @if($errors->has('comment')) has-error @endif">
                <label class="control-label p-b-10">Коментар</label>
                <textarea name="comment" class="col-xs-12 form-control m-b-10" rows="4">{{ old('comment') ?: $order->comment }}</textarea>
                @if($errors->has('comment'))
                    <span class="help-block">{{ trans($errors->first('comment')) }}</span>
                @endif
            </div>

        </div>

        <div class="col-md-6">
            <div class="d-flex" style="align-items: flex-end;justify-content: space-between;">
                <h3 class="text-purple">Други</h3>
                <div class="text-right">
                    <div class="btn save-btn update-order-others" order_id="{{ $order->id }}"><i class="fas fa-save"></i></div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">Искам прибори</label>
                <div class="">
                    <label class="switch pull-left">
                        <input type="checkbox" name="with_utensils" class="success" data-size="small" {{($order->with_utensils ? 'checked' : '')}}>
                        <span class="slider"></span>
                    </label>
                </div>
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
            <button type="button" class="btn green" data-toggle="modal" data-target="#addCompanyModal"><i class="fas fa-pencil-alt"></i></button>
            @include('shop::admin.orders.add_firm_modal')
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
                        <td>{{ ($order->company_vat_eik =='') ? 'Няма': $order->company_vat_eik }}</td>
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
                    @if(!isset($basket) || is_null($basket))
                        <div class="col-xs-12 p-0">
                            <div class="bg-grey top-search-bar">
                                <div class="action-mass-buttons pull-right">
                                    <a href="{{ route('admin.shop.orders.edit_products', ['id' => $order->id]) }}" class="btn btn-lg green tooltips" role="button"><i class="fas fa-pencil-alt"></i></a>
                                </div>
                            </div>
                        </div>

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
                                                            <th class="text-right">Цена с ДДС</th>
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
                    @else
                        @include('shop::admin.orders.edit_products')
                    @endif
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
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_name" autocomplete="off" value="{{ $order->invoice_recipient_name }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span>
                                М.О.Л.:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_mol" autocomplete="off" value="{{ $order->invoice_recipient_mol }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span>
                                ЕИК:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_uik" autocomplete="off" value="{{ $order->invoice_recipient_uik }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3">ЕИК по ДДС:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_vat" autocomplete="off" value="{{ $order->invoice_recipient_vat }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3">Град по регистрация:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_city" autocomplete="off" value="{{ $order->invoice_recipient_city }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3">Адрес по регистрация:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_address" autocomplete="off" value="{{ $order->invoice_recipient_address }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label p-l-0 p-b-10 col-md-3">Телефон:</label>
                            <input class="form-control col-md-9" type="text" name="invoice_recipient_phone" autocomplete="off" value="{{ $order->invoice_recipient_phone }}">
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
                            <option value="">{{ __('admin.common.please_select') }}</option>
                            @foreach($payments as $payment)
                                <option value="{{ $payment->id }}">{{ __('shop::admin.payment_systems.' . $payment->type) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 p-t-b-10 text-left" style="display: flex;justify-content: space-between;">
                        <span class="btn btn-success change-payment-type-submit" order_id="{{ $order->id }}">Запис</span>
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
                            <option value="">{{ __('admin.common.please_select') }}</option>
                            <option value="1">{!! trans('administration_messages.delivery_type_1') !!}</option>
                            <option value="2">{!! trans('administration_messages.delivery_type_2') !!}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 p-t-b-10 text-left" style="display: flex;justify-content: space-between;">
                        <span class="btn btn-success change-shipment-type-submit" order_id="{{ $order->id }}">Запис</span>
                        <span class="btn btn-danger" data-dismiss="modal">Отказ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
