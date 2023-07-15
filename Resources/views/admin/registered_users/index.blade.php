@php use Carbon\Carbon; @endphp@extends('layouts.admin.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
    <link href="{{ asset('admin/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.fixedHeader.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var options = {
                withSortableRow: true,
                sortableRowFromColumn: 0,
                sortableRowToColumn: 5,
                rowsPerPage: 50
            }
            initDatatable('example', options);
        });

    </script>
@endsection

@section('content')
    @include('shop::admin.registered_users.breadcrumbs')
    @include('admin.notify')
    @include('admin.partials.index.top_search_with_mass_buttons', ['mainRoute' => Request::segment(2).'.'.Request::segment(3), 'noMultipleActive' => true, 'noMultipleDelete' => true])

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
                    <td>{{ $client->first_name . ' ' . $client->last_name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->countOrders() }}</td>
                    <td>
                        @if($client->active)
                            <label class="label label-success">Да</label>
                        @else
                            <label class="label label-danger">Не</label>
                        @endif
                    </td>
                    <td>{{ Carbon::parse($client->created_at)->format('d.m.Y') }}</td>
                    <td class="pull-right">
                        <a href="{{ route('admin.shop.registered-users.orders.index', ['id' => $client->id]) }}" class="btn btn-primary" role="button"><i class="fas fa-box"></i></a>
                        <a href="{{ route('admin.shop.registered-users.show', ['id' => $client->id]) }}" class="btn btn-primary" role="button"><i class="fas fa-binoculars"></i></a>
                        <a href="{{ route('admin.shop.registered-users.edit', ['id' => $client->id]) }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                        @if(!$client->active)
                            <a href="{{ route('admin.shop.registered-users.changeStatus', ['id' => $client->id, 'active' => 1]) }}" role="button" class="btn light-grey-eye visibility-activate"><i class="far fa-eye-slash"></i></a>
                        @else
                            <a href="{{ route('admin.shop.registered-users.changeStatus', ['id' => $client->id, 'active' => 0]) }}" role="button" class="btn grey-eye visibility-unactive"><i class="far fa-eye"></i></a>
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
