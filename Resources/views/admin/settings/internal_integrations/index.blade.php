@extends('layouts.admin.app')
@section('styles')
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @include('shop::admin.settings.main.breadcrumbs')
    @include('admin.notify')

    <div class="row">
        <div class="col-xs-12">
            <h3>{{ __('shop::admin.shop.settings_index') }} > {{ __('shop::admin.main_settings.integrations') }}</h3><br>
            <div class="alert alert-warning">{!! __('shop::admin.main_settings.warning') !!}</div>
            <div class="settings-icons-wrapper">
                <div>
                    <a href="{{ route('admin.shop.settings.internal-integrations.mail-chimp.edit') }}" style="background: #ffe01b;">
                        <img src="{{ asset('admin/assets/images/internal_integrations/logos/mailchimp.svg') }}">
                        <span>MailChimp</span>
                    </a>
                </div>

                <div>
                    <a href="{{ route('admin.shop.settings.internal-integrations.exchange-rate.edit') }}" style="background: #ffffff;border: 1px solid #9E9E9E;">
                        <img src="{{ asset('admin/assets/images/internal_integrations/logos/exchange_rate_api.webp') }}">
                        <span>Exchange Rate API</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
