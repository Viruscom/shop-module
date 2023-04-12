@extends('layouts.app')

@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/plugins/colorpicker/jquery.minicolors.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin/plugins/colorpicker/jquery.minicolors.min.js') }}"></script>
    <script>
        try {
            CKEDITOR.timestamp = new Date();
            CKEDITOR.replace('editor');
        } catch {
        }
        $(".select2").select2({language: "bg"});
    </script>

    <script>
        $(document).ready(function () {

            $('.demo').each(function () {
                //
                // Dear reader, it's actually very easy to initialize MiniColors. For example:
                //
                //  $(selector).minicolors();
                //
                // The way I've done it below is just for the demo, so don't get confused
                // by it. Also, data- attributes aren't supported at this time...they're
                // only used for this demo.
                //
                $(this).minicolors({
                    control: $(this).attr('data-control') || 'hue',
                    defaultValue: $(this).attr('data-defaultValue') || '',
                    format: $(this).attr('data-format') || 'hex',
                    keywords: $(this).attr('data-keywords') || '',
                    inline: $(this).attr('data-inline') === 'true',
                    letterCase: $(this).attr('data-letterCase') || 'lowercase',
                    opacity: $(this).attr('data-opacity'),
                    position: $(this).attr('data-position') || 'bottom',
                    swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
                    change: function (value, opacity) {
                        if (!value) return;
                        if (opacity) value += ', ' + opacity;
                        if (typeof console === 'object') {
                            console.log(value);
                        }
                    },
                    theme: 'bootstrap'
                });

            });

        });
    </script>
@endsection

@section('content')
    <form class="my-form" action="{{ route('products.attributes.values.update', ['attr_id' => $productAttribute->id, 'id' => $productAttributeValue->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data">
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
            <div class="col-sm-12 col-xs-12">
                <h4>Редактиране на стойност към атрибут: {{ $productAttribute->defaultTranslation->title }}</h4>
            </div>
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
                            $productAttributeValueTranslation = (is_null($productAttributeValue->translations->where('language_id', $language->id)->first())) ? null: $productAttributeValue->translations->where('language_id', $language->id)->first()
                        @endphp
                        <div id="{{$language->code}}" class="tab-pane fade in @if($language->code == env('DEF_LANG_CODE')) active @endif}}">
                            <div class="form-group @if($errors->has($langTitle)) has-error @endif">
                                <label class="control-label p-b-10">Заглавие (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                <input class="form-control" type="text" name="{{$langTitle}}" value="{{ old($langTitle) ?? $productAttributeValueTranslation->title }}">
                                @if($errors->has($langTitle))
                                    <span class="help-block">{{ trans($errors->first($langTitle)) }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($productAttribute->type == 3)
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group @if($errors->has('color_picker_color')) has-error @endif">
                            <label for="text-field" class="control-label p-b-10">Цвят:</label>
                            <input type="text" id="text-field" class="form-control demo" value="{{ old('color_picker_color') ?: $productAttributeValue->color_picker_color }}" name="color_picker_color" required>
                            @if($errors->has('color_picker_color'))
                                <span class="help-block">{{ trans($errors->first('color_picker_color')) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group @if($errors->has('filename')) has-error @endif">
                            <label class="control-label p-b-10">Файл:</label>
                            <input type="file" name="filename" class="filestyle" data-buttonText="{{trans('administration_messages.browse_file')}}" data-iconName="fas fa-upload" data-buttonName="btn green" data-badge="true">
                            @if($errors->has('filename'))
                                <span class="help-block">{{ trans($errors->first('filename')) }}</span>
                            @endif
                        </div>

                        <div>
                            @if ($productAttributeValue->filename != '')
                                <div class="overlay-delete-img hidden">
                                    <a href="{{ route('products.attributes.values.delete-img', ['attr_id' => $productAttribute->id, 'id' => $productAttributeValue->id]) }}" class="del-link del-link-ajax"><i class="fas fa-times"></i>
                                        <p>Изтрий</p></a>
                                </div>
                                <img class="thumbnail content-box1 has-img img-responsive" src="{{ $productAttributeValue->imageUrl() }}" width="205"/>
                            @else
                                <img class="thumbnail img-responsive" src="{{ $productAttributeValue->getSystemImage() }}" width="205"/>
                            @endif
                            <div class="default-img-path hidden">{{ $productAttributeValue->getSystemImage() }}</div>

                            <div class="alert alert-success removed-img-ajax hidden" style="width: 205px;">Успешно изтриване!</div>
                        </div>
                    </div>
                @endif
                <div class="form form-horizontal">
                    <div class="form-body">
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
                                @if(count($attributes))
                                    @foreach($attributes as $productAttribute)
                                        <tr class="pickPositionTr" data-position="{{$productAttribute->position}}">
                                            <td>{{$productAttribute->position}}</td>
                                            <td>{{$productAttribute->defaultTranslation->title}}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="pickPositionTr" data-position="{{$attributes->last()->position+1}}">
                                        <td>{{$attributes->last()->position+1}}</td>
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
        </div>
    </form>
@endsection
