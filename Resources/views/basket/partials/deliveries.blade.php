<h3>@lang('shop::front.basket.delivery_method')</h3>

<div class="form-section form-section-alt">
    @foreach($deliveryMethods as $deliveryMethod)
        <div class="form-row-radio">
            <div class="form-row-inner">
                <label class="radio-label">{{$deliveryMethod->type}}
                    <input type="radio"  name="delivery_id" value="{{$deliveryMethod->id}}">
                    <span class="checkmark"></span>
                </label>

                <strong>@lang('shop::front.basket.delivery_price_address')</strong>
            </div>
        </div>
    @endforeach
</div>


{{--Ako e izbrano do adres po-gore--}}
<h3>@lang('shop::front.basket.address_title')</h3>

<div class="form-section">
    <div class="form-row">
        <label class="form-label" for="location">
            @lang('shop::front.basket.country_label')
            <span class="asterisk">*</span>
        </label>

        <div class="input-container">
            <select id="country_id" class="form-control @error('country_id') is-invalid @enderror" name="country_id" required>
                <option value="">{{__('admin.common.please_select')}}</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}" {{old('country_id')==$country->id ? "selected":""}}>{{$country->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="location">
                    @lang('shop::front.basket.location_label')
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <select id="city_id" class="form-control @error('city_id') is-invalid @enderror" name="city_id" required>
                        <option value="">{{__('admin.common.please_select')}}</option>
                        @foreach($cities as $city)
                            <option value="{{$city->id}}" {{old('city_id')==$city->id ? "selected":""}}>{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-col form-col-1of2">
                <label class="form-label" for="postCode">
                    @lang('shop::front.basket.postcode_label')
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="postCode" type="text" name="zip_code" value="{{ is_null(old('zip_code')) ? session()->get('zip_code'):old('zip_code') }}" placeholder="" required>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <label class="form-label" for="streetDisctrict">
            @lang('shop::front.basket.street_label')
            <span class="asterisk">*</span>
        </label>

        <div class="input-container">
            <input id="streetDisctrict" type="text" name="street" value="{{ old('street') }}" placeholder="" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="street_number">
                    @lang('shop::front.basket.street_number_label')
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="street_number" type="text" name="street_number" value="{{ old('street_number') }}" placeholder="" required>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="checkboxes-wrapper">
            <label class="checkbox-wrapper">
                <input type="checkbox" class="toggle-checkbox" name="recipient_different" id="differentDetails">

                <span class="checkmark"></span>

                <span class="check-text">@lang('shop::front.basket.recipient_different')</span>
            </label>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="firstName2">
                    @lang('shop::front.basket.recipient_first_name')
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="firstName2" type="text" name="recipient_first_name" value="{{ old('recipient_first_name') }}" placeholder="">
                </div>
            </div>

            <div class="form-col form-col-1of2">
                <label class="form-label" for="lastName2">
                    @lang('shop::front.basket.recipient_last_name')
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="lastName2" type="text" name="recipient_last_name" value="{{ old('recipient_last_name') }}" placeholder="">
                </div>
            </div>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="tel2">
                    @lang('shop::front.basket.recipient_tel')
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="tel2" type="tel" name="recipient_tel" value="{{ old('recipient_tel') }}" placeholder="">
                </div>
            </div>
        </div>
    </div>
</div>
