@extends('layouts.admin.app')
@section('styles')
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @include('admin.notify')


    <div class="row">
        <div class="col-xs-12">
            <h3>@lang('shop::admin.shop.settings_index')</h3>
            <div class="settings-icons-wrapper">
                <div>
                    <a href="#">
                        <img src="{{ asset('admin/assets/images/cart.svg') }}">
                        <span>Магазин</span>
                    </a>
                </div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
@endsection
