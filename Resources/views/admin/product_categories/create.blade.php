@extends('layouts.app')
@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(".select2").select2({language: "bg"});
    </script>
@endsection

@section('content')
    <div class="col-xs-12 p-0">
        <form class="my-form" action="{{ url('/admin/product_categories/'.$navigationId.'/store') }}" method="POST" enctype="multipart/form-data" data-form-type="store">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{old('position')}}">
            <div class="navigation-id-old hidden">{{old('navigation_id')}}</div>
            <div class="navigation-id-current hidden">{{$navigationId}}</div>

            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submitaddnew" value="submitaddnew" class="btn btn-lg green saveplusicon margin-bottom-10"></button>
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ url('/admin/product_categories') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label page-label col-md-3"><span class="text-purple">* </span>Прикрепи към навигация:</label>
            <div class="col-md-4">
                <select class="form-control select2 inner-page-product_categories-select" name="navigation_id">
                    @foreach($navigations as $navigation)
                        <option value="{{ $navigation->id }}">{{ $navigation->translations->firstWhere('language_id',1)->title}}</option>
                    @endforeach
                </select>
            </div>
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
                    <?php $langTitle = 'title_' . $language->code; $langShortDescr = 'short_description_' . $language->code; $langDescription = 'first_text_' . $language->code; $langVisible = 'visible_' . $language->code; ?>
                    <div id="{{$language->code}}" class="tab-pane fade in @if($language->code == env('DEF_LANG_CODE')) active @endif}}">
                        <div class="form-group @if($errors->has($langTitle)) has-error @endif">
                            <label class="control-label p-b-10"><span class="text-purple">* </span>Заглавие / link (<span class="text-uppercase">{{$language->code}}</span>):</label>
                            <input class="form-control" type="text" name="{{$langTitle}}" value="{{ old($langTitle) }}">
                            @if($errors->has($langTitle))
                                <span class="help-block">{{ trans($errors->first($langTitle)) }}</span>
                            @endif
                        </div>
                        <div class="form-group @if($errors->has($langShortDescr)) has-error @endif">
                            <label class="control-label p-b-10">Кратко описание (<span class="text-uppercase">{{$language->code}}</span>):</label>
                            <textarea name="{{$langShortDescr}}" class="form-control" rows="3">{{ old($langShortDescr) }}</textarea>
                            @if($errors->has($langShortDescr))
                                <span class="help-block">{{ trans($errors->first($langShortDescr)) }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="form form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Изображение:</label>
                        <div class="col-md-9">
                            <input type="file" name="image" class="filestyle" data-buttonText="{{trans('administration_messages.browse_file')}}" data-iconName="fas fa-upload" data-buttonName="btn green" data-badge="true">
                            <p class="help-block">{!! $fileRulesInfo !!}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3">Активен (видим) в сайта:</label>
                        <div class="col-md-6">
                            <label class="switch pull-left">
                                <input type="checkbox" name="active" class="success" data-size="small" checked {{(old('active') ? 'checked' : 'active')}}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3">Позиция в сайта:</label>
                        <div class="col-md-6">
                            <p class="position-label"></p>
                            <a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal">Моля, изберете позиция</a>
                            <p class="help-block">(ако не изберете позиция, записът се добавя като последен)</p>
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
                            @if(count($productCategories))
                                @foreach($productCategories as $productCategory)
                                    <tr class="pickPositionTr" data-position="{{$productCategory->position}}">
                                        <td>{{$productCategory->position}}</td>
                                        <td>{{$productCategory->translations->firstWhere('language_id',$defaultLanguage->id)->title}}</td>
                                    </tr>
                                @endforeach
                                <tr class="pickPositionTr" data-position="{{$productCategories->last()->position+1}}">
                                    <td>{{$productCategories->last()->position+1}}</td>
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
                                    <a role="button" class="btn back-btn margin-bottom-10 cancel-position-change" current-position="{{ old('position') }}" data-dismiss="modal"><i class="fa fa-reply"></i> назад</a>
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
