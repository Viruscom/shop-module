@extends('layouts.app')
@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/plugins/foundation-datepicker/datepicker.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/foundation-datepicker/datepicker.js') }}"></script>
    <script>
        $(".select2").select2({language: "bg"});
    </script>
@endsection
@section('content')
    <form class="my-form" action="{{ url('/admin/product_adboxes/'.$adBox->id.'/update') }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{(old('position')) ? old('position') : $adBox->position}}">

            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    @if ($adBox->type != \App\Models\AdBox::$WAITING_ACTION)
                        <a href="{{ url('/admin/product_adboxes/'.$adBox->id.'/return_to_waiting') }}" role="button" class="btn btn-lg btn yellow margin-bottom-10 tooltips" style="padding: 8px 10px;" data-toggle="tooltip" data-placement="left" data-original-title="Върни карето в изчакващи"><img src="{{ asset('admin/assets/images/back_to_wait.svg') }}" width="23px"></a>
                    @endif
                    <a href="{{ url('/admin/product_adboxes') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
        </div>
        @if($adBox->type == \App\Models\AdBox::$WAITING_ACTION)
            <input type="radio" name="type" class="adbox-type hidden" value="1" checked>
        @endif
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <ul class="nav nav-tabs">
                    @foreach($languages as $language)
                        <li @if($language->code == env('DEF_LANG_CODE')) class="active" @endif}}><a data-toggle="tab" href="#{{$language->code}}">{{$language->code}} <span class="err-span-{{$language->code}} hidden text-purple"><i class="fas fa-exclamation"></i></span></a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($languages as $language)
                            <?php
                            $langTitle        = 'title_' . $language->code;
                            $adboxTranslation = (is_null($adBox->translations->where('language_id', $language->id)->first())) ? null : $adBox->translations->where('language_id', $language->id)->first();
                            ?>
                        <div id="{{$language->code}}" class="tab-pane fade in @if($language->code == env('DEF_LANG_CODE')) active @endif">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group @if($errors->has($langTitle)) has-error @endif">
                                        <label class="control-label p-b-10"><span class="text-purple">* </span>Заглавие (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                        <input class="form-control" type="text" name="{{$langTitle}}" value="{{ old($langTitle) ?: (!is_null($adboxTranslation) ? $adboxTranslation->title : '') }}" required>
                                        @if($errors->has($langTitle))
                                            <span class="help-block">{{ trans($errors->first($langTitle)) }}</span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                </div>
                @endforeach
            </div>

            <div class="col-sm-12 col-xs-12">
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" name="submit" value="submit" class="btn save-btn margin-bottom-10"><i class="fas fa-save"></i> запиши</button>
                            <a href="{{ url('/admin/product_adboxes/') }}" role="button" class="btn back-btn margin-bottom-10"><i class="fa fa-reply"></i> назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
