@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    @include('shop::front.partials.registered_user_head')

    <div class="page-wrapper">
        <section class="settings-page">
            <div class="shell">
                @include('shop::front.registered_users.profile.partials.menu')

                <div class="page-content-shop">
                    <h3 class="page-title">Нова фирма</h3>

                    <div class="form-wrapper form-wrapper-alt">
                        <form method="post" id="add-edit-address" action="{{ route('shop.registered_user.account.companies.store', ['languageSlug' => $languageSlug]) }}">
                            @csrf
                            <div class="form-section">
                                <div class="form-row">
                                    <label class="form-label" for="firstNameDoc">
                                        Име на фирмата
                                        <span class="asterisk">*</span>
                                    </label>

                                    <div class="input-container">
                                        <input id="firstNameDoc" type="text" placeholder="Maximum 30 symbols" name="company_name" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-cols">
                                        <div class="form-col form-col-1of2">
                                            <label class="form-label" for="UIK">
                                                ЕИК
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <input id="UIK" type="text" placeholder="" name="company_eik" required>
                                            </div>
                                        </div>

                                        <div class="form-col form-col-1of2">
                                            <label class="form-label" for="vatNumber">
                                                ДДС номер
                                            </label>

                                            <div class="input-container">
                                                <input id="vatNumber" type="text" placeholder="" name="company_vat_eik">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-cols">
                                        <div class="form-col form-col-1of2">
                                            <label class="form-label" for="mol">
                                                МОЛ - име и фамилия
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <input id="mol" type="text" placeholder="" name="company_mol" required>
                                            </div>
                                        </div>

                                        <div class="form-col form-col-1of2">
                                            <label class="form-label" for="telDoc">
                                                Тел.
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <input id="telDoc" type="tel" placeholder="" name="phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-cols">
                                        <div class="form-col form-col-1of3">
                                            <label class="form-label" for="country_id">
                                                Държава
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <select name="country_id" id="country_id" class="select-custom m-b-0" required>
                                                    @foreach($countriesSale as $saleCountry)
                                                        <option value="{{ $saleCountry->country->id }}">{{ $saleCountry->country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-col form-col-2of3">
                                            <label class="form-label" for="street">
                                                Населено място
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <select name="city_id" id="city_id" class="select-custom m-b-0" required>
                                                    @foreach($countriesSale as $saleCountry)
                                                        <optgroup label="{{ $saleCountry->country->name }}">
                                                            @foreach($saleCountry->country->cities as $city)
                                                                <option value="{{ $city->id }}" {{ ($city->name == 'sofia') ? 'selected="selected"':'' }}>{{ $city->name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-cols-alt">
                                        <div class="form-col form-col-big">
                                            <label class="form-label" for="street">
                                                Адрес
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <input id="street" type="tel" placeholder="" name="street" required>
                                            </div>
                                        </div>
                                        <div class="form-col-small">
                                            <label class="form-label" for="street">
                                                №
                                                <span class="asterisk">*</span>
                                            </label>

                                            <div class="input-container">
                                                <input id="street" type="number" placeholder="" name="street_number" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-bottom">
                                <div class="checkboxes-wrapper">
                                    <label class="checkbox-wrapper">
                                        <input type="checkbox" id="defaultFirm" name="is_default">

                                        <span class="checkmark"></span>

                                        <span class="check-text">Фирма по подразбиране</span>
                                    </label>
                                </div>

                                <button type="submit" class="submit-button" value="">добави</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
