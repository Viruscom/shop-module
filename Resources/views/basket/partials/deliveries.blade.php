<h3 class="hidden">@lang('shop::front.basket.delivery_method')</h3>

<div class="form-section form-section-alt hidden">
    @foreach($deliveryMethods as $deliveryMethod)
        <div class="form-row-radio">
            <div class="form-row-inner">
                <label class="radio-label">{{$deliveryMethod->type}}
                    <input type="radio" name="delivery_id" value="{{$deliveryMethod->id}}" checked>
                    <span class="checkmark"></span>
                </label>

                <strong>@lang('shop::front.basket.delivery_price_address')</strong>
            </div>
        </div>
    @endforeach
</div>

{{--Ako e izbrano do adres po-gore--}}<h3>@lang('shop::front.basket.address_title')</h3>
@if(!is_null($basketRegisteredUser))
    <div class="form-section">

        <div class="section-content">
            <div class="form-col form-col-1of3 hidden">
                <label class="form-label" for="country_id">
                    Държава
                    <span class="asterisk">*</span>
                </label>
                <div class="input-container cart">
                    <select name="country_id" id="country_id" class="select-custom m-b-0" required>
                        @foreach($countriesSale as $saleCountry)
                            <option value="{{ $saleCountry->country->id }}">{{ $saleCountry->country->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @include('shop::basket.partials.delivery_address_partial')
        </div>

        <div class="section-content">
            <a href="{{ route('shop.registered_user.account.addresses.create', ['languageSlug' => $languageSlug]) }}" class="btn btn-outline">Добави нов адрес</a>
        </div>

        <div class="form-row form-row-margin">
            <div class="checkboxes-wrapper">
                <label class="checkbox-wrapper">
                    <input type="checkbox" id="pribori" name="with_utensils">

                    <span class="checkmark"></span>

                    <span class="check-text">Искам прибори</span>
                </label>
            </div>
        </div>

        <div class="form-row form-row-textarea">
            <label class="form-label" for="comment">Коментари за доставката</label>

            <div class="input-container">
                <textarea id="comment" class="textarea" placeholder="" aria-invalid="false" name="comment"></textarea>
            </div>
        </div>
    </div>
@else
    <div class="form-section">
        @include('shop::basket.partials.delivery_address_partial')
    </div>
@endif
