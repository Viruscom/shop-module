<<<<<<< HEAD
@extends('layouts.admin.app')
=======
@extends('layouts.app')
>>>>>>> origin/main

@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/plugins/foundation-datepicker/datepicker.css') }}" rel="stylesheet"/>
    {{-- <link href="{{ asset('admin/css/jquery.dataTables.min.css') }}" rel="stylesheet" /> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
    <link href="{{ asset('admin/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/shop/js/client.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap-confirmation.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/foundation-datepicker/datepicker.js') }}"></script>
    <script>
        try {
            CKEDITOR.timestamp = new Date();
            CKEDITOR.replace('editor');
        } catch {
        }

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

            var table = $('#example').DataTable({
                "order": [[6, "desc"]],
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
<<<<<<< HEAD
    @include('shop::admin.registered_users.breadcrumbs')
    @include('admin.notify')
=======
>>>>>>> origin/main
    <div class="col-xs-12 p-0">
        <div class="bg-grey top-search-bar">
            <div class="action-mass-buttons pull-right">
                <a href="{{ url()->previous() }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
<<<<<<< HEAD
            <h3>Статистика</h3>
            <div class="flex" style="display: flex;justify-content: space-around;flex-direction: column;">
                <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;padding-bottom: 20px;">
                    <span style="font-size: 50px;font-weight: 400;color: deepskyblue;">50000</span>
                    <span class="m-t-10">Направени поръчки</span>
                </div>

                <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;padding-bottom: 20px;">
                    <span style="font-size: 50px;font-weight: 400;color: #1de071;">213355622.65 лв.</span>
                    <span class="m-t-10">Обща стойност</span>
                </div>

                <div style="display: flex;justify-content: space-around;">
                    <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;padding-bottom: 20px;">
                        <span style="font-size: 50px;font-weight: 400;color: deepskyblue;">5550</span>
                        <span class="m-t-10">Изоставени колички</span>
                    </div>

                    <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;padding-bottom: 20px;">
                        <span style="font-size: 50px;font-weight: 400;color: deepskyblue;">2034</span>
                        <span class="m-t-10">Върнати продукти</span>
                    </div>

                    <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;padding-bottom: 20px;">
                        <span style="font-size: 50px;font-weight: 400;color: deepskyblue;">22340</span>
                        <span class="m-t-10">Любими продукти</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>@lang('shop::admin.registered_users.account')</h3>
=======
            <h4>Акаунт</h4>
>>>>>>> origin/main
            <div class="padding-20 bg-f5">
                <div class="form-group">
                    <label class="control-label p-b-10">Име и фамилия:</label>
                    <p><strong>{{ $registeredUser->first_name . ' ' . $registeredUser->last_name }}</strong></p>
                </div>
                <div class="form-group">
<<<<<<< HEAD
                    <label class="control-label p-b-10">@lang('shop::admin.registered_users.email'):</label>
                    <p><strong><a href="mailto:{{ $registeredUser->email }}">{{ $registeredUser->email }}</a></strong></p>
                </div>
                <div class="form-group">
                    <label class="control-label p-b-10">@lang('shop::admin.registered_users.password'):</label>
                    <p><strong>*******</strong></p>
                </div>
            </div>

            <h3>@lang('shop::admin.registered_users.additional_info')</h3>
            <div class="padding-20 bg-f5">
                <div class="form-group">
                    <label class="control-label p-b-10">@lang('shop::admin.registered_users.client_group'):</label>
                    <p><strong>{{ trans('administration_messages.client_group_'.$registeredUser->group_id) }}</strong></p>
                </div>
                <div class="form-group @if($errors->has('phone')) has-error @endif">
                    <label class="control-label p-b-10">@lang('shop::admin.registered_users.phone'):</label>
                    <p><strong><a href="tel:{{ $registeredUser->phone }}">{{ $registeredUser->phone }}</a></strong></p>
                </div>
                <div class="form-group @if($errors->has('birtday')) has-error @endif">
                    <label class="control-label p-b-10">@lang('shop::admin.registered_users.birthday'):</label>
=======
                    <label class="control-label p-b-10">Email:</label>
                    <p><strong><a href="mailto:{{ $registeredUser->email }}">{{ $registeredUser->email }}</a></strong></p>
                </div>
                <div class="form-group">
                    <label class="control-label p-b-10">Парола:</label>
                    <p><strong>*******</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h4>Допълнителни данни</h4>
            <div class="padding-20 bg-f5">
                <div class="form-group">
                    <label class="control-label p-b-10">Клиентска група:</label>
                    <p><strong>{{ trans('administration_messages.client_group_'.$registeredUser->client_group_id) }}</strong></p>
                </div>
                <div class="form-group @if($errors->has('phone')) has-error @endif">
                    <label class="control-label p-b-10">Телефон:</label>
                    <p><strong><a href="tel:{{ $registeredUser->phone }}">{{ $registeredUser->phone }}</a></strong></p>
                </div>
                <div class="form-group @if($errors->has('birtday')) has-error @endif">
                    <label class="control-label p-b-10">Рожден ден:</label>
>>>>>>> origin/main
                    <p><strong>{{ $registeredUser->birtday != '' ? \Carbon\Carbon::parse($registeredUser->birtday)->format('d.m.Y') : '' }}</strong></p>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="flex" style="display: flex;justify-content: space-around;">
                <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;">
                    <i class="fas fa-box fa-3x"></i>
                    <span class="m-t-10">Поръчки</span>
                </div>

                <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;">
                    <i class="fas fa-undo-alt fa-3x"></i>
                    <span class="m-t-10">Върнати продукти</span>
                </div>

                <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;">
                    <i class="fas fa-shopping-basket fa-3x"></i>
                    <span class="m-t-10">Изоставени колички</span>
                </div>

                <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;">
                    <i class="fas fa-box fa-3x"></i>
                    <span class="m-t-10">Любими продукти</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <div class="row m-t-40">
        <div class="col-md-9 col-sm-9">
            <h4>@lang('shop::admin.registered_users.company_info')</h4>
        </div>
        <div class="col-md-3 col-sm-3 text-right m-b-10">
            <a href="{{ url('/admin/shop/clients/'.$registeredUser->id.'/firm_accounts/create') }}" class="btn green">@lang('shop::admin.registered_users.add_company')</a>
        </div>
        <div class="col-md-12 col-xs-12">
            <table class="table table-striped example">
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
                @if($registeredUser->companies->isNotEmpty())
                    @foreach($registeredUser->companies as $firmAccount)
                        <tr class="t-row">
                            <td>{{ $firmAccount->title }}</td>
                            <td>{{ $firmAccount->mol }}</td>
                            <td>{{ $firmAccount->eik }}</td>
                            <td>{{ $firmAccount->vat }}</td>
                            <td>{{ $firmAccount->registration_address }}</td>
                            <td>{{ $firmAccount->phone }}</td>
                            <td class="pull-right">
                                <a href="{{ url('/admin/shop/clients/'.$registeredUser->id.'/firm_accounts/'.$firmAccount->id.'/edit') }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                                <a href="https://www.google.bg/maps/place/{{ $firmAccount->city .' '. $firmAccount->registration_address }}" class="btn btn-primary" target="_blank"><i class="fas fa-map-marked-alt"></i></a>
                                <a href="{{ url('/admin/shop/clients/'.$registeredUser->id.'/firm_accounts/'.$firmAccount->id.'/delete') }}" class="btn red" data-toggle="confirmation"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="no-table-rows">{{ trans('shop::admin.registered_users.no_companies') }}</td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>
    </div>

    <div class="row m-t-40">
        <div class="col-md-9 col-sm-9">
            <h4>Адреси на доставка</h4>
=======
    <div class="row m-t-40">
        <div class="col-md-9 col-sm-9">
            <h4>Фирмени данни</h4>
>>>>>>> origin/main
        </div>
        <div class="col-md-3 col-sm-3 text-right m-b-10">
            <a href="{{ url('/admin/shop/clients/'.$registeredUser->id.'/firm_accounts/create') }}" class="btn green">Добави фирмени данни</a>
        </div>
        <div class="col-md-12 col-xs-12">
            <table class="table table-striped example">
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
                @if($registeredUser->companies->isNotEmpty())
                    @foreach($registeredUser->companies as $firmAccount)
                        <tr class="t-row">
                            <td>{{ $firmAccount->title }}</td>
                            <td>{{ $firmAccount->mol }}</td>
                            <td>{{ $firmAccount->eik }}</td>
                            <td>{{ $firmAccount->vat }}</td>
                            <td>{{ $firmAccount->registration_address }}</td>
                            <td>{{ $firmAccount->phone }}</td>
                            <td class="pull-right">
                                <a href="{{ url('/admin/shop/clients/'.$registeredUser->id.'/firm_accounts/'.$firmAccount->id.'/edit') }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                                <a href="https://www.google.bg/maps/place/{{ $firmAccount->city .' '. $firmAccount->registration_address }}" class="btn btn-primary" target="_blank"><i class="fas fa-map-marked-alt"></i></a>
                                <a href="{{ url('/admin/shop/clients/'.$registeredUser->id.'/firm_accounts/'.$firmAccount->id.'/delete') }}" class="btn red" data-toggle="confirmation"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
<<<<<<< HEAD
                        <td colspan="7" class="no-table-rows">{{ trans('shop::admin.registered_users.no_shipment_addresses') }}</td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>
    </div>

    <div class="row m-t-40">
        <div class="col-md-9 col-sm-9">
            <h4>Адреси на плащане</h4>
        </div>
        <div class="col-md-3 col-sm-3 text-right m-b-10">
            <a href="{{ url('/admin/shop/clients/'.$registeredUser->id.'/firm_accounts/create') }}" class="btn green">Добави фирмени данни</a>
        </div>
        <div class="col-md-12 col-xs-12">
            <table class="table table-striped example">
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
                @if($registeredUser->companies->isNotEmpty())
                    @foreach($registeredUser->companies as $firmAccount)
                        <tr class="t-row">
                            <td>{{ $firmAccount->title }}</td>
                            <td>{{ $firmAccount->mol }}</td>
                            <td>{{ $firmAccount->eik }}</td>
                            <td>{{ $firmAccount->vat }}</td>
                            <td>{{ $firmAccount->registration_address }}</td>
                            <td>{{ $firmAccount->phone }}</td>
                            <td class="pull-right">
                                <a href="{{ url('/admin/shop/clients/'.$registeredUser->id.'/firm_accounts/'.$firmAccount->id.'/edit') }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                                <a href="https://www.google.bg/maps/place/{{ $firmAccount->city .' '. $firmAccount->registration_address }}" class="btn btn-primary" target="_blank"><i class="fas fa-map-marked-alt"></i></a>
                                <a href="{{ url('/admin/shop/clients/'.$registeredUser->id.'/firm_accounts/'.$firmAccount->id.'/delete') }}" class="btn red" data-toggle="confirmation"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="no-table-rows">{{ trans('shop::admin.registered_users.no_payment_addresses') }}</td>
=======
                        <td colspan="7" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
>>>>>>> origin/main
                    </tr>
                @endif
                </tbody>

            </table>
        </div>
    </div>
    <div class="row m-t-40">
        <div class="col-sm-12 col-xs-12">
            <ul class="nav nav-tabs">
                <li class="active">
<<<<<<< HEAD
                    <a data-toggle="tab" href="#orders">{{ trans('shop::admin.orders.index') }}</a>
=======
                    <a data-toggle="tab" href="#orders">Поръчки</a>
>>>>>>> origin/main
                </li>

            </ul>
            <div class="tab-content">
                <div id="orders" class="tab-pane fade in active">
                    <table class="table table-striped example">
                        <thead>
                        <tr>
                            <th style="max-width: 50px">№</th>
<<<<<<< HEAD
                            <th>{{ trans('shop::admin.orders.status') }}</th>
                            <th>{{ trans('shop::admin.orders.ordered_from') }}</th>
                            <th>{{ trans('shop::admin.orders.grand_total') }}</th>
                            <th>{{ trans('shop::admin.orders.payment') }}</th>
                            <th>{{ trans('shop::admin.orders.ordered_on_date') }}</th>
                            <th>{{ __('admin.actions') }}</th>
=======
                            <th>Статус на поръчката</th>
                            <th>Име и фамилия</th>
                            <th>Сума на поръчката</th>
                            <th>Метод на плащане</th>
                            <th>Регистрирана на</th>
                            <th>Действия</th>
>>>>>>> origin/main
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($registeredUser->orders))
                            @foreach($registeredUser->orders as $order)
                                <tr class="t-row">
                                    <td style="max-width: 50px;">{{ $order->id }}</td>
                                    <td><span style="background: {{ $order->getStatusClass($order->status()) }};padding: 4px; color: #000000;">{{ $order->statusHumanReadable() }}</span></td>
                                    <td>{{ $order->name }}</td>
                                    <td>
                                        <div data-toggle="popover" data-content='@include('admin.partials.shop.orders.summary', ['orderPrices'=>$orderPrices, 'order'=>$order])'>
                                            Общо: {{ $orderPrices[$order->id]['total_without_discounts'] }} лв.
                                            <span>Отстъпки: <strong class="text-purple">-{{ $orderPrices[$order->id]['total_discounts'] }}</strong> лв.</span><br>
                                            <span>Общо с отстъпки и ДДС: {{ $orderPrices[$order->id]['total_with_discounts_and_shipment'] }} лв.</span>
                                        </div>
                                    </td>
                                    <td>{{ $order->paymentTypeHumanReadable() }}</td>
                                    <td>
                                        <strong>{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y') }} г.</strong><br>
                                        <span>Час: {{ \Carbon\Carbon::parse($order->created_at)->format('H:i:s') }}</span>
                                    </td>
                                    <td class="pull-right">
                                        <a href="{{ url('/admin/shop/orders/'.$order->id.'/show') }}" class="btn btn-primary" role="button"><i class="fas fa-binoculars"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
<<<<<<< HEAD
                                <td colspan="7" class="no-table-rows">{{ trans('shop::admin.orders.no_orders_found') }}</td>
                            </tr>
                        @endif
                        </tbody>
=======
                                <td colspan="7" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                            </tr>
                        @endif
                        </tbody>

>>>>>>> origin/main
                    </table>
                </div>

            </div>
        </div>
    </div>

<<<<<<< HEAD
=======

    <!-- The Modal -->
    <div id="firm_account_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h4>Добавяне на фирмени дани</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form class="form" style="z-index: 999;display: grid;">
                    <div class="form-group">
                        <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span> Фирма:</label>
                        <input class="form-control col-md-9" type="text" name="name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span> М.О.Л.:</label>
                        <input class="form-control col-md-9" type="text" name="mol" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label p-l-0 p-b-10 col-md-3"><span class="text-purple">*</span> ЕИК:</label>
                        <input class="form-control col-md-9" type="text" name="eik" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label p-l-0 p-b-10 col-md-3">ЕИК по ДДС:</label>
                        <input class="form-control col-md-9" type="text" name="eik_dds" autocomplete="off">
                    </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 p-t-b-10 text-left">
                        <span class="btn btn-success firm-account-submit">Запис</span>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

>>>>>>> origin/main
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="text" class="hidden" name="client_id" value="{{ $registeredUser->id }}">
@endsection
