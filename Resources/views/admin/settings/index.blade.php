@extends('layouts.admin.app')
@section('styles')
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @include('admin.notify')


    <div class="row">
        <div class="col-xs-12">
            <h3>@lang('shop::admin.shop.settings_index')</h3><br>
            <div class="alert alert-warning">
                <strong>Внимание!</strong>
                <br>
                <span>Всяко действие в настройките може да доведе до каскадни промени. Ако сте обучен за работа с тази част от магазина, моля, продължете.</span>
            </div>
            <div class="settings-icons-wrapper">
                <div>
                    <a href="#">
                        <img src="{{ asset('admin/assets/images/cart.svg') }}">
                        <span>Основни</span>
                    </a>
                </div>

                <div>
                    <a href="{{ route('payments.index') }}">
                        <img src="{{ asset('admin/assets/images/cart.svg') }}">
                        <span>{{ __('shop::admin.payments.index') }}</span>
                    </a>
                </div>

                <div>
                    <a href="{{ route('deliveries.index') }}">
                        <i class="fas fa-truck fa-5x"></i>
                        <span>{{ __('shop::admin.deliveries.index') }}</span>
                    </a>
                </div>

                <div>
                    <a href="{{ route('zip_codes.index') }}">
                        <img src="{{ asset('admin/assets/images/cart.svg') }}">
                        <span>{{ __('shop::admin.post_codes.index') }}</span>
                    </a>
                </div>

                <div>
                    <a href="#">
                        <img src="{{ asset('admin/assets/images/cart.svg') }}">
                        <span>{{ __('shop::admin.vats.index') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
