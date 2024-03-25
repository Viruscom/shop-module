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
    <form action="{{ route('admin.shop.orders.create-step-two') }}" method="POST" data-form-type="store">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="hidden">
            <input type="text" name="admin_basket_key" value="{{ $basket->key }}">
            <input type="text" name="payment_address_id" value="0">
            <input type="text" name="shipment_address_id" class="shipment" value="0">
            <input type="text" name="firm_account_id" value="0">
            <input type="text" name="client_group_id" value="1">
            <input type="text" name="client_id" value="">
            <input type="text" name="status_id" id="order_status_id" class="form-control col-md-12 hidden" value="{{ Order::SHIPMENT_WAITING }}">
        </div>
        <div class="row client-info-wrapper">
            <div class="col-md-6 col-xs-12">
                <div>
                    <h3><strong>Нова поръчка</strong></h3>
                </div>
                <h3 class="text-purple">Клиент / Гост</h3>
                <div class="choose-client-guest-btns">
                    <div class="btn btn-success btn-sm add-guest">Въведи гост</div>
                    <div class="btn btn-success btn-sm add-client">Въведи клиент</div>
                </div>
                <div class="choose-guest">

                </div>
                <div class="choose-client hidden">
                    <select name="client_id" id="client_id_select" class="form-control select2">
                        <option value="">--- Моля, изберете ---</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->first_name . ' ' . $client->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <label for="order_status_id" class="form-label col-md-12 text-right">@lang('shop::admin.orders.status')</label>
                <p class="form-control col-md-12" disabled>{{ trans('shop::admin.order_shipment_statuses.' . Order::SHIPMENT_WAITING) }}</p>
                <label for="order_status_id" class="form-label col-md-12 text-right">@lang('shop::admin.orders.payment_status')</label>
                <p class="form-control col-md-12" disabled>{{ trans('shop::admin.order_payment_statuses.' . Order::PAYMENT_PENDING) }}</p>
            </div>
        </div>
        <div class="row">
            <hr>
        </div>
        <div class="row payment-and-delivery-wrapper">
            <div class="col-md-6">
                <h3 class="text-purple">Плащане</h3>
                <div>
                    <h4>Метод на плащане</h4>
                    <select name="payment_id" id="payment_type_id_select" class="form-control select2">
                        <option value="">{{ __('admin.common.please_select') }}</option>
                        @foreach($paymentMethods as $method)
                            @if($method->type == 'cash_on_delivery')
                                <option value="{{ $method->id }}" selected>{{ __('shop::admin.payment_systems.'.$method->type) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="m-t-10">
                    <table class="table table-striped payment-addresses-table hidden">
                        <thead>
                        <tr>
                            <th style="display: flex; justify-content: space-between;align-items: center; padding-right: 0;">
                                <h4>Адрес на плащане</h4>
                                <div class="btn btn-sm btn-success add-payment-address-btn">Добави адрес</div>
                            </th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div class="add-payment-address hidden">
                        <div class="alert alert-info">Въвеждане на нов адрес на плащане</div>
                        <div class="bg-e8-payment"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="text-purple">Доставка</h3>
                <div>
                    <h4>Метод на доставка</h4>
                    <select name="delivery_id" id="shipment_type_id_select" class="form-control select2">
                        <option value="">{{ __('admin.common.please_select') }}</option>
                        @foreach($deliveryMethods as $method)
                            <option value="{{ $method->id }}" selected>{{ __('shop::admin.delivery_systems.'.$method->type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="m-t-10">
                    <table class="table table-striped shipment-addresses-table">
                        <thead>
                        <tr>
                            <th style="display: flex; justify-content: space-between;align-items: center; padding-right: 0;">
                                <h4>Адрес на доставка</h4>
                                <div class="btn btn-sm btn-success btn-address-shipment">Добави адрес</div>
                                @include('shop::admin.orders.create.modal_address')
                            </th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div class="alert alert-success success-delivery-div hidden"><strong>Чудесно! </strong>Адресът на доставка е потвърден и ще бъде добавен при завършване на поръчката.</div>
                    <div class="add-shipment-address hidden">
                        <div class="alert alert-info">Въвеждане на нов адрес на доставка</div>
                        <div class="bg-e8-shipment"></div>
                        <div class="hidden">
                            <input type="text" name="country_id" value="{{ $countryId }}">
                            <input type="text" name="city_id" value="{{ $cityId }}">
                            <input type="text" name="new_address" value="0">
                            <input type="text" name="street" class="str">
                            <input type="text" name="street_number" class="str-num">
                            <input type="text" name="zip_code" class="zip">
                            <input type="text" name="entrance">
                            <input type="text" name="floor">
                            <input type="text" name="apartment">
                            <input type="text" name="bell_name">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <hr>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-purple">Коментар към поръчката</h3>
                <div class="form-group description ">
                    <label class="control-label p-b-10">Коментар</label>
                    <textarea name="comment" class="col-xs-12 form-control m-b-10" rows="4"></textarea>
                </div>
            </div>

            <div class="col-md-6">
                <h3 class="text-purple">Други</h3>
                <div class="form-group">
                    <label class="control-label">Искам прибори</label>
                    <div class="">
                        <label class="switch pull-left">
                            <input type="checkbox" name="with_utensils" class="success" data-size="small" {{(old('with_utensils') ? 'checked' : '')}}>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <hr>
        </div>

        <div class="row company-info-wrapper">
            <div class="col-md-12" style="display: flex;justify-content: space-between;align-items: center;">
                <h3 class="text-purple">Фирмени данни</h3>
                <div class="btn btn-sm btn-success add-firm-account-btn">Добави фирма</div>
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
                        <th>Телефон</th>
                        <th class="text-right">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="7" class="no-table-rows">{{ trans('shop::admin.registered_users.no_companies') }}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="add-firm-account hidden">
                    <div class="alert alert-info">Въвеждане на нова фирма</div>
                    <div class="bg-e8-company"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <hr>
        </div>

        <div class="form-actions form-actions-wrapper">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-success">Продължи към количка</button>
                    <a href="{{ route('admin.shop.orders.create.cancel') }}" class="btn btn-danger">Анулирай поръчката</a>
                </div>
            </div>
        </div>
    </form>
@endsection
