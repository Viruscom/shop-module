@extends('layouts.admin.app')

@section('content')
    @include('admin.settings.post.breadcrumbs')
    @include('admin.notify')
    <form action="{{ route('settings.post.update') }}" method="POST">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <a href="{{ route('mail_settings') }}" class="btn btn-lg btn-blue margin-bottom-10"><i class="fas fa-paper-plane"></i></a>
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ route('settings.post.index') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
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
                                    <span>Email (Форма за обратна връзка)</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Email:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="mailing_email_from" value="{{ old('mailing_email_from') ?: $postSetting->mailing_email_from }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(array_key_exists('Shop', $activeModules))
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span>Email (За получаване на поръчки)</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Email:</label>
                                        <div class="col-md-6">
                                            <input type="text" name="shop_orders_email" value="{{ old('shop_orders_email') ?: $postSetting->shop_orders_email }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="submit" value="submit" class="btn save-btn margin-bottom-10"><i class="fas fa-save"></i> запиши</button>
                                <a href="{{ route('settings.post.index') }}" role="button" class="btn back-btn margin-bottom-10"><i class="fa fa-reply"></i> {{ __('admin.common.back') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
