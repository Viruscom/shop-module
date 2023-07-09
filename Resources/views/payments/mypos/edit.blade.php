@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Bank Payment
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{route('payments.update',['id'=>$payment->id])}}">
                            @csrf

                            <div class="form-group row">
                                <label for="environment" class="col-md-4 col-form-label text-md-right">{{ __('Environment') }}*</label>

                                <div class="col-md-6">
                                    <input id="environment" type="text" class="form-control @error('environment') is-invalid @enderror" name="environment" value="{{ $payment->data->environment }}" required autocomplete="environment" autofocus>

                                    @error('environment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="environment_url" class="col-md-4 col-form-label text-md-right">{{ __('Environment URL') }}*</label>

                                <div class="col-md-6">
                                    <input id="environment_url" type="text" class="form-control @error('environment_url') is-invalid @enderror" name="environment_url" value="{{ $payment->data->environment_url }}" required autocomplete="environment_url" autofocus>

                                    @error('environment_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="shop_id" class="col-md-4 col-form-label text-md-right">{{ __('Shop ID') }}*</label>

                                <div class="col-md-6">
                                    <input id="shop_id" type="text" class="form-control @error('shop_id') is-invalid @enderror" name="shop_id" value="{{ $payment->data->shop_id }}" required autocomplete="shop_id" autofocus>

                                    @error('shop_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="wallet" class="col-md-4 col-form-label text-md-right">{{ __('Wallet') }}*</label>

                                <div class="col-md-6">
                                    <input id="shop_id" type="text" class="form-control @error('shop_id') is-invalid @enderror" name="shop_id" value="{{ $payment->data->shop_id }}" required autocomplete="shop_id" autofocus>

                                    @error('shop_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="key_index" class="col-md-4 col-form-label text-md-right">{{ __('Key index') }}*</label>

                                <div class="col-md-6">
                                    <input id="key_index" type="text" class="form-control @error('key_index') is-invalid @enderror" name="key_index" value="{{ $payment->data->key_index }}" required autocomplete="key_index" autofocus>

                                    @error('key_index')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="version" class="col-md-4 col-form-label text-md-right">{{ __('Version') }}*</label>

                                <div class="col-md-6">
                                    <input id="version" type="text" class="form-control @error('version') is-invalid @enderror" name="version" value="{{ $payment->data->version }}" required autocomplete="version" autofocus>

                                    @error('version')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="complany_name" class="col-md-4 col-form-label text-md-right">{{ __('My complany name') }}*</label>

                                <div class="col-md-6">
                                    <input id="complany_name" type="text" class="form-control @error('complany_name') is-invalid @enderror" name="complany_name" value="{{ $payment->data->complany_name }}" required autocomplete="complany_name" autofocus>

                                    @error('complany_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="complany_eik" class="col-md-4 col-form-label text-md-right">{{ __('My company EIK') }}*</label>

                                <div class="col-md-6">
                                    <input id="complany_eik" type="text" class="form-control @error('complany_eik') is-invalid @enderror" name="complany_eik" value="{{ $payment->data->complany_eik }}" required autocomplete="complany_eik" autofocus>

                                    @error('complany_eik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="public_key" class="col-md-4 col-form-label text-md-right">{{ __('Public key') }}*</label>

                                <div class="col-md-6">
                                    <input id="public_key" type="text" class="form-control @error('public_key') is-invalid @enderror" name="public_key" value="{{ $payment->data->public_key }}" required autocomplete="public_key" autofocus>

                                    @error('public_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="private_key" class="col-md-4 col-form-label text-md-right">{{ __('Private key') }}*</label>

                                <div class="col-md-6">
                                    <input id="private_key" type="text" class="form-control @error('private_key') is-invalid @enderror" name="private_key" value="{{ $payment->data->private_key }}" required autocomplete="private_key" autofocus>

                                    @error('private_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
