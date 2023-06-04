<h3>Данни за фактура</h3>

<div class="form-section">
    <div class="form-row">
        <div class="checkboxes-wrapper">
            <label class="checkbox-wrapper">
                <input type="checkbox" id="enableDoc" class="toggle-checkbox" name="has_invoice">

                <span class="checkmark"></span>

                <span class="check-text">Искам фактура</span>
            </label>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <label class="form-label" for="companyName">
            @lang('shop::front.basket.company_name')
            <span class="asterisk">*</span>
        </label>

        <div class="input-container">
            <input id="companyName" type="text" placeholder="" name="company_name" value="{{ old('company_name') }}">
        </div>
    </div>

    <div class="form-row toggle-panel">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="UIK">
                    @lang('shop::front.basket.company_eik')
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="UIK" type="text" placeholder="" name="company_eik" value="{{ old('company_eik') }}">
                </div>
            </div>

            <div class="form-col form-col-1of2">
                <label class="form-label" for="vatNumber">
                    @lang('shop::front.basket.company_vat_number')
                </label>

                <div class="input-container">
                    <input id="vatNumber" type="text" placeholder="" name="company_vat_eik" value="{{ old('company_vat_eik') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="mol">
                    @lang('shop::front.basket.company_mol')
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="mol" type="text" placeholder="" name="company_mol" value="{{ old('company_mol') }}">
                </div>
            </div>

            <div class="form-col form-col-1of2">
                <label class="form-label" for="telDoc">
                    @lang('shop::front.basket.company_phone')
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="telDoc" type="tel" placeholder="" name="company_phone" value="{{ old('company_phone') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <label class="form-label" for="street">
            @lang('shop::front.basket.company_address')
            <span class="asterisk">*</span>
        </label>

        <div class="input-container">
            <input id="street" type="tel" placeholder="" name="company_address" value="{{ old('company_address') }}">
        </div>
    </div>
</div>
