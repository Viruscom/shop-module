@php use Carbon\Carbon; @endphp@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
    {{-- <link href="{{ asset('admin/css/jquery.dataTables.min.css') }}" rel="stylesheet" /> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
    <link href="{{ asset('admin/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    @include('shop::admin.orders.returns.breadcrumbs')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.fixedHeader.min.js') }}"></script>
    <script>
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
    @include('shop::admin.orders.returns.breadcrumbs')
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
        </div>
    </div>
    <table id="example" class="table table-striped">
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
        @if(count($returns))
            @foreach($returns as $return)
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
                <td colspan="5" class="no-table-rows">{{ trans('shop::admin.returned_products.no_return_requests') }}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
