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
