@extends('layouts.admin.app')

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
    @include('shop::admin.brands.breadcrumbs')
    @include('admin.notify')
    
    <form class="my-form" action="{{ route('admin.brands.update', ['id' => $brand->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{(old('position')) ?: $brand->position}}">

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
                        <li @if($language->code === config('default.app.language.code')) class="active" @endif><a data-toggle="tab" href="#{{$language->code}}">{{$language->code}} <span class="err-span-{{$language->code}} hidden text-purple"><i class="fas fa-exclamation"></i></span></a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($languages as $language)
                        <div id="{{$language->code}}" class="tab-pane fade in @if($language->code === config('default.app.language.code')) active @endif">

                            @include('admin.partials.on_edit.form_fields.input_text', ['model'=> $brand, 'fieldName' => 'title_' . $language->code, 'label' => trans('admin.title'), 'required' => true])
                            @include('admin.partials.on_edit.form_fields.textarea', ['model'=> $brand, 'fieldName' => 'announce_' . $language->code, 'rows' => 4, 'label' => trans('admin.admin.announce'), 'required' => false])
                            @include('admin.partials.on_edit.form_fields.textarea', ['model'=> $brand, 'fieldName' => 'description_' . $language->code, 'rows' => 9, 'label' => trans('admin.description'), 'required' => false])
                            @include('admin.partials.on_edit.show_in_language_visibility_checkbox', ['model'=> $brand, 'fieldName' => 'visible_' . $language->code])

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
                                            <td>{{$brand->title}}</td>
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
