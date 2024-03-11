@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @include('shop::admin.settings.internal_integrations.exchange_rate.breadcrumbs')
    @include('admin.notify')

    <form action="{{ route('admin.shop.settings.internal-integrations.exchange-rate.update') }}" method="POST">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ route('admin.shop.settings.internal-integrations.index') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form form-horizontal">
                    <div class="form-body">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span>{{ __('shop::admin.exchange_rate.settings') }}</span>
                                </div>
                            </div>
                            <div class="portlet-body">

                                <div class="form-group">
                                    <label class="control-label col-md-3">API KEY:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="EXCHANGE_RATE_API_KEY" value="{{ $exchangeRateApi->EXCHANGE_RATE_API_KEY }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
