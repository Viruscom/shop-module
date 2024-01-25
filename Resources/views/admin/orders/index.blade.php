@php use Carbon\Carbon; @endphp@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
    <style>
        #example {
            font-size: 13px;
        }
        table.dataTable thead th, table.dataTable thead td {
            font-size: 13px;
            font-weight: 500;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dataTables.fixedHeader.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            var options = {
                withSortableRow: true,
                sortableRowFromColumn: 1,
                sortableRowToColumn: 9,
                withDynamicSort: true,
                dynamicSortFromColumn: 1,
                dynamicSortToColumn: 9,
                rowsPerPage: 50
            }
            initOrdersDatatable('example', options);


            function initOrdersDatatable(tableId, options) {
                if (options.withSortableRow) {
                    $('#' + tableId + ' thead tr').clone(true).appendTo('#' + tableId + ' thead').css('background-color', '#ebecef');
                    $('#' + tableId + ' thead tr:eq(1) th').each(function (i) {
                        if (i >= options.sortableRowFromColumn && i < options.sortableRowToColumn) {
                            var title = $(this).text();
                            $(this).html('<input type="text" class="datatable-filter-input head-filter-' + i + '" placeholder="Сортирай по ' + title + '" />');
                            $('input', this).on('keyup change', function () {
                                if (table.column(i).search() !== this.value) {
                                    table
                                        .column(i)
                                        .search(this.value)
                                        .draw();
                                }
                            });
                        } else {
                            $(this).html('');
                        }
                    });
                }

                var table = $('#' + tableId).DataTable({
                    iDisplayLength: 50,
                    orderCellsTop: true,
                    order: [[0, 'desc']],
                    fixedHeader: true,
                    stateSave: true,
                    responsive: true,
                    width: '10%',
                    "language": $.parseJSON($('#dataTableLang').text()),
                    "stateLoaded": function stateLoadedCallback(settings, state) {
                        state.columns.forEach(function (column, index) {
                            $('.head-filter-' + index).val(column.search.search);
                        });
                    }
                });
            }
        });
    </script>
@endsection

@section('content')
    @include('shop::admin.orders.breadcrumbs')
    @include('admin.notify')

    <div class="col-xs-12 p-0">
        <div class="bg-grey top-search-bar">
            <div class="search pull-left hidden-xs">
                <div class="input-group">
                    <input type="text" name="search" class="form-control input-sm search-text" placeholder="{{ __('admin.common.search') }}" autocomplete="off">
                    <span class="input-group-btn">
					<button class="btn btn-sm submit"><i class="fa fa-search"></i></button>
				</span>
                </div>
            </div>

            <div class="action-mass-buttons pull-right">
                <a href="{{ route('admin.shop.orders.create') }}" role="button" class="btn btn-lg tooltips green" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Създай нов">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="overflow: auto;">
            <table id="example" class="table table-striped">
                <thead>
                <tr>
                    <th style="max-width: 50px">№</th>
                    <th>Дата и час</th>
                    <th>Статус на изпълнение</th>
                    <th>{{ __('shop::admin.orders.payment_status') }}</th>
                    <th>Клиент</th>
                    <th>{{ __('shop::admin.orders.delivery_address') }}</th>
                    <th>Сума</th>
                    <th>{{ __('shop::admin.orders.payment') }}</th>
                    <th>{{ __('shop::admin.orders.delivery_method') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @if(count($orders))
                    @foreach($orders as $order)
                        <tr class="t-row">
                            <td style="max-width: 50px;">{{ $order->id }}</td>
                            <td>
                                <strong>{{ Carbon::parse($order->created_at)->format('d.m.Y') }} г.</strong><br>
                                <span>Час: {{ Carbon::parse($order->created_at)->format('H:i:s') }}</span>
                            </td>
                            <td>
                                @if($order->returned_amount != '')
                                    <img src="{{ asset('admin/assets/images/return_order_black.svg') }}" width="24" alt="" style="margin-right: 12px;">
                                @endif
                                <span style="background: {{ $order->getShipmentStatusClass($order->shipment_status) }};padding: 4px; color: #000000;">{{ $order->getReadableShipmentStatus() }}</span>
                            </td>
                            <td>
                                <span style="background: {{ $order->getPaymentStatusClass($order->payment_status) }};padding: 4px; color: #000000;">{{ $order->getReadablePaymentStatus() }}</span>
                            </td>
                            <td>{{ $order->first_name . ' ' . $order->last_name }}</td>
                            <td>{{ $order->street .', '. $order->street_number }}</td>
                            <td>
                                <div>
                                    Общо: {{ $order->totalEndDiscountedPriceWithAdditivesAndCollection() }} лв.<br>
                                    <span>Отстъпки: <strong class="text-purple">-{{ $order->totalDiscountsAmount() }}</strong> лв.</span><br>
                                    <span>Общо с ДДС и доставка: {{ $order->grandTotalWithDiscountsVatAndDelivery() }} лв.</span>
                                </div>
                            </td>
                            <td>{{ $order->getReadablePaymentMethod() }}</td>
                            <td>{{ $order->getReadableShipmentMethod() }}</td>

                            <td class="pull-right">
                                <a href="{{ route('admin.shop.orders.show', ['id' => $order->id]) }}" class="btn btn-primary" role="button"><i class="fas fa-binoculars"></i></a>
                                <a href="{{ route('admin.shop.orders.edit', ['id' => $order->id]) }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10" class="no-table-rows">{{ trans('shop::admin.orders.no_orders_found') }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
