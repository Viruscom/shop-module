@extends('layouts.admin.app')

@section('scripts')
    <script>
        function getRequest(route, data, element) {
            $.get(route, data)
             .done(function (result) {
                 element.html(result);
             })
             .fail(function (xhr, status, error) {
                 console.error(error);
             });
        }

        $(document).ready(function () {
            $('#country_id').change(function () {
                $('.states').html('');
                $('.cities').html('');
                var countryId = $(this).val();
                if (countryId !== '') {
                    getRequest("{{ route('admin.shop.registered-users.shipment-addresses.get-states', ['id' => $registeredUser->id]) }}",
                        {country_id: countryId}, $('.states'))
                }
            });

            var cidDiv        = $('.cid.hidden');
            var stateDiv      = $('.sid.hidden');
            var countrySelect = $('#country_id');

            if (cidDiv.text().trim() !== '') {
                var selectedCountryId = cidDiv.text().trim();
                countrySelect.val(selectedCountryId).trigger('change');

                setTimeout(function () {
                    var stateSelect = $('#state_id');
                    if (stateDiv.text().trim() !== '') {
                        var selectedStateId = stateDiv.text().trim();
                        stateSelect.val(selectedStateId).trigger('change');
                    }

                    setTimeout(function () {
                        var citySelect = $('#cities');
                        var cityDiv    = $('.ciid.hidden');
                        if (cityDiv.text().trim() !== '') {
                            var selectedCityId = cityDiv.text().trim();
                            citySelect.val(selectedCityId).trigger('change');
                        }
                    }, 600);

                }, 600);
            }

        });

        $(document).on('change', '#state_id', function () {
            var stateId = $(this).val();
            if (stateId !== '') {
                var route   = "{{ route('admin.shop.registered-users.shipment-addresses.get-cities', ['id' => $registeredUser->id]) }}";
                var data    = {state_id: stateId};
                var element = $('.cities');
                getRequest(route, data, element);
            }
        });
    </script>
@endsection

@section('content')
    <form class="my-form" action="{{ route('admin.shop.registered-users.shipment-addresses.update', ['id' => $registeredUser->id, 'address_id' => $address->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('admin.partials.on_edit.form_actions_top')
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['model' => $address, 'fieldName' => 'name', 'label' => 'Име на адреса', 'required' => true])

                @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['model' => $address, 'fieldName' => 'zip_code', 'label' => 'Пощенски код', 'required' => false])
                <div class="form-group @if($errors->has('is_default')) has-error @endif">
                    <label class="control-label p-b-10">@lang('shop::admin.registered_users.default'):</label>
                    <input type="checkbox" name="is_default" value="{{ old('is_default') }}" autocomplete="off">
                    @if($errors->has('is_default'))
                        <span class="help-block">{{ trans($errors->first('is_default')) }}</span>
                    @endif
                </div>
                @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['model' => $address, 'fieldName' => 'street', 'label' => 'Улица/Адрес', 'required' => true])
                @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['model' => $address, 'fieldName' => 'street_number', 'label' => ' Улица №', 'required' => true])
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="country_id" class="control-label"><span class="text-purple">* </span>@lang('shop::admin.registered_users.country'):</label>
                    <select id="country_id" class="form-control select2" name="country_id">
                        <option value="">@lang('admin.common.please_select')</option>
                        @foreach($saleCountries as $country)
                            <option value="{{ $country->country->id }}" {{($country->country->id === old('country_id')) ? 'selected': ''}}>  {{ $country->country->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="states"></div>
                <div class="cities"></div>
                <div class="cid hidden">{{ $address->country_id }}</div>
                <div class="sid hidden">{{ $address->city->state->id }}</div>
                <div class="ciid hidden">{{ $address->city_id }}</div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="form form-horizontal">
                    @include('admin.partials.on_edit.form_actions_bottom')
                </div>
            </div>
        </div>
    </form>
@endsection
