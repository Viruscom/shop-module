@extends('layouts.admin.app')

@section('content')
    @include('shop::admin.registered_users.breadcrumbs')
    @include('admin.notify')
    <form class="my-form" action="{{ route('admin.shop.registered-users.companies.store', ['id' => $registeredUser->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('admin.partials.on_create.form_actions_top')
        </div>
        <div class="row">
            <div class="col-md-6">
                {{--                @include('admin.partials.on_create.form_fields.select', ['fieldName' => 'country_id',  'label' => 'Държава', 'models' => $mainCatalogs, 'required' => true])--}}
                {{--                @include('admin.partials.on_create.form_fields.select', ['fieldName' => 'city_id',  'label' => 'Град/Село', 'models' => $mainCatalogs, 'required' => true])--}}

                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'company_address', 'label' => 'Адрес на регистрация', 'required' => true])
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'phone', 'label' => 'Телефон', 'required' => true])
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'email', 'label' => 'Email', 'required' => true])

                <div class="form-group">
                    <label class="control-label">По подразбиране:</label>
                    <div class="">
                        <label class="switch pull-left">
                            <input type="checkbox" name="is_default" class="success" data-size="small" {{(old('is_default') ? 'checked' : 'active')}}>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'company_name', 'label' => 'Фирма', 'required' => true])
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'company_mol', 'label' => 'М.О.Л.', 'required' => true])
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'company_eik', 'label' => 'ЕИК', 'required' => true])
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'company_vat_eik', 'label' => 'Булстат по ДДС', 'required' => false])
                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'zip_code', 'label' => 'Пощенски код', 'required' => false])
            </div>
        </div>

        <div class="row hidden">
            <div class="col-md-12">
                <h4>Адрес на доставка</h4>
            </div>
            <div class="col-md-6">
                <input type="text" name="street" value="1">
                <input type="text" name="street_number" value="1">
{{--                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'street', 'label' => 'Улица/Адрес', 'required' => true])--}}
            </div>
            <div class="col-md-6">
{{--                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'street_number', 'label' => ' Улица №', 'required' => true])--}}
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
