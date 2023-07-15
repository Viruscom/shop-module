@extends('layouts.front.app')

@section('content')
    <div class="page-wrapper">
        @include('shop::front.registered_users.profile.breadcrumbs')

        <section class="settings-page">
            <div class="shell">
                @include('shop::front.registered_users.profile.partials.menu')

                <div class="page-content">
                    <h3 class="page-title">{{ __('shop::front.registered_user_profile.personal_data') }}</h3>

                    <div class="form-wrapper form-wrapper-alt">
                        <form method="post" enctype="multipart/form-data" id="personal-data" action="{{ route('shop.registered_user.account.personal-data.update', ['languageSlug' => $languageSlug, 'id' => $registeredUser->id]) }}">
                            @csrf
                            <div class="form-body">
                                <div class="form-row">
                                    <div class="form-cols">
                                        <div class="form-col form-col-1of2">
                                            <label class="form-label" for="firstName2">
                                                {{ __('shop::front.login.first_name') }}
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <input id="firstName2" type="text" name="first_name" value="{{ old('first_name') ?: $registeredUser->first_name }}" placeholder="" required>
                                            </div>
                                        </div>

                                        <div class="form-col form-col-1of2">
                                            <label class="form-label" for="lastName2">
                                                {{ __('shop::front.login.last_name') }}
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <input id="lastName2" type="text" name="last_name" value="{{ old('last_name') ?: $registeredUser->last_name }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label class="form-label" for="email">
                                        {{ __('shop::front.login.email') }}
                                        <span class="asterisk">*</span>
                                    </label>

                                    <div class="input-container">
                                        <input id="email" type="email" name="email" value="{{ old('email') ?: $registeredUser->email }}" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-cols">
                                        <div class="form-col form-col-1of2">
                                            <label class="form-label" for="currentPass">
                                                {{ __('shop::front.login.current_password') }}
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <input id="currentPass" type="password" name="current_password">

                                                <div class="tooltip-box">
                                                    <span>{{ __('shop::front.login.hide_password') }}</span>
                                                    <span>{{ __('shop::front.login.show_password') }}</span>

                                                    <img class="toggle-password" src="{{ asset('front/assets/icons/eye-slash.svg') }}" alt="">
                                                    <img class="toggle-password" src="{{ asset('front/assets/icons/eye.svg') }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-cols">
                                        <div class="form-col form-col-1of2">
                                            <label class="form-label" for="newPass">
                                                {{ __('shop::front.login.new_password') }}
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <input id="newPass" type="password" name="new_password">

                                                <div class="tooltip-box">
                                                    <span>{{ __('shop::front.login.hide_password') }}</span>
                                                    <span>{{ __('shop::front.login.show_password') }}</span>

                                                    <img class="toggle-password" src="{{ asset('front/assets/icons/eye-slash.svg') }}" alt="">
                                                    <img class="toggle-password" src="{{ asset('front/assets/icons/eye.svg') }}" alt="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-col form-col-1of2">
                                            <label class="form-label" for="confirmPass">
                                                {{ __('shop::front.login.confirm_new_password') }}
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <input id="confirmPass" type="password" name="confirm_new_password">

                                                <div class="tooltip-box">
                                                    <span>{{ __('shop::front.login.hide_password') }}</span>
                                                    <span>{{ __('shop::front.login.show_password') }}</span>

                                                    <img class="toggle-password" src="{{ asset('front/assets/icons/eye-slash.svg') }}" alt="">
                                                    <img class="toggle-password" src="{{ asset('front/assets/icons/eye.svg') }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-bottom">
                                <button type="submit" class="submit-button" value="{{ __('shop::front.registered_user_profile.save') }}">{{ __('shop::front.registered_user_profile.save_button') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
