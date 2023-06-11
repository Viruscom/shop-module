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
                    getRequest("{{ route('admin.shop.registered-users.payment-addresses.get-states', ['id' => $registeredUser->id]) }}",
                        {country_id: countryId}, $('.states'))
                }
            });
        });

        $(document).on('change', '#state_id', function () {
            var stateId = $(this).val();
            if (stateId !== '') {
                var route   = "{{ route('admin.shop.registered-users.payment-addresses.get-cities', ['id' => $registeredUser->id]) }}";
                var data    = {state_id: stateId};
                var element = $('.cities');
                getRequest(route, data, element);
            }
        });
    </script>
@endsection

@section('content')
    <form class="my-form" action="{{ route('admin.shop.registered-users.payment-addresses.store', ['id' => $registeredUser->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('admin.partials.on_create.form_actions_top')
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'name', 'label' => 'Име на адреса', 'required' => true])
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'zip_code', 'label' => 'Пощенски код', 'required' => false])
                <div class="form-group @if($errors->has('is_default')) has-error @endif">
                    <label class="control-label p-b-10">@lang('shop::admin.registered_users.default'):</label>
                    <input type="checkbox" name="is_default" value="{{ old('is_default') }}" autocomplete="off">
                    @if($errors->has('is_default'))
                        <span class="help-block">{{ trans($errors->first('is_default')) }}</span>
                    @endif
                </div>
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'email', 'label' => 'Email', 'required' => true])
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'street', 'label' => 'Улица/Адрес', 'required' => true])
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'street_number', 'label' => ' Улица №', 'required' => true])
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
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="form form-horizontal">
                    @include('admin.partials.on_create.form_actions_bottom')
                </div>
            </div>
        </div>
    </form>
@endsection
