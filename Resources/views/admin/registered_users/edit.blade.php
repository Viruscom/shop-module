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
    <form class="my-form" action="{{ route('admin.shop.registered-users.update', ['id' => $registeredUser->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            @csrf
            @include('admin.partials.on_edit.form_actions_top')
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4>Акаунт</h4>
                <div class="padding-20 bg-f5">
                    @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'first_name', 'label' => trans('shop::admin.registered_users.first_name'), 'required' => true, 'class' => 'width-p100', 'model' => $registeredUser])
                    @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'last_name', 'label' => trans('shop::admin.registered_users.last_name'), 'required' => true, 'class' => 'width-p100', 'model' => $registeredUser])
                    <div class="form-group @if($errors->has('email')) has-error @endif">
                        <label class="control-label p-b-10"><span class="text-purple">*</span> Email:</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') ? old('email') : (!is_null($registeredUser) ? $registeredUser->email : '') }}" required>
                        @if($errors->has('email'))
                            <span class="help-block">{{ trans($errors->first('email')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('password')) has-error @endif">
                        <label class="control-label p-b-10"><span class="text-purple">*</span> Парола:</label>
                        <input class="form-control" type="password" name="password" value="{{ old('password') }}">
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
                        <select class="form-control select2" name="client_group_id">
                            @foreach($clientGroups as $clientGroup)
                                <option value="{{$clientGroup}}" {{old('client_group_id')==$clientGroup ? 'selected':''}}>{{__('shop::admin.discounts.client_group_'.$clientGroup)}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('client_group_id'))
                            <span class="help-block">{{ trans($errors->first('client_group_id')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('phone')) has-error @endif">
                        <label class="control-label p-b-10">Телефон:</label>
                        <input class="form-control" type="text" name="phone" value="{{ old('phone') ? old('phone') : (!is_null($registeredUser) ? $registeredUser->phone : '') }}">
                        @if($errors->has('phone'))
                            <span class="help-block">{{ trans($errors->first('phone')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('birthday')) has-error @endif">
                        <label class="control-label p-b-10">Рожден ден:</label>
                        <input class="form-control" id="birthday" type="text" name="birthday" value="{{ old('birthday') ? old('birthday') : (!is_null($registeredUser) ? $registeredUser->birthday : '') }}">
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
                            <label class="control-label col-md-3">Активен акаунт:</label>
                            <div class="col-md-6">
                                <label class="switch pull-left">
                                    <input type="checkbox" name="active" class="success" data-size="small" checked {{(old('active') ? 'checked' : 'active')}}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Получаване на оферти:</label>
                            <div class="col-md-6">
                                <label class="switch pull-left">
                                    <input type="checkbox" name="newsletter_allowed" class="success" data-size="small" {{(old('active') ? 'checked' : 'active')}}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="submitaddnew" value="submitaddnew" class="btn green saveplusbtn margin-bottom-10"> запиши и добави нов</button>
                                <button type="submit" name="submit" value="submit" class="btn save-btn margin-bottom-10"><i class="fas fa-save"></i> запиши</button>
                                <a href="{{ url()->previous() }}" role="button" class="btn back-btn margin-bottom-10"><i class="fa fa-reply"></i> назад</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
