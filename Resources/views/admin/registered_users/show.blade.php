@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @include('shop::admin.registered_users.breadcrumbs')
    @include('admin.notify')
    @include('admin.partials.modals.delete_confirm')
    <div class="col-xs-12 p-0">
        <div class="bg-grey top-search-bar">
            <div class="action-mass-buttons pull-right">
                <a href="{{ url()->previous() }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3>@lang('shop::admin.registered_users.statistics')</h3>

            <div class="flex" style="display: flex;justify-content: space-around;flex-direction: column;">
                <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;padding-bottom: 20px;">
                    <span style="font-size: 50px;font-weight: 400;color: deepskyblue;">{{ $registeredUser->countOrders() }}</span>
                    <span class="m-t-10">@lang('shop::admin.registered_users.orders')</span>
                </div>

                <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;padding-bottom: 20px;">
                    <span style="font-size: 50px;font-weight: 400;color: #1de071;">213355622.65 лв.</span>
                    <span class="m-t-10">@lang('shop::admin.registered_users.total_value')</span>
                </div>

                <div style="display: flex;justify-content: space-around;">
                    <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;padding-bottom: 20px;">
                        <span style="font-size: 50px;font-weight: 400;color: deepskyblue;">5550</span>
                        <span class="m-t-10">@lang('shop::admin.registered_users.abandoned_carts')</span>
                    </div>

                    <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;padding-bottom: 20px;">
                        <span style="font-size: 50px;font-weight: 400;color: deepskyblue;">2034</span>
                        <span class="m-t-10">@lang('shop::admin.registered_users.returned_products')</span>
                    </div>

                    <div style="display: flex;flex-direction: column;align-items: center;justify-content: flex-end;padding-bottom: 20px;">
                        <span style="font-size: 50px;font-weight: 400;color: deepskyblue;">22340</span>
                        <span class="m-t-10">@lang('shop::admin.registered_users.favorite_products')</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <h3>@lang('shop::admin.registered_users.account')</h3>
            <div class="padding-20 bg-f5">
                <div class="form-group">
                    <label class="control-label p-b-10">@lang('shop::admin.registered_users.name_surname')</label>
                    <p><strong>{{ $registeredUser->first_name . ' ' . $registeredUser->last_name }}</strong></p>
                </div>
                <div class="form-group">
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
                    <p><strong>{{ $registeredUser->birtday != '' ? Carbon::parse($registeredUser->birtday)->format('d.m.Y') : '' }}</strong></p>
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
        <div class="col-md-12">
            <div class="flex" style="display: flex;justify-content: space-around;">
                <div>
                    <a href="{{ route('admin.shop.registered-users.orders.index', ['id' => $registeredUser->id]) }}" class="flex-href" target="_blank">
                        <i class="fas fa-box fa-3x"></i>
                        <span class="m-t-10">{{ trans('shop::admin.registered_users.orders') }}</span>
                    </a>
                </div>

                <div>
                    <a href="{{ route('admin.shop.registered-users.returned-products.index', ['id' => $registeredUser->id]) }}" class="flex-href" target="_blank">
                        <i class="fas fa-undo-alt fa-3x"></i>
                        <span class="m-t-10">{{ trans('shop::admin.registered_users.returned_products') }}</span>
                    </a>
                </div>

                <div>
                    <a href="{{ route('admin.shop.registered-users.abandoned-baskets.index', ['id' => $registeredUser->id]) }}" class="flex-href" target="_blank">
                        <i class="fas fa-shopping-basket fa-3x"></i>
                        <span class="m-t-10">{{ trans('shop::admin.registered_users.abandoned_carts') }}</span>
                    </a>
                </div>

                <div>
                    <a href="{{ route('admin.shop.registered-users.favorite-products.index', ['id' => $registeredUser->id]) }}" class="flex-href" target="_blank">
                        <i class="fas fa-box fa-3x"></i>
                        <span class="m-t-10">{{ trans('shop::admin.registered_users.favorite_products') }}</span>
                    </a>
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
        <div class="col-xs-12">
            <div class="caption-wrapper">
                <h3>@lang('shop::admin.registered_users.company_info')</h3>
                <a href="{{ route('admin.shop.registered-users.companies.create', ['id' => $registeredUser->id]) }}" class="btn green">@lang('shop::admin.registered_users.add_company')</a>
            </div>
        </div>
    </div>
    <div class="row m-t-40">
        <div class="col-xs-12">
            @if($registeredUser->companies->isNotEmpty())
                <div class="cards-wrapper">
                    @foreach($registeredUser->companies as $company)
                        @include('shop::admin.registered_users.firms.partials.firm_card', ['registeredUser' => $registeredUser, 'company'=> $company])
                    @endforeach
                </div>
            @else
                <div class="alert alert-danger">{{ trans('shop::admin.registered_users.no_companies') }}</div>
            @endif
        </div>
    </div>

    <div class="row m-t-40">
        <div class="col-xs-12">
            <div class="caption-wrapper">
                <h3>@lang('shop::admin.registered_users.shipment_addresses')</h3>
                <a href="{{ route('admin.shop.registered-users.shipment-addresses.create', ['id' => $registeredUser->id]) }}" class="btn green">@lang('shop::admin.registered_users.add_shipment_address')</a>
            </div>
        </div>
    </div>
    <div class="row m-t-40">
        <div class="col-xs-12">
            @if($registeredUser->shipmentAddresses->isNotEmpty())
                <div class="cards-wrapper">
                    @foreach($registeredUser->shipmentAddresses as $address)
                        @include('shop::admin.registered_users.partials.address', ['address'=> $address, 'type' => 'shipment'])
                    @endforeach
                </div>
            @else
                <div class="alert alert-danger">{{ trans('shop::admin.registered_users.no_companies') }}</div>
            @endif
        </div>
    </div>

    <div class="row m-t-40">
        <div class="col-xs-12">
            <div class="caption-wrapper">
                <h3>@lang('shop::admin.registered_users.payment_addresses')</h3>
                <a href="{{ route('admin.shop.registered-users.payment-addresses.create', ['id' => $registeredUser->id]) }}" class="btn green">@lang('shop::admin.registered_users.add_payment_address')</a>
            </div>
        </div>
    </div>
    <div class="row m-t-40">
        <div class="col-xs-12">
            @if($registeredUser->paymentAddresses->isNotEmpty())
                <div class="cards-wrapper">
                    @foreach($registeredUser->paymentAddresses as $address)
                        @include('shop::admin.registered_users.partials.address', ['address'=> $address, 'type' => 'payment'])
                    @endforeach
                </div>
            @else
                <div class="alert alert-danger">{{ trans('shop::admin.registered_users.no_companies') }}</div>
            @endif
        </div>
    </div>
@endsection
