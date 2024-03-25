@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @include('shop::admin.settings.internal_integrations.facebook.conversation_api.breadcrumbs')
    @include('admin.notify')

    <form action="{{ route('admin.shop.settings.internal-integrations.mail-chimp.update') }}" method="POST">
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
                                    <span>{{ __('shop::admin.facebook_conversation_api.settings') }}</span>
                                </div>
                            </div>
                            <div class="portlet-body">

                                <div class="form-group">
                                    <label class="control-label col-md-3">ACCESS TOKEN:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="ACCESS_TOKEN" value="{{ old('ACCESS_TOKEN') ?? $facebookConversationApi->ACCESS_TOKEN }}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">PIXEL ID:</label>
                                    <div class="col-md-6">
                                        <div class="alert alert-warning">{!! __('shop::admin.facebook_conversation_api.pixel_id_info') !!}</div>
                                        <input type="text" name="PIXEL_ID" value="{{ old('PIXEL_ID') ?? $facebookConversationApi->PIXEL_ID }}" class="form-control" required disabled placeholder="{{ __('shop::admin.facebook_conversation_api.pixel_id_placeholder') }}">
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
