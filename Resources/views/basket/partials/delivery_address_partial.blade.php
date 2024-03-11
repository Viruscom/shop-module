<div class="form-section-address">
    <div class="form-section-address-row">
        <p>Град <span>София</span></p>

        <p>Пощенски код <span>{{ !is_null(session()->get('validated_zip_code')) ? session()->get('validated_zip_code') : 'xxxx' }}</span></p>
        <input type="number" class="hidden" name="zip_code" value="{{ !is_null(session()->get('validated_zip_code')) ? session()->get('validated_zip_code') : '' }}">
    </div>

    <div class="form-section-address-row form-section-address-row-alt">
        <p>
            Адрес - въведете квартал, улица, номер, блок*
            <br>
            <span>{{ !is_null(session()->get('validated_delivery_address')) ? $city->name .', '. session()->get('validated_delivery_address') . ' № '. session()->get('validated_street_number') : 'Изберете промени, за да въведете адрес' }}</span>
            <input type="text" class="hidden" name="street" value="{{ !is_null(session()->get('validated_delivery_address')) ? session()->get('validated_delivery_address') : '' }}">
            <input type="text" class="hidden" name="street_number" value="{{ !is_null(session()->get('validated_street_number')) ? session()->get('validated_street_number') : '' }}">
            <input type="text" class="hidden" name="city_id" value="{{ $city->id }}">
            <input type="text" class="hidden" name="country_id" value="{{ $country->id }}">
        </p>

        <a href="" class="btn btn-outline btn-address">
            @if(Auth::guard('shop')->guest() && is_null(session()->get('validated_delivery_address')))
                Въведи
            @else
                Промени/Избери друг
            @endif</a>
    </div>
</div>

<div class="form-row">
    <div class="form-cols-alt">
        <div class="form-col-small">
            <label class="form-label" for="vhod">
                Вход
            </label>

            <div class="input-container">
                <input id="vhod" type="text" placeholder="" name="entrance" value="{{ !is_null(session()->get('validated_shipment_address_object')) ? session()->get('validated_shipment_address_object')->entrance : ''  }}">
            </div>
        </div>

        <div class="form-col-small">
            <label class="form-label" for="etaj">
                Етаж
            </label>

            <div class="input-container">
                <input id="etaj" type="text" placeholder="" name="floor" value="{{ !is_null(session()->get('validated_shipment_address_object')) ? session()->get('validated_shipment_address_object')->floor : ''  }}">
            </div>
        </div>

        <div class="form-col-small">
            <label class="form-label" for="apartament">
                Ап.
            </label>

            <div class="input-container">
                <input id="apartament" type="text" placeholder="" name="apartment" value="{{ !is_null(session()->get('validated_shipment_address_object')) ? session()->get('validated_shipment_address_object')->apartment : ''  }}">
            </div>
        </div>

        <div class="form-col-big">
            <label class="form-label" for="nomerZvanec">
                Надпис на звънец
            </label>

            <div class="input-container">
                <input id="nomerZvanec" type="text" placeholder="" name="bell_name" value="{{ !is_null(session()->get('validated_shipment_address_object')) ? session()->get('validated_shipment_address_object')->bell_name : ''  }}">
            </div>
        </div>
    </div>
</div>

<div class="section-bottom" style="width: 100%; {{ isset($hideElement) ? 'display:none;': '' }}">
    <div class="snackbar-wrapper" style="width: 100%;">
        <div class="snackbar snackbar-warning">Вашият адрес ще се добави автоматично при поръчка</div>
    </div>
</div>

@if(is_null($basketRegisteredUser))
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
@endif


