@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @include('shop::payments.breadcrumbs')
    @include('admin.notify')

    <form action="{{route('payments.update',['id'=>$payment->id])}}" method="POST">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ route('payments.index') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
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
                                    <span>{{ __('shop::admin.payment_systems.'.$payment->type) }}</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="form-group">
                                    <label for="environment" class="control-label col-md-3">{{ __('Environment') }}*</label>

                                    <div class="col-md-6">
                                        <input id="environment" type="text" class="form-control @error('environment') is-invalid @enderror" name="environment" value="{{ $payment->data->environment }}" required autocomplete="environment" autofocus>

                                        @error('environment')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="environment_url" class="control-label col-md-3">{{ __('Environment URL') }}*</label>

                                    <div class="col-md-6">
                                        <input id="environment_url" type="text" class="form-control @error('environment_url') is-invalid @enderror" name="environment_url" value="{{ $payment->data->environment_url }}" required autocomplete="environment_url" autofocus>

                                        @error('environment_url')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="shop_id" class="control-label col-md-3">{{ __('Shop ID') }}*</label>

                                    <div class="col-md-6">
                                        <input id="shop_id" type="text" class="form-control @error('shop_id') is-invalid @enderror" name="shop_id" value="{{ $payment->data->shop_id }}" required autocomplete="shop_id" autofocus>

                                        @error('shop_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="wallet" class="control-label col-md-3">{{ __('Wallet') }}*</label>

                                    <div class="col-md-6">
                                        <input id="wallet" type="text" class="form-control @error('wallet') is-invalid @enderror" name="wallet" value="{{ $payment->data->wallet }}" required autocomplete="shop_id" autofocus>

                                        @error('wallet')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="key_index" class="control-label col-md-3">{{ __('Key index') }}*</label>

                                    <div class="col-md-6">
                                        <input id="key_index" type="text" class="form-control @error('key_index') is-invalid @enderror" name="key_index" value="{{ $payment->data->key_index }}" required autocomplete="key_index" autofocus>

                                        @error('key_index')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="version" class="control-label col-md-3">{{ __('Version') }}*</label>

                                    <div class="col-md-6">
                                        <input id="version" type="text" class="form-control @error('version') is-invalid @enderror" name="version" value="{{ $payment->data->version }}" required autocomplete="version" autofocus>

                                        @error('version')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="complany_name" class="control-label col-md-3">{{ __('My complany name') }}*</label>

                                    <div class="col-md-6">
                                        <input id="complany_name" type="text" class="form-control @error('complany_name') is-invalid @enderror" name="complany_name" value="{{ $payment->data->complany_name }}" required autocomplete="complany_name" autofocus>

                                        @error('complany_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="complany_eik" class="control-label col-md-3">{{ __('My company EIK') }}*</label>

                                    <div class="col-md-6">
                                        <input id="complany_eik" type="text" class="form-control @error('complany_eik') is-invalid @enderror" name="complany_eik" value="{{ $payment->data->complany_eik }}" required autocomplete="complany_eik" autofocus>

                                        @error('complany_eik')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="public_key" class="control-label col-md-3">{{ __('Public key') }}*</label>

                                    <div class="col-md-6">
                                        <input id="public_key" type="text" class="form-control @error('public_key') is-invalid @enderror" name="public_key" value="{{ $payment->data->public_key }}" required autocomplete="public_key" autofocus>

                                        @error('public_key')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="private_key" class="control-label col-md-3">{{ __('Private key') }}*</label>

                                    <div class="col-md-6">
                                        <input id="private_key" type="text" class="form-control @error('private_key') is-invalid @enderror" name="private_key" value="{{ $payment->data->private_key }}" required autocomplete="private_key" autofocus>

                                        @error('private_key')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
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
