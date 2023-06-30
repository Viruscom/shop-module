@php use Carbon\Carbon; @endphp@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
    {{-- <link href="{{ asset('admin/css/jquery.dataTables.min.css') }}" rel="stylesheet" /> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
    <link href="{{ asset('admin/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap-confirmation.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.fixedHeader.min.js') }}"></script>
    <script>
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            container: 'body',
        });
        $(".select2").select2({language: "bg"});
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                placement: 'auto',
                trigger: 'hover',
                html: true,
            }).on("show.bs.popover", function () {
                $(this).data("bs.popover").tip().css("max-width", "80%");
            });
            // Setup - add a text input to each footer cell
            $('#example thead tr').clone(true).appendTo('#example thead');
            $('#example thead tr:eq(1) th').each(function (i) {
                var title = $(this).text();
                $(this).html('<input type="text" class="datatable-filter-input" placeholder="филтрирай по ' + title + '" style="width:100%;" />');

                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            var table = $('#example').DataTable({
                "order": [[7, "desc"]],
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
        <div class="col-md-12 overflow-auto">
            <table id="example" class="table table-striped">
                <thead>
                <tr>
                    <th style="max-width: 50px">№</th>
                    <th>Дата</th>
                    <th>Статус на изпълнение</th>
                    <th>Статус на плащане</th>
                    <th>Клиент</th>
                    <th>Населено място</th>
                    <th>Сума</th>
                    <th>Метод на плащане</th>
                    <th>Метод на доставка</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @if(count($orders))
                    @foreach($orders as $order)
                        <tr class="t-row">
                            <td style="max-width: 50px;">{{ $order->id }}</td>
                            <td>
                                @if($order->returned_amount != '')
                                    <img src="{{ asset('admin/assets/images/return_order_black.svg') }}" width="24" alt="" style="margin-right: 12px;">
                                @endif
                                <span style="background: {{ $order->getStatusClass($order->status()) }};padding: 4px; color: #000000;">{{ $order->statusHumanReadable() }}</span></td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->city .', '. $order->shipment_address }}</td>
                            <td>
                                <div data-toggle="popover" data-content='@include('admin.partials.shop.orders.summary', ['orderPrices'=>$orderPrices, 'order'=>$order])'>
                                    Общо: {{ $orderPrices[$order->id]['total_without_discounts'] }} лв.
                                    <span>Отстъпки: <strong class="text-purple">-{{ $orderPrices[$order->id]['total_discounts'] }}</strong> лв.</span><br>
                                    <span>Общо с отстъпки и ДДС: {{ $orderPrices[$order->id]['total_with_discounts_and_shipment'] }} лв.</span>
                                </div>
                            </td>
                            <td>{{ $order->paymentTypeHumanReadable() }}</td>
                            <td>
                                <strong>{{ Carbon::parse($order->created_at)->format('d.m.Y') }} г.</strong><br>
                                <span>Час: {{ Carbon::parse($order->created_at)->format('H:i:s') }}</span>
                            </td>
                            <td class="pull-right">
                                <a href="{{ url('/admin/shop/orders/'.$order->id.'/show') }}" class="btn btn-primary" role="button"><i class="fas fa-binoculars"></i></a>
                                <a href="{{ url('/admin/shop/orders/'.$order->id.'/edit') }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
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
