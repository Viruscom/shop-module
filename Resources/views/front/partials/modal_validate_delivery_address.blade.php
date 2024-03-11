@php
    $basketRegisteredUser = null;
    if (\Illuminate\Support\Facades\Auth::guard('shop')->check()) {
        $basketRegisteredUser = Auth::guard('shop')->user();
    }
@endphp
<div class="modal-address" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <h3>Вашият адрес за доставка</h3>

            <button type="button" class="close"><span aria-hidden="true">×</span></button>

            <form action="{{ route('google.geocoding-api.get-address-coordinates') }}" class="form-add-address" method="post">
                @csrf
                <div class="form-row hidden response-success">
                    <div class="alert alert-success"></div>
                </div>
                <div class="form-row hidden response-error">
                    <div class="alert alert-danger"></div>
                </div>
                <div class="form-row form-row-inline">
                    <div class="form-row-el">
                        <label class="form-label" for="city">Град</label>

                        <select name="city" id="city" class="select-custom" required>
                            <option value="{{ $city->id }}">София</option>
                        </select>
                    </div>

                    <div class="form-row-el">
                        <label class="form-label" for="postCode">Пощенски код</label>

                        <div class="input-container">
                            <input id="postCode" type="number" placeholder="" name="zip_code" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-cols-alt">
                        <div class="form-col-big">
                            <label class="form-label" for="address">Въведете квартал, улица</label>

                            <div class="input-container">
                                <input id="address" type="text" placeholder="" name="address" required>
                            </div>
                        </div>

                        <div class="form-col-small">
                            <label class="form-label" for="streetNumber">№/блок</label>

                            <div class="input-container">
                                <input id="streetNumber" type="number" placeholder="" name="street_number" required>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!is_null($basketRegisteredUser))
                    @if($basketRegisteredUser->shipmentAddresses->isNotEmpty())
                        <div class="form-row" style="margin-top: 10px;">
                            <div class="form-cols-alt">
                                <div class="form-col-big">
                                    <label class="form-label" for="3534535">или изберете друг Ваш адрес</label></div>
                            </div>
                        </div>
                        <div class="form-row" style="margin-top: 0px;">
                            <div class="form-cols-alt">
                                <div class="form-col-big">
                                    <select name="shipment_address_id" id="" class="select-custom ru-bst-ch-sh-addr">
                                        <option value="">@lang('admin.common.please_select')</option>
                                        @foreach($basketRegisteredUser->shipmentAddresses as $address)
                                            <option value="{{ $address->id }}" city="{{$address->city->name}}" street="{{$address->street}}" street_number="{{ $address->street_number }}" zip_code="{{$address->zip_code}}" {{ session()->get('validated_shipment_address_id') !== null && $address->id == session()->get('validated_shipment_address_id') ? 'selected':'' }}>
                                                {{ $address->country->name .', ' . $address->city->name . ', ' . $address->street .' № ' . $address->street_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">Няма добавени адреси</div>
                    @endif
                @endif
                <button type="submit">Потвърди</button>
            </form>
        </div>
    </div>
</div>

<style>
    .form-row-inline {
        display:     flex;
        align-items: center;
        column-gap:  40px;
    }

    .modal-address button[type="submit"] {
        margin-top:     47px;
        width:          250px;
        height:         50px;
        border:         1px solid #b20000;
        color:          #B20000;
        text-transform: uppercase;
        font-weight:    700;
        background:     #fff;
        font-size:      22px;
        transition:     all 0.2s ease-in-out;
    }

    .modal-address button[type="submit"]:hover {
        background: #b20000;
        color:      #fff;
    }

    .modal-address .chosen-container {
        width: 100% !important;
    }

    .form-row-el {
        display:     flex;
        align-items: center;
        column-gap:  8px;
    }

    .form-row ~ .form-row {
        margin-top: 20px;
    }

    .modal-address .chosen-container-single .chosen-single span {
        line-height:  1.42;
        margin-right: 0 !important;
    }

    .modal-address .chosen-container-single.chosen-with-drop .chosen-single {
        border-bottom-color: transparent;
    }

    .modal-address .chosen-container-single .chosen-single {
        border-radius: 0;
        border-width:  1px;
        border-color:  #CCCCCC;
        background:    #fff;
        box-shadow:    none;
        font-size:     28px;
        color:         #111111;
        height:        auto;
        padding:       12px;
        min-width:     220px;
    }

    .modal-address .chosen-container-single .chosen-single span {
        white-space: normal;
    }

    .modal-address .chosen-container-active.chosen-with-drop .chosen-single {
        background: transparent;
    }

    .modal-address .chosen-container.chosen-with-drop .chosen-drop {
        background:    #fff;
        border:        1px solid #ccc;
        border-top:    0;
        box-shadow:    none;
        border-radius: 0;
        padding-top:   5px;
    }

    .modal-address .chosen-container-single.chosen-container-single-nosearch .chosen-search {
        display: none !important;
    }

    .modal-address .chosen-container .chosen-results {
        padding:    0;
        margin:     0;
        font-size:  28px;
        color:      #111111;
        max-height: 400px;
        background: transparent;
    }

    .modal-address .chosen-container .chosen-results li.active-result.result-selected,{
        font-size: 16px;
    }

    .modal-address .chosen-container .chosen-results li,
    .modal-address .chosen-container .chosen-results li:hover{
        line-height: 1;
        padding:     11px 16px;
        font-weight: 400;
        font-size: 16px !important;
    }

    .modal-address .chosen-container-single .chosen-single div b {
        background:       none;
        position:         relative;
        background-image: none !important;
    }

    .modal-address .chosen-container-single .chosen-single div b:before {
        content:      '';
        border-style: solid;
        border-width: 2px 2px 0 0;
        display:      inline-block;
        border-color: #B20000;
        height:       10px;
        top:          6px;
        right:        -10px;
        position:     relative;
        transform:    rotate(135deg);
        width:        10px;
        transition:   transform 0.2s ease-in-out;
    }

    .modal-address .chosen-with-drop.chosen-container-single .chosen-single div b:before {
        transform: rotate(-45deg);
        top:       13px;
    }

    .modal-address .chosen-container-single .chosen-single div {
        width: 30px;
    }

    .modal-address .chosen-container .chosen-results li.highlighted,
    .modal-address .chosen-container .chosen-results li.result-selected {
        background:  #B20000;
        color:       #fff;
        font-size:   28px;
        font-weight: 400;
    }

    .modal-address .form-row:not(.form-row-inline) .form-label {
        margin-bottom: 8px;
    }

    .modal-address .form-row:not(.form-row-inline) .input-container input {
        font-size: 22px;
    }

    .modal-address .form-label {
        white-space:    nowrap;
        display:        block;
        font-size:      18px;
        font-weight:    300;
        color:          #777777;
        text-transform: none;
        line-height:    1;
        position:       static;
    }

    .modal-address .input-container input {
        border:    1px solid #CBC5BB;
        padding:   7px 16px;
        font-size: 28px;
        color:     #111;
        width:     100%;
    }

    .modal-address h3 {
        margin-bottom: 26px;
        color:         #B20000;
        font-size:     40px;
        font-family:   'Neucha', cursive;
        line-height:   1;
        display:       inline-block;
    }

    .modal-address .close {
        font-size:   45px;
        position:    absolute;
        right:       10px;
        top:         10px;
        line-height: 0.5;
    }

    .modal-address .modal-content {
        padding: 25px;
    }

    .modal-address {
        overflow:                   hidden;
        position:                   fixed;
        top:                        0;
        right:                      0;
        bottom:                     0;
        left:                       0;
        -webkit-overflow-scrolling: touch;
        outline:                    0;
        background:                 rgba(0, 0, 0, 0.6);
        z-index:                    600;
        visibility:                 hidden;
        opacity:                    0;
        transition:                 opacity 0.2s ease;
    }

    .modal-address.fade-in {
        opacity:    1;
        visibility: visible;
    }

    .modal-address .modal-dialog {
        position:          absolute;
        left:              0%;
        top:               0%;
        -webkit-transform: translate(0, 0);
        -ms-transform:     translate(0, 0);
        -o-transform:      translate(0, 0);
        transform:         translate(0, 0);
    }

    .modal-address.fade-in .modal-dialog {
        left:              50%;
        top:               50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform:     translate(-50%, -50%);
        -o-transform:      translate(-50%, -50%);
        transform:         translate(-50%, -50%)
    }

    @media (min-width: 992px) {
        .modal-address .modal-lg {
            width: 700px;
        }
    }

    @media only screen and (max-width: 850px) and (orientation: landscape), only screen and (max-width: 767px) {
        .modal-address h3 {
            font-size: 24px;
        }

        .form-row-el {
            flex-direction: column;
            align-items:    unset;
        }

        .modal-address .form-label {
            font-size:     14px;
            margin-bottom: 8px;
        }

        .modal-address .chosen-container-single .chosen-single {
            font-size: 18px;
        }

        .modal-address .chosen-container-single .chosen-single div b:before {
            top: 12px;
        }

        .modal-address .input-container input,
        .modal-address .form-row:not(.form-row-inline) .input-container input {
            padding-top:    8px;
            padding-bottom: 8px;
            font-size:      16px;
        }

        .modal-address button[type="submit"] {
            width:      100%;
            font-size:  16px;
            height:     40px;
            margin-top: 27px;
        }

        .form-row-inline {
            flex-direction: column;
            align-items:    unset;
            row-gap:        20px;
        }

        .form-row ~ .form-row {
            margin-top: 0;
        }

        .modal-address .chosen-container .chosen-results,
        .modal-address .chosen-container .chosen-results li.highlighted, .modal-address .chosen-container .chosen-results li.result-selected {
            font-size: 16px;
        }

        .modal-address .chosen-container-single .chosen-single {
            padding-top: 7px;
        }

    }

</style>

<script>
    ;(function ($, window, document, undefined) {
        const $doc            = $(document);
        const triggerModalBtn = $('.btn-address');
        const modalTarget     = $('.modal-address');
        const modalCloseBtn   = $('.modal-address .close');
        const form            = $('.form-add-address');

        $doc.ready(function () {
            modalActions();
        });

        function modalActions() {
            triggerModalBtn.on('click', function (e) {
                e.preventDefault();
                modalTarget.addClass('fade-in');
            });

            modalCloseBtn.on('click', function () {
                modalTarget.removeClass('fade-in');
            });

            form.on('submit', function (e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            $('.response-success div.alert').text(response.success);
                            $('.response-success').removeClass('hidden');
                            setTimeout(function () {
                                modalCloseBtn.click();
                                $('.response-success').addClass('hidden');
                                window.location.reload();
                            }, 2000);
                        }

                        if (response.error) {
                            $('.response-error div.alert').text(response.error);
                            $('.response-error').removeClass('hidden');
                            setTimeout(function () {
                                modalCloseBtn.click();
                                $('.response-error').addClass('hidden');
                                window.location.reload();
                            }, 2000);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // Обработка на грешки
                        console.error(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
    })(jQuery, window, document);
</script>

