<h3>Данни за фактура</h3>

<div class="form-section">
    <div class="form-row">
        <div class="checkboxes-wrapper">
            <label class="checkbox-wrapper">
                <input type="checkbox" id="enableDoc" class="toggle-checkbox">

                <span class="checkmark"></span>

                <span class="check-text">Искам фактура</span>
            </label>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <label class="form-label" for="firstNameDoc">
            First name
            <span class="asterisk">*</span>
        </label>

        <div class="input-container">
            <input id="firstNameDoc" type="text" placeholder="" required>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="UIK">
                    UIK
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="UIK" type="text" placeholder="" required>
                </div>
            </div>

            <div class="form-col form-col-1of2">
                <label class="form-label" for="vatNumber">
                    VAT number
                </label>

                <div class="input-container">
                    <input id="vatNumber" type="text" placeholder="">
                </div>
            </div>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <div class="checkboxes-wrapper">
            <label class="checkbox-wrapper">
                <input type="checkbox" id="vatRegistration">

                <span class="checkmark"></span>

                <span class="check-text">VAT registration</span>
            </label>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <div class="form-cols">
            <div class="form-col form-col-1of2">
                <label class="form-label" for="mol">
                    МОЛ - First and last name
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="mol" type="text" placeholder="" required>
                </div>
            </div>

            <div class="form-col form-col-1of2">
                <label class="form-label" for="telDoc">
                    Tel.
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="telDoc" type="tel" placeholder="">
                </div>
            </div>
        </div>
    </div>

    <div class="form-row toggle-panel">
        <div class="form-cols">
            <div class="form-col form-col-1of3">
                <label class="form-label" for="locationDoc">
                    Location
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="locationDoc" type="text" placeholder="" required>
                </div>
            </div>

            <div class="form-col form-col-2of3">
                <label class="form-label" for="street">
                    Street / District
                    <span class="asterisk">*</span>
                </label>

                <div class="input-container">
                    <input id="street" type="tel" placeholder="">
                </div>
            </div>
        </div>
    </div>
</div>
