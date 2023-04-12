@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
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
    @include('shop::admin.registered_users.breadcrumbs')
    @include('admin.notify')
    @include('admin.partials.index.top_search_with_mass_buttons', ['mainRoute' => Request::segment(2).'.'.Request::segment(3), 'noCreate' => ''])

    <table id="example" class="table table-striped">
        <thead>
        <tr>
            <th>{{ __('shop::admin.registered_users.full_name') }}</th>
            <th>{{ __('shop::admin.registered_users.email') }}</th>
            <th>{{ __('shop::admin.orders.index') }}</th>
            <th>{{ __('admin.active_status') }}</th>
            <th>{{ __('shop::admin.registered_users.registered_at') }}</th>
            <th>{{ __('admin.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($registeredUsers))
            @foreach($registeredUsers as $client)
                <tr class="t-row">
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->countOrders() }}</td>
                    <td>
                        @if($client->active)
                            <label class="label label-success">Да</label>
                        @else
                            <label class="label label-danger">Не</label>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($client->created_at)->format('d.m.Y') }}</td>
                    <td class="pull-right">
                        <a href="{{ url('/admin/shop/clients/'.$client->id.'/show') }}" class="btn btn-primary" role="button"><i class="fas fa-binoculars"></i></a>
                        <a href="{{ url('/admin/shop/clients/'.$client->id.'/edit') }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                        @if(!$client->active)
                            <a href="{{ url('/admin/shop/clients/active/'.$client->id.'/1') }}" role="button" class="btn light-grey-eye visibility-activate"><i class="far fa-eye-slash"></i></a>
                        @else
                            <a href="{{ url('/admin/shop/clients/active/'.$client->id.'/0') }}" role="button" class="btn grey-eye visibility-unactive"><i class="far fa-eye"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="no-table-rows">{{ trans('admin.no-records') }}</td>
            </tr>
        @endif
        </tbody>

    </table>
@endsection
