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
                                <label for="receiver_name" class="col-md-4 col-form-label text-md-right">{{ __('Receiver name') }}*</label>

                                <div class="col-md-6">
                                    <input id="receiver_name" type="text" class="form-control @error('receiver_name') is-invalid @enderror" name="receiver_name" value="{{ $payment->data->receiver_name }}" required autocomplete="receiver_name" autofocus>

                                    @error('receiver_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="receiver_bank_name" class="col-md-4 col-form-label text-md-right">{{ __('Receiver bank name') }}*</label>

                                <div class="col-md-6">
                                    <input id="receiver_bank_name" type="text" class="form-control @error('receiver_bank_name') is-invalid @enderror" name="receiver_bank_name" value="{{ $payment->data->receiver_bank_name }}" required autocomplete="receiver_bank_name" autofocus>

                                    @error('receiver_bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="receiver_iban" class="col-md-4 col-form-label text-md-right">{{ __('Receiver IBAN') }}*</label>

                                <div class="col-md-6">
                                    <input id="receiver_iban" type="text" class="form-control @error('receiver_iban') is-invalid @enderror" name="receiver_iban" value="{{ $payment->data->receiver_iban }}" required autocomplete="receiver_iban" autofocus>

                                    @error('receiver_iban')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="receiver_bic" class="col-md-4 col-form-label text-md-right">{{ __('Receiver BIC') }}*</label>

                                <div class="col-md-6">
                                    <input id="receiver_bic" type="text" class="form-control @error('receiver_bic') is-invalid @enderror" name="receiver_bic" value="{{ $payment->data->receiver_bic }}" required autocomplete="receiver_bic" autofocus>

                                    @error('receiver_bic')
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
