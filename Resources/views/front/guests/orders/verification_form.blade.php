@extends('layouts.front.app')

@section('content')
    <div class="page-wrapper" style="display: flex;align-items: center;justify-content: center;">
        <div class="access-forms" style="width: 300px;margin: 90px 0px;">
            @include('admin.notify')
            <form method="post" class="form-alt selected" id="form-login" action="{{ route('guest.show-order-verified-access', ['orderUid' => $languageSlug]) }}">
                @csrf
                <div class="form-head">
                    <h3>{{ __('shop::front.login.login') }}</h3>
                </div>

                <div class="form-body">

                    <div class="form-row">
                        <label class="form-label" for="email">
                            {{ __('shop::front.login.email') }}
                            <span class="asterisk">*</span>
                        </label>

                        <div class="input-container ">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="form-footer">
                    <button type="submit" class="submit-button">{{ __('shop::front.login.login_submit') }}</button>

                </div>
            </form>
        </div>
    </div>
@endsection
