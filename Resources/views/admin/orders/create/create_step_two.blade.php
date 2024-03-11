@php use Modules\Shop\Entities\Orders\Order; @endphp@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
    <link href="{{ asset('admin/assets/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/shop/order.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dataTables.fixedHeader.min.js') }}"></script>
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
@endsection

@section('content')
    @include('shop::admin.orders.breadcrumbs')
    @include('admin.notify')
    <form action="{{ route('admin.shop.orders.create.save', ['id' => $order->id]) }}" method="POST" data-form-type="store">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <hr>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#orders">Продукти</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="orders" class="tab-pane fade in active">
                        @include('shop::admin.orders.create.create_add_products')
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9 submit-wrapper-div">

                </div>
            </div>
        </div>
    </form>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
@endsection
