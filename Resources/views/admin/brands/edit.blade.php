@extends('layouts.app')

@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        try {
            CKEDITOR.timestamp = new Date();
            CKEDITOR.replace('editor');
        } catch {
        }
        $(".select2").select2({language: "bg"});
    </script>
@endsection

@section('content')
    <div class="col-xs-12 p-0">
        <form class="my-form" action="{{ url('/admin/brands/'.$brand->id.'/update') }}" method="POST" data-form-type="store" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{(old('position')) ? old('position') : $brand->position}}">

            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ url()->previous() }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning"><strong>Внимание! </strong>Промяната на загланието (името) или на активността (видимостта) на марката ще се отрази в sitemap-a на сайта и може да доведе до промени в индексирането на Вашия сайт от търсачките.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <ul class="nav nav-tabs">
                @foreach($languages as $language)
                    <li @if($language->code == env('DEF_LANG_CODE')) class="active" @endif}}><a data-toggle="tab" href="#{{$language->code}}">{{$language->code}} <span class="err-span-{{$language->code}} hidden text-purple"><i class="fas fa-exclamation"></i></span></a></li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($languages as $language)
                    @php
                        $langTitle = 'title_'.$language->code;
                        $langShortDescr = 'short_description_'.$language->code;
                        $langFirstText = 'first_text_'.$language->code;
                        $langVersionShow = 'visible_'.$language->code;
                        $brandTranslation = (is_null($brand->translations->where('language_id', $language->id)->first())) ? null: $brand->translations->where('language_id', $language->id)->first()
                    @endphp
                    <div id="{{$language->code}}" class="tab-pane fade in @if($language->code == env('DEF_LANG_CODE')) active @endif}}">
                        <div class="form-group @if($errors->has($langTitle)) has-error @endif">
                            <label class="control-label p-b-10">Заглавие (<span class="text-uppercase">{{$language->code}}</span>):</label>
                            <input class="form-control" type="text" name="{{$langTitle}}" value="{{ old($langTitle) ? old($langTitle) : (!is_null($brandTranslation) ? $brandTranslation->title : '') }}">
                            @if($errors->has($langTitle))
                                <span class="help-block">{{ trans($errors->first($langTitle)) }}</span>
                            @endif
                        </div>
                        <div class="form-group @if($errors->has($langShortDescr)) has-error @endif">
                            <label class="control-label p-b-10">Кратко описание (<span class="text-uppercase">{{$language->code}}</span>):</label>
                            <textarea name="{{$langShortDescr}}" class="form-control" rows="3">{{ old($langShortDescr) ? old($langShortDescr) : (!is_null($brandTranslation) ? $brandTranslation->short_description : '') }}</textarea>
                            @if($errors->has($langShortDescr))
                                <span class="help-block">{{ trans($errors->first($langShortDescr)) }}</span>
                            @endif
                        </div>
                        <div class="form-group m-b-0 @if($errors->has($langFirstText)) has-error @endif">
                    <textarea name="{{$langFirstText}}" class="ckeditor col-xs-12" rows="9">
                        {{ old($langFirstText) ? old($langFirstText) : (!is_null($brandTranslation) ? $brandTranslation->first_text : '') }}
                    </textarea>
                            @if($errors->has($langFirstText))
                                <span class="help-block">{{ trans($errors->first($langFirstText)) }}</span>
                            @endif
                        </div>

                        <div class="form-group m-t-10 m-b-40 p-t-20">
                            <label class="control-label col-md-3">Покажи в езикова версия (<span class="text-uppercase">{{$language->code}}</span>):</label>
                            <div class="col-md-6">
                                <label class="switch pull-left">
                                    <input type="checkbox" name="{{$langVersionShow}}" class="success" data-size="small" {{ old($langVersionShow) ? 'checked' : ((!is_null($brandTranslation) && $brandTranslation->visible) ? 'checked': 'active') }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="form form-horizontal">
                <div class="form-body">
                    <div class="form-group banner-image">
                        <label class="control-label col-md-3"><span class="text-purple">* </span>Изображение:</label>
                        <div class="col-md-9">
                            <input type="file" name="image" class="filestyle" data-buttonText="{{trans('administration_messages.browse_file')}}" data-iconName="fas fa-upload" data-buttonName="btn green" data-badge="true">
                            <p class="help-block">{!! $fileRulesInfo !!}</p>
                            <div>
                                @if (!is_null($brand->filename) && file_exists($brand->fullImageFilePath()))
                                    <div class="overlay-delete-img hidden">
                                        <a href="{{ url('/admin/brands/'.$brand->id.'/img/delete') }}" class="del-link"><i class="fas fa-times"></i>
                                            <p>Изтрий</p></a>
                                    </div>
                                    <img class="thumbnail content-box1 has-img img-responsive" src="{{ $brand->fullImageFilePathUrl() }}" width="300"/>
                                @else
                                    <img class="thumbnail img-responsive" src="{{ asset('/admin/assets/system_images/brand_img.png') }}" width="300"/>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group banner-image">
                        <label class="control-label col-md-3"><span class="text-purple">* </span>Лого:</label>
                        <div class="col-md-9">
                            <input type="file" name="logo_image" class="filestyle" data-buttonText="{{trans('administration_messages.browse_file')}}" data-iconName="fas fa-upload" data-buttonName="btn green" data-badge="true">
                            <p class="help-block">{!! $fileRulesInfo !!}</p>
                            <div>
                                @if (!is_null($brand->logo_filename) && file_exists($brand->fullLogoImageFilePath()))
                                    <div class="overlay-delete-img2 hidden">
                                        <a href="{{ url('/admin/brands/'.$brand->id.'/img/deleteLogo') }}" class="del-link"><i class="fas fa-times"></i>
                                            <p>Изтрий</p></a>
                                    </div>
                                    <img class="thumbnail content-box2 has-img img-responsive" src="{{ $brand->fullLogoImageFilePathUrl() }}" width="300"/>
                                @else
                                    <img class="thumbnail img-responsive" src="{{ asset('/admin/assets/system_images/brand_logo_img.png') }}" width="300"/>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Покажи лого в сайта:</label>
                        <div class="col-md-6">
                            <label class="switch pull-left">
                                <input type="checkbox" name="logo_active" class="success" data-size="small" {{(old('logo_active') ? 'checked' : ((!is_null($brand) && $brand->logo_active) ? 'checked': 'active'))}}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3">Активен (видим) в сайта:</label>
                        <div class="col-md-6">
                            <label class="switch pull-left">
                                <input type="checkbox" name="active" class="success" data-size="small" {{(old('active') ? 'checked' : ((!is_null($brand) && $brand->active) ? 'checked': 'active'))}}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3">Позиция в сайта:</label>
                        <div class="col-md-6">
                            <p class="position-label">№ {{ $brand->position }}</p>
                            <a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal">Моля, изберете позиция</a>
                            <p class="help-block">(ако не изберете позиция, записът се добавя като последен)</p>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" name="submit" value="submit" class="btn save-btn margin-bottom-10"><i class="fas fa-save"></i> запиши</button>
                            <a href="{{ url()->previous() }}" role="button" class="btn back-btn margin-bottom-10"><i class="fa fa-reply"></i> назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close text-purple" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Изберете позиция</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-hover table-positions">
                            <tbody>
                            @if(count($brands))
                                @foreach($brands as $brand)
                                    <tr class="pickPositionTr" data-position="{{$brand->position}}">
                                        <td>{{$brand->position}}</td>
                                        <td>{{$brand->translations->firstWhere('language_id',$defaultLanguage->id)->title}}</td>
                                    </tr>
                                @endforeach
                                <tr class="pickPositionTr" data-position="{{$brands->last()->position+1}}">
                                    <td>{{$brands->last()->position+1}}</td>
                                    <td>--{{trans('administration_messages.last_position')}}--</td>
                                </tr>
                            @else
                                <tr class="pickPositionTr" data-position="1">
                                    <td>1</td>
                                    <td>--{{trans('administration_messages.last_position')}}--</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <a href="#" class="btn save-btn margin-bottom-10 accept-position-change" data-dismiss="modal"><i class="fas fa-save"></i> потвърди</a>
                                    <a role="button" class="btn back-btn margin-bottom-10 cancel-position-change" current-position="{{ $brand->position }}" data-dismiss="modal"><i class="fa fa-reply"></i> назад</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
