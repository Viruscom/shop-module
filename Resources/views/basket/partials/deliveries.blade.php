<h3>Начин на доставка</h3>

<div class="form-section form-section-alt">
    <div class="form-row-radio">
        <div class="form-row-inner">
            <label class="radio-label">
                До офис на доставчик
                <input type="radio" checked="checked" name="delivery">
                <span class="checkmark"></span>
            </label>

            <strong>3.00 лв.</strong>
        </div>

        <input id="delivery" type="text">
    </div>

    <div class="form-row-radio">
        <div class="form-row-inner">
            <label class="radio-label">До адрес
                <input type="radio"  name="delivery">
                <span class="checkmark"></span>
            </label>

            <strong>6.00 лв.</strong>
        </div>
    </div>
</div>


{{--Ako e izbrano do adres po-gore--}}
<h3>Въведете адрес за доставка</h3>

<div class="form-section">
    <div class="form-row">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="location">
                    Location
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="location" type="text" placeholder="" required>
                </div>
            </div>

            <div class="form-col form-col-1of2">
                <label class="form-label" for="postCode">
                    Post code
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="postCode" type="text" placeholder="">
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <label class="form-label" for="streetDisctrict">
            Street / District
            <span class="asterisk">*</span>
        </label>

        <div class="input-container">
            <input id="streetDisctrict" type="text" placeholder="">
        </div>
    </div>

    <div class="form-row">
        <div class="checkboxes-wrapper">
            <label class="checkbox-wrapper">
                <input type="checkbox" class="toggle-checkbox" id="differentDetails">

                <span class="checkmark"></span>

                <span class="check-text">Данните за контакт на получателя са различни от моите</span>
            </label>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="firstName2">
                    First name
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="firstName2" type="text" placeholder="" required>
                </div>
            </div>

            <div class="form-col form-col-1of2">
                <label class="form-label" for="lastName2">
                    Last name
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="lastName2" type="text" placeholder="">
                </div>
            </div>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="tel2">
                    Tel.
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="tel2" type="tel" placeholder="">
                </div>
            </div>
        </div>
    </div>
</div>
