@extends('layouts.app')

@section('content')
    <div class="col-xs-12 p-0">
        <form class="my-form" action="{{ url('/admin/shop/orders/'.$order->id.'/documents/store') }}" method="POST" data-form-type="store" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submitaddnew" value="submitaddnew" class="btn btn-lg green saveplusicon margin-bottom-10"></button>
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ url('/admin/shop/orders/'.$order->id.'/show') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="form form-horizontal">
                <div class="form-body">
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        <label class="control-label col-md-3"><span class="text-purple">*</span> Име на документ:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                        </div>
                        @if($errors->has('name'))
                            <span class="help-block">{{ trans($errors->first('name')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('comment')) has-error @endif">
                        <label class="control-label col-md-3"><span class="text-purple">*</span> Коментар:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="comment" value="{{ old('comment') }}">
                        </div>
                        @if($errors->has('comment'))
                            <span class="help-block">{{ trans($errors->first('comment')) }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3"><span class="text-purple">*</span> Документ:</label>
                        <div class="col-md-9">
                            <input type="file" name="file" class="filestyle" data-buttonText="{{trans('administration_messages.browse_file')}}" data-iconName="fas fa-upload" data-buttonName="btn green" data-badge="true">
                            {{--                            <p class="help-block">{!! $fileRulesInfo !!}</p>--}}
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" name="submitaddnew" value="submitaddnew" class="btn green saveplusbtn margin-bottom-10"> запиши и добави нов</button>
                            <button type="submit" name="submit" value="submit" class="btn save-btn margin-bottom-10"><i class="fas fa-save"></i> запиши</button>
                            <a href="{{ url('/admin/shop/orders/'.$order->id.'/show') }}" role="button" class="btn back-btn margin-bottom-10"><i class="fa fa-reply"></i> назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
