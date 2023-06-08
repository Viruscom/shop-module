@extends('layouts.app')

@section('content')
    <form class="my-form" action="{{ url('/admin/shop/clients/'.$client->id.'/firm_accounts/'.$account->id.'/update') }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{old('position')}}">

            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submitaddnew" value="submitaddnew" class="btn btn-lg green saveplusicon margin-bottom-10"></button>
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ url()->previous() }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group @if($errors->has('country')) has-error @endif">
                    <label class="control-label p-b-10"><span class="text-purple">*</span> Държава:</label>
                    <p class="form-control" disabled>{{ 'България' }}</p>
                    <input class="form-control hidden" type="text" name="country" value="{{ 'България' }}" required>
                    @if($errors->has('country'))
                        <span class="help-block">{{ trans($errors->first('country')) }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('city')) has-error @endif">
                    <label class="control-label p-b-10"><span class="text-purple">*</span> Град / Населено място:</label>
                    <input class="form-control" type="text" name="city" value="{{ (old('city')) ? old('city') : $account->city }}" autocomplete="off" required>
                    @if($errors->has('city'))
                        <span class="help-block">{{ trans($errors->first('city')) }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('registration_address')) has-error @endif">
                    <label class="control-label p-b-10"><span class="text-purple">*</span> Адрес:</label>
                    <input class="form-control" type="text" name="registration_address" value="{{ (old('registration_address')) ? old('registration_address') : $account->registration_address }}" autocomplete="off" required>
                    @if($errors->has('registration_address'))
                        <span class="help-block">{{ trans($errors->first('registration_address')) }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('phone')) has-error @endif">
                    <label class="control-label p-b-10">Телефон:</label>
                    <input class="form-control" type="text" name="phone" value="{{ (old('phone')) ? old('phone') : $account->phone }}" autocomplete="off">
                    @if($errors->has('phone'))
                        <span class="help-block">{{ trans($errors->first('phone')) }}</span>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @if($errors->has('title')) has-error @endif">
                    <label class="control-label p-b-10"><span class="text-purple">*</span> Фирма:</label>
                    <input class="form-control" type="text" name="title" value="{{ (old('title')) ? old('title') : $account->title }}" autocomplete="off" required>
                    @if($errors->has('title'))
                        <span class="help-block">{{ trans($errors->first('title')) }}</span>
                    @endif
                </div>

                <div class="form-group @if($errors->has('mol')) has-error @endif">
                    <label class="control-label p-b-10"><span class="text-purple">*</span> М.О.Л.:</label>
                    <input class="form-control" type="text" name="mol" value="{{ (old('mol')) ? old('mol') : $account->mol }}" autocomplete="off" required>
                    @if($errors->has('mol'))
                        <span class="help-block">{{ trans($errors->first('mol')) }}</span>
                    @endif
                </div>

                <div class="form-group @if($errors->has('eik')) has-error @endif">
                    <label class="control-label p-b-10"><span class="text-purple">*</span> ЕИК:</label>
                    <input class="form-control" type="text" name="eik" value="{{ (old('eik')) ? old('eik') : $account->eik }}" autocomplete="off" required>
                    @if($errors->has('eik'))
                        <span class="help-block">{{ trans($errors->first('eik')) }}</span>
                    @endif
                </div>

                <div class="form-group @if($errors->has('vat')) has-error @endif">
                    <label class="control-label p-b-10"> Булстат по ДДС:</label>
                    <input class="form-control" type="text" name="vat" value="{{ (old('vat')) ? old('vat') : $account->vat }}" autocomplete="off">
                    <input class="form-control hidden" type="text" name="client_id" value="{{ $client->id }}">
                    @if($errors->has('vat'))
                        <span class="help-block">{{ trans($errors->first('vat')) }}</span>
                    @endif
                </div>

            </div>

            <div class="col-sm-12 col-xs-12">
                <div class="form form-horizontal">
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
