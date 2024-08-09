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
                                        <select class="form-control @error('environment') is-invalid @enderror" name="environment" required autofocus>
                                            <option value="TEST" {{ $payment->data->environment == 'TEST' ? 'selected="selected"': '' }}>Test</option>
                                            <option value="PRODUCTION" {{ $payment->data->environment == 'PRODUCTION' ? 'selected="selected"': '' }}>Production</option>
                                        </select>

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
                                        <select class="form-control @error('environment_url') is-invalid @enderror" name="environment_url_display" id="environment_url_display" required disabled>
                                            <option value="https://mypos.com/vmp/checkout-test/" {{ $payment->data->environment == 'TEST' ? 'selected="selected"': '' }}>Test</option>
                                            <option value="https://mypos.com/vmp/checkout/" {{ $payment->data->environment == 'PRODUCTION' ? 'selected="selected"': '' }}>Production</option>
                                        </select>
                                        <input type="hidden" name="environment_url" id="environment_url" value="{{ $payment->data->environment == 'TEST' ? 'https://mypos.com/vmp/checkout-test/' : 'https://mypos.com/vmp/checkout/' }}">
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
                                        <select class="form-control @error('key_index') is-invalid @enderror" name="key_index_display" id="key_index_display" required disabled>
                                            <option value="1" {{ $payment->data->environment == 'TEST' ? 'selected="selected"': '' }}>Test (Key index = 1)</option>
                                            <option value="2" {{ $payment->data->environment == 'PRODUCTION' ? 'selected="selected"': '' }}>Production (Key index = 2)</option>
                                        </select>
                                        <input type="hidden" name="key_index" id="key_index" value="{{ $payment->data->environment == 'TEST' ? '1' : '2' }}">
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
                                        <textarea id="public_key" rows="15" class="form-control @error('public_key') is-invalid @enderror" name="public_key" required autocomplete="public_key" autofocus>{{ $payment->data->public_key }}</textarea>

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
                                        <textarea id="private_key" rows="15" class="form-control @error('private_key') is-invalid @enderror" name="private_key" required autocomplete="private_key" autofocus>{{ $payment->data->private_key }}</textarea>

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
    </form>
    <script>
        $(document).ready(function () {
            // Функция за смяна на стойностите на полетата
            function updateFieldsBasedOnEnvironment(environment) {
                if (environment === 'PRODUCTION') {
                    $('#environment_url_display').val('https://mypos.com/vmp/checkout/');
                    $('#environment_url').val('https://mypos.com/vmp/checkout/');
                    $('#key_index_display').val('2');
                    $('#key_index').val('2');
                } else if (environment === 'TEST') {
                    $('#environment_url_display').val('https://mypos.com/vmp/checkout-test/');
                    $('#environment_url').val('https://mypos.com/vmp/checkout-test/');
                    $('#key_index_display').val('1');
                    $('#key_index').val('1');
                }
            }

            // Сменяме стойностите при зареждане на страницата
            updateFieldsBasedOnEnvironment($('select[name="environment"]').val());

            // Слушаме за промяна на environment полето
            $('select[name="environment"]').change(function () {
                updateFieldsBasedOnEnvironment($(this).val());
            });
        });
    </script>
@endsection
