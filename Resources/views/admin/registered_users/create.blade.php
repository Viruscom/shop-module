@extends('layouts.admin.app')
@section('styles')
    <link href="{{ asset('admin/plugins/foundation-datepicker/datepicker.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/plugins/foundation-datepicker/datepicker.js') }}"></script>
    <script>

        $('#birthday').fdatepicker({
            onRender: function (date) {
                return '';
            },
            format: 'yyyy-mm-dd'
        });
    </script>
@endsection
@section('content')
    @include('shop::admin.registered_users.breadcrumbs')
    @include('admin.notify')
    <form class="my-form" action="{{ route('admin.shop.registered-users.store') }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            @csrf

            @include('admin.partials.on_create.form_actions_top')
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4>Акаунт</h4>
                <div class="padding-20 bg-f5">
                    @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'first_name', 'label' => trans('shop::admin.registered_users.first_name'), 'required' => true, 'class' => 'width-p100'])
                    @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'last_name', 'label' => trans('shop::admin.registered_users.last_name'), 'required' => true, 'class' => 'width-p100'])
                    <div class="form-group @if($errors->has('email')) has-error @endif">
                        <label class="control-label p-b-10"><span class="text-purple">*</span> Email:</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" autocomplete="off" required>
                        @if($errors->has('email'))
                            <span class="help-block">{{ trans($errors->first('email')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('password')) has-error @endif">
                        <label class="control-label p-b-10"><span class="text-purple">*</span> Парола:</label>
                        <input class="form-control" type="password" name="password" value="{{ old('password') }}" autocomplete="off" required>
                        @if($errors->has('password'))
                            <span class="help-block">{{ trans($errors->first('password')) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h4>Допълнителни данни</h4>
                <div class="padding-20 bg-f5">
                    <div class="form-group @if($errors->has('client_group_id')) has-error @endif">
                        <label class="control-label p-b-10">Клиентска група:</label>
                        <select class="form-control select2" name="group_id">
                            <option value="1" selected="selected">@lang('administration_messages.client_group_1')</option>
                            <option value="2">@lang('administration_messages.client_group_2')</option>
                            {{--                            <option value="3">@lang('administration_messages.client_group_3')</option>--}}
                            {{--                            <option value="4">@lang('administration_messages.client_group_4')</option>--}}
                            {{--                            <option value="5">@lang('administration_messages.client_group_5')</option>--}}
                            {{--                            <option value="6">@lang('administration_messages.client_group_6')</option>--}}
                            {{--                            <option value="7">@lang('administration_messages.client_group_7')</option>--}}
                            {{--                            <option value="8">@lang('administration_messages.client_group_8')</option>--}}
                        </select>
                        @if($errors->has('client_group_id'))
                            <span class="help-block">{{ trans($errors->first('client_group_id')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('phone')) has-error @endif">
                        <label class="control-label p-b-10">Телефон:</label>
                        <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" autocomplete="off">
                        @if($errors->has('phone'))
                            <span class="help-block">{{ trans($errors->first('phone')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('birthday')) has-error @endif">
                        <label class="control-label p-b-10">Рожден ден:</label>
                        <input class="form-control" id="birthday" type="text" name="birthday" value="{{ old('birthday') }}" autocomplete="off">
                        @if($errors->has('birthday'))
                            <span class="help-block">{{ trans($errors->first('birthday')) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="form form-horizontal">
                    <div class="form-body">
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-md-3">@lang('shop::admin.registered_users.active_account'):</label>
                            <div class="col-md-6">
                                <label class="switch pull-left">
                                    <input type="checkbox" name="active" class="success" data-size="small" checked {{(old('active') ? 'checked' : 'active')}}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">@lang('shop::admin.registered_users.newsletter_subscription'):</label>
                            <div class="col-md-6">
                                <label class="switch pull-left">
                                    <input type="checkbox" name="newsletter_allowed" class="success" data-size="small" {{(old('active') ? 'checked' : 'active')}}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @include('admin.partials.on_create.form_actions_bottom')
                </div>
            </div>
        </div>
    </form>
@endsection
