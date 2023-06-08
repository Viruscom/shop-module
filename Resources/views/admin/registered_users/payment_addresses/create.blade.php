@extends('layouts.app')

@section('content')
    <form class="my-form" action="{{ url('/admin/shop/clients/'.$client->id.'/billing_addresses/store') }}" method="POST" data-form-type="store" enctype="multipart/form-data">
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
                    <input class="form-control" type="text" name="city" value="{{ old('city') }}" autocomplete="off" required>
                    @if($errors->has('city'))
                        <span class="help-block">{{ trans($errors->first('city')) }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('post_code')) has-error @endif">
                    <label class="control-label p-b-10"><span class="text-purple">*</span> Пощенски код:</label>
                    <input class="form-control" type="text" name="post_code" value="{{ old('post_code') }}" autocomplete="off" required>
                    @if($errors->has('post_code'))
                        <span class="help-block">{{ trans($errors->first('post_code')) }}</span>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @if($errors->has('address')) has-error @endif">
                    <label class="control-label p-b-10"><span class="text-purple">*</span> Адрес:</label>
                    <input class="form-control" type="text" name="address" value="{{ old('address') }}" autocomplete="off" required>
                    @if($errors->has('address'))
                        <span class="help-block">{{ trans($errors->first('address')) }}</span>
                    @endif
                </div>

                <div class="form-group @if($errors->has('phone')) has-error @endif">
                    <label class="control-label p-b-10">Телефон:</label>
                    <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" autocomplete="off">
                    @if($errors->has('phone'))
                        <span class="help-block">{{ trans($errors->first('phone')) }}</span>
                    @endif
                </div>

                <div class="form-group @if($errors->has('landline_phone')) has-error @endif">
                    <label class="control-label p-b-10">Стационарен телефон:</label>
                    <input class="form-control" type="text" name="landline_phone" value="{{ old('landline_phone') }}" autocomplete="off">
                    <input class="form-control hidden" type="text" name="client_id" value="{{ $client->id }}">
                    @if($errors->has('landline_phone'))
                        <span class="help-block">{{ trans($errors->first('landline_phone')) }}</span>
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
