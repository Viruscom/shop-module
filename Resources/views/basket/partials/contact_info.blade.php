@if(!is_null($basketRegisteredUser))
    <h3>Данни на клиента</h3>
    <div class="form-section">
        <div class="section-content">
            <h3>{{ $basketRegisteredUser->first_name }} {{ $basketRegisteredUser->last_name }} </h3>

            <div class="section-inner">
                <ul>
                    <li><span>E-mail:</span>{{ $basketRegisteredUser->email }}</li>

                    @if($basketRegisteredUser->phone != '')
                        <li><span>Tel.:</span>{{ $basketRegisteredUser->phone }}</li>
                    @endif
                    <div class="hidden">
                        <input type="text" name="first_name" value="{{ $basketRegisteredUser->first_name }}">
                        <input type="text" name="last_name" value="{{ $basketRegisteredUser->last_name }}">
                        <input type="text" name="email" value="{{ $basketRegisteredUser->email }}">
                        <input type="text" name="phone" value="{{ $basketRegisteredUser->phone }}">
                    </div>
                </ul>

                <a href="" class="btn btn-outline toggle-section">Промени</a>
            </div>
        </div>

        <div class="section-content section-content-hidden">
            <div class="form-row">
                <div class="form-cols">
                    <div class="form-col form-col-1of2">
                        <label class="form-label" for="firstName">
                            Име
                            <span class="asterisk">*</span>
                        </label>

                        <div class="input-container">
                            <input id="firstName" type="text" placeholder="" name="new_first_name">
                        </div>
                    </div>

                    <div class="form-col form-col-1of2">
                        <label class="form-label" for="lastName">
                            Фамилия
                            <span class="asterisk">*</span>
                        </label>

                        <div class="input-container">
                            <input id="lastName" type="text" placeholder="" name="new_last_name">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-cols">
                    <div class="form-col form-col-1of2">
                        <label class="form-label" for="email">
                            E-mail
                            <span class="asterisk">*</span>
                        </label>

                        <div class="input-container">
                            <input id="email" type="email" placeholder="" name="new_email">
                        </div>
                    </div>

                    <div class="form-col form-col-1of2">
                        <label class="form-label" for="tel">
                            Телефон
                            <span class="asterisk">*</span>
                        </label>

                        <div class="input-container">
                            <input id="tel" type="tel" placeholder="" name="new_phone">
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-actions">
                <button class="btn btn-black">Запази</button>

                <a href="" class="btn btn-outline section-close">Затвори</a>
            </div>
        </div>
    </div>
@else
    <div class="top-actions">
        <a href="{{ route('shop.login', ['languageSlug' => $languageSlug]) }}" class="btn btn-black">@lang('shop::front.login.login_submit')</a>

        <a href="{{ route('shop.register', ['languageSlug' => $languageSlug]) }}" class="btn btn-outline">@lang('shop::front.login.create_account')</a>
    </div>

    <h3>{{ __('shop::front.basket.contact_info') }}</h3>

    <div class="form-section">
        <div class="form-row">
            <div class="form-cols">
                <div class="form-col form-col-1of2">
                    <label class="form-label" for="first_name">
                        {{ __('shop::front.basket.first_name') }}
                        <span class="asterisk">*</span>
                    </label>

                    <div class="input-container">
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="" required>
                    </div>
                </div>

                <div class="form-col form-col-1of2">
                    <label class="form-label" for="last_name">
                        {{ __('shop::front.basket.last_name') }}
                        <span class="asterisk">*</span>
                    </label>

                    <div class="input-container">
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-cols">
                <div class="form-col form-col-1of2">
                    <label class="form-label" for="email">
                        {{ __('shop::front.basket.email') }}
                        <span class="asterisk">*</span>
                    </label>

                    <div class="input-container">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="" required>
                    </div>
                </div>

                <div class="form-col form-col-1of2">
                    <label class="form-label" for="tel">
                        {{ __('shop::front.basket.tel') }}
                        <span class="asterisk">*</span>
                    </label>

                    <div class="input-container">
                        <input id="tel" type="tel" name="phone" value="{{ old('phone') }}" placeholder="" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
