@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    @include('shop::front.partials.registered_user_head')

    <div class="page-wrapper">
        @include('front.notify')
        <section class="settings-page">
            <div class="shell">
                @include('shop::front.registered_users.profile.partials.menu')

                <div class="page-content-shop">
                    <h3 class="page-title">Редактиране на адрес</h3>

                    <div class="form-wrapper form-wrapper-alt">
                        <form action="{{ route('shop.registered_user.account.addresses.update', ['languageSlug' => $languageSlug, 'id' => $address->id]) }}" method="POST" id="add-edit-address">
                            @csrf
                            <div class="form-section">
                                <div class="form-section-address">
                                    <div class="form-section-address-row">
                                        <p>Град <span>София</span></p>

                                        <p>Пощенски код <span class="span-zip-code">{{ $address->zip_code }}</span></p>
                                        <input type="number" class="hidden" name="zip_code" value="{{ $address->zip_code }}">
                                    </div>

                                    <div class="form-section-address-row form-section-address-row-alt">
                                        <p>
                                            Адрес - въведете квартал, улица, номер, блок*
                                            <br>
                                            <span class="span-address">{{ $address->street .', '. $city->name .', № '. $address->street_number }}</span>
                                            <input type="text" class="hidden" name="street" value="{{ $address->street }}">
                                            <input type="text" class="hidden" name="street_number" value="{{ $address->street_number }}">
                                            <input type="text" class="hidden" name="city_id" value="{{ $city->id }}">
                                            <input type="text" class="hidden" name="country_id" value="{{ $country->id }}">
                                        </p>

                                        <a href="#" class="btn btn-outline btn-address-shipment">Промени</a>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-cols-alt">
                                        <div class="form-col-small">
                                            <label class="form-label" for="vhod">
                                                Вход
                                            </label>

                                            <div class="input-container">
                                                <input id="vhod" type="text" placeholder="" name="entrance" value="{{$address->entrance}}">
                                            </div>
                                        </div>

                                        <div class="form-col-small">
                                            <label class="form-label" for="etaj">
                                                Етаж
                                            </label>

                                            <div class="input-container">
                                                <input id="etaj" type="text" placeholder="" name="floor" value="{{$address->floor}}">
                                            </div>
                                        </div>

                                        <div class="form-col-small">
                                            <label class="form-label" for="apartament">
                                                Ап.
                                            </label>

                                            <div class="input-container">
                                                <input id="apartament" type="text" placeholder="" name="apartment" value="{{$address->apartment}}">
                                            </div>
                                        </div>

                                        <div class="form-col-big">
                                            <label class="form-label" for="nomerZvanec">
                                                Надпис на звънец
                                            </label>

                                            <div class="input-container">
                                                <input id="nomerZvanec" type="text" placeholder="" name="bell_name" value="{{$address->bell_name}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col">
                                        <label class="form-label" for="address_name">
                                            Име на адреса <strong>*</strong>
                                        </label>

                                        <div class="input-container">
                                            <input id="address_name" type="text" placeholder="" name="name" value="{{$address->name}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-bottom">
                                <div class="checkboxes-wrapper">
                                    <label class="checkbox-wrapper">
                                        <input type="checkbox" id="defaultAddress" {{ $address->is_default ? 'checked':'' }}>

                                        <span class="checkmark"></span>

                                        <span class="check-text">Адрес по подразбиране</span>
                                    </label>
                                </div>

                                <button type="submit" class="submit-button" value="">Редактирай</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('shop::front.registered_users.profile.addresses.shipment.modal_address_validate')
@endsection
