@extends('layouts.app')
@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(".select2").select2({language: "bg"});
        var focusedEditor;
        CKEDITOR.timestamp = new Date();
        CKEDITOR.on('instanceReady', function (evt) {
            var editor = evt.editor;
            editor.on('focus', function (e) {
                focusedEditor = e.editor.name;
            });
        });
    </script>
@endsection

@section('content')
    <div class="col-xs-12 p-0">
        <form class="my-form" action="{{ url('/admin/products/'.$categoryId.'/store') }}" method="POST" data-form-type="store" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{old('position')}}">
            <div class="navigation-id-old hidden">{{old('product_category_id')}}</div>
            <div class="navigation-id-current hidden">{{$categoryId}}</div>

            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submitaddnew" value="submitaddnew" class="btn btn-lg green saveplusicon margin-bottom-10"></button>
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ url('/admin/products') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label page-label col-md-3"><span class="text-purple">* </span>Прикрепи към навигация:</label>
            <div class="col-md-4">
                <select class="form-control select2 inner-page-products-select" name="product_category_id">
                    @foreach($categories as $categ)
                        <optgroup label="{{ $categ->translations->firstWhere('language_id',1)->title}}">
                            @foreach($categ->product_categories as $product)
                                <option value="{{ $product->id }}" {{($product->id==$categoryId) ? 'selected': ''}}>  {{ $product->translations->firstWhere('language_id',1)->title}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <ul class="nav nav-tabs nav-tabs-first">
                @foreach($languages as $language)
                    <li @if($language->code == env('DEF_LANG_CODE')) class="active" @endif}}><a data-toggle="tab" href="#{{$language->code}}">{{$language->code}} <span class="err-span-{{$language->code}} hidden text-purple"><i class="fas fa-exclamation"></i></span></a></li>
                @endforeach
            </ul>
            <div class="tab-content m-b-0">
                @foreach($languages as $language)
                    <?php
                    $langTitle = 'title_' . $language->code;
                    $langShortDescr = 'short_description_' . $language->code;
                    $langDescription = 'first_text_' . $language->code;
                    $langVisible = 'visible_' . $language->code;
                    $langTitleAdditionalFirst = 'title_additional_first_' . $language->code;
                    $langTitleAdditionalSecound = 'title_additional_secound_' . $language->code;
                    $langTitleAdditionalThird = 'title_additional_third_' . $language->code;
                    $langTitleAdditionalFourth = 'title_additional_fourth_' . $language->code;
                    $langTitleAdditionalFifth = 'title_additional_fifth_' . $language->code;
                    $langTitleAdditionalSixth = 'title_additional_sixth_' . $language->code;
                    $langDescriptionAdditionalFirst = 'text_additional_first_' . $language->code;
                    $langDescriptionAdditionalSecound = 'text_additional_secound_' . $language->code;
                    $langDescriptionAdditionalThird = 'text_additional_third_' . $language->code;
                    $langDescriptionAdditionalFourth = 'text_additional_fourth_' . $language->code;
                    $langDescriptionAdditionalFifth = 'text_additional_fifth_' . $language->code;
                    $langDescriptionAdditionalSixth = 'text_additional_sixth_' . $language->code;
                    $langUrlToShop = 'redirect_url_to_shop_' . $language->code;
                    ?>
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
                        <div class="form-group @if($errors->has($langDescription)) has-error @endif">
                    <textarea name="{{$langDescription}}" class="ckeditor col-xs-12" rows="9">
                        {{ old($langDescription) }}
                    </textarea>
                            @if($errors->has($langDescription))
                                <span class="help-block">{{ trans($errors->first($langDescription)) }}</span>
                            @endif
                        </div>
                        <div class="form-group m-t-10 m-b-60">
                            <label class="control-label col-md-3">Покажи в езикова версия (<span class="text-uppercase">{{$language->code}}</span>):</label>
                            <div class="col-md-6">
                                <label class="switch pull-left">
                                    <input type="checkbox" name="{{$langVisible}}" class="success" data-size="small" checked {{(old($langVisible) ? 'checked' : 'active')}}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="panel-group" id="additional_fields">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 data-toggle="collapse" data-parent="#additional_fields" href="#additional_fields_collapse-{{$language->id}}-1" class="panel-title expand">
                                        <a href="#">Допълнителни полета</a>
                                    </h4>
                                </div>
                                <div id="additional_fields_collapse-{{$language->id}}-1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            @for($f=1; $f<=10; $f++)
                                                @php
                                                    $langAdditionalFieldTitle = 'additional_field_title'.$language->id.$f;
                                                    $langAdditionalFieldAmount = 'additional_field_amount'.$language->id.$f
                                                @endphp
                                                <div>
                                                    <div class="col-md-6">
                                                        <div class="form-group @if($errors->has($langAdditionalFieldTitle)) has-error @endif">
                                                            <label class="control-label p-b-10">Заглавие на поле {{$f}} (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                            <input class="form-control" type="text" name="{{$langAdditionalFieldTitle}}" value="{{ old($langAdditionalFieldTitle) }}">
                                                            @if($errors->has($langAdditionalFieldTitle))
                                                                <span class="help-block">{{ trans($errors->first($langAdditionalFieldTitle)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group @if($errors->has($langAdditionalFieldAmount)) has-error @endif">
                                                            <label class="control-label p-b-10">Стойност на поле {{$f}} (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                            <input class="form-control" type="text" name="{{$langAdditionalFieldAmount}}" value="{{ old($langAdditionalFieldAmount) }}">
                                                            @if($errors->has($langAdditionalFieldAmount))
                                                                <span class="help-block">{{ trans($errors->first($langAdditionalFieldAmount)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="additional-textareas-wrapper">
                            <hr>
                            <h3>Допълнителни текстове</h3>

                            <div class="panel-group" id="accordion-{{$language->id}}">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 data-toggle="collapse" data-parent="#accordion-{{$language->id}}" href="#collapse-{{$language->id}}-1" class="panel-title expand">
                                            <a href="#">Допълнително заглавие и текст 1</a>
                                        </h4>
                                    </div>
                                    <div id="collapse-{{$language->id}}-1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group @if($errors->has($langTitleAdditionalFirst)) has-error @endif">
                                                <label class="control-label p-b-10"><span class="text-purple">* </span>Заглавие / link (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                <input class="form-control" type="text" name="{{$langTitleAdditionalFirst}}" value="{{ old($langTitleAdditionalFirst) }}">
                                                @if($errors->has($langTitleAdditionalFirst))
                                                    <span class="help-block">{{ trans($errors->first($langTitleAdditionalFirst)) }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group @if($errors->has($langDescriptionAdditionalFirst)) has-error @endif">
                            <textarea name="{{$langDescriptionAdditionalFirst}}" class="ckeditor col-xs-12" rows="9">
                                {{ old($langDescriptionAdditionalFirst) }}
                            </textarea>
                                                @if($errors->has($langDescriptionAdditionalFirst))
                                                    <span class="help-block">{{ trans($errors->first($langDescriptionAdditionalFirst)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 data-toggle="collapse" data-parent="#accordion-{{$language->id}}" href="#collapse-{{$language->id}}-2" class="panel-title expand">
                                            <a href="#">Допълнително заглавие и текст 2</a>
                                        </h4>
                                    </div>
                                    <div id="collapse-{{$language->id}}-2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group @if($errors->has($langTitleAdditionalSecound)) has-error @endif">
                                                <label class="control-label p-b-10"><span class="text-purple">* </span>Заглавие / link (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                <input class="form-control" type="text" name="{{$langTitleAdditionalSecound}}" value="{{ old($langTitleAdditionalSecound) }}">
                                                @if($errors->has($langTitleAdditionalSecound))
                                                    <span class="help-block">{{ trans($errors->first($langTitleAdditionalSecound)) }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group @if($errors->has($langDescriptionAdditionalSecound)) has-error @endif">
                    <textarea name="{{$langDescriptionAdditionalSecound}}" class="ckeditor col-xs-12" rows="9">
                        {{ old($langDescriptionAdditionalSecound) }}
                    </textarea>
                                                @if($errors->has($langDescriptionAdditionalSecound))
                                                    <span class="help-block">{{ trans($errors->first($langDescriptionAdditionalSecound)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 data-toggle="collapse" data-parent="#accordion-{{$language->id}}" href="#collapse-{{$language->id}}-3" class="panel-title expand">
                                            <a href="#">Допълнително заглавие и текст 3</a>
                                        </h4>
                                    </div>
                                    <div id="collapse-{{$language->id}}-3" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group @if($errors->has($langTitleAdditionalThird)) has-error @endif">
                                                <label class="control-label p-b-10"><span class="text-purple">* </span>Заглавие / link (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                <input class="form-control" type="text" name="{{$langTitleAdditionalThird}}" value="{{ old($langTitleAdditionalThird) }}">
                                                @if($errors->has($langTitleAdditionalThird))
                                                    <span class="help-block">{{ trans($errors->first($langTitleAdditionalThird)) }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group @if($errors->has($langDescriptionAdditionalThird)) has-error @endif">
            <textarea name="{{$langDescriptionAdditionalThird}}" class="ckeditor col-xs-12" rows="9">
                {{ old($langDescriptionAdditionalThird) }}
            </textarea>
                                                @if($errors->has($langDescriptionAdditionalThird))
                                                    <span class="help-block">{{ trans($errors->first($langDescriptionAdditionalThird)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 data-toggle="collapse" data-parent="#accordion-{{$language->id}}" href="#collapse-{{$language->id}}-4" class="panel-title expand">
                                            <a href="#">Допълнително заглавие и текст 4</a>
                                        </h4>
                                    </div>
                                    <div id="collapse-{{$language->id}}-4" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group @if($errors->has($langTitleAdditionalFourth)) has-error @endif">
                                                <label class="control-label p-b-10"><span class="text-purple">* </span>Заглавие / link (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                <input class="form-control" type="text" name="{{$langTitleAdditionalFourth}}" value="{{ old($langTitleAdditionalFourth) }}">
                                                @if($errors->has($langTitleAdditionalFourth))
                                                    <span class="help-block">{{ trans($errors->first($langTitleAdditionalFourth)) }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group @if($errors->has($langDescriptionAdditionalFourth)) has-error @endif">
            <textarea name="{{$langDescriptionAdditionalFourth}}" class="ckeditor col-xs-12" rows="9">
                {{ old($langDescriptionAdditionalFourth) }}
            </textarea>
                                                @if($errors->has($langDescriptionAdditionalFourth))
                                                    <span class="help-block">{{ trans($errors->first($langDescriptionAdditionalFourth)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 data-toggle="collapse" data-parent="#accordion-{{$language->id}}" href="#collapse-{{$language->id}}-5" class="panel-title expand">
                                            <a href="#">Допълнително заглавие и текст 5</a>
                                        </h4>
                                    </div>
                                    <div id="collapse-{{$language->id}}-5" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group @if($errors->has($langTitleAdditionalFifth)) has-error @endif">
                                                <label class="control-label p-b-10"><span class="text-purple">* </span>Заглавие / link (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                <input class="form-control" type="text" name="{{$langTitleAdditionalFifth}}" value="{{ old($langTitleAdditionalFifth) }}">
                                                @if($errors->has($langTitleAdditionalFifth))
                                                    <span class="help-block">{{ trans($errors->first($langTitleAdditionalFifth)) }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group @if($errors->has($langDescriptionAdditionalFifth)) has-error @endif">
                    <textarea name="{{$langDescriptionAdditionalFifth}}" class="ckeditor col-xs-12" rows="9">
                        {{ old($langDescriptionAdditionalFifth) }}
                    </textarea>
                                                @if($errors->has($langDescriptionAdditionalFifth))
                                                    <span class="help-block">{{ trans($errors->first($langDescriptionAdditionalFifth)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 data-toggle="collapse" data-parent="#accordion-{{$language->id}}" href="#collapse-{{$language->id}}-6" class="panel-title expand">
                                            <a href="#">Допълнително заглавие и текст 6</a>
                                        </h4>
                                    </div>
                                    <div id="collapse-{{$language->id}}-6" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group @if($errors->has($langTitleAdditionalSixth)) has-error @endif">
                                                <label class="control-label p-b-10"><span class="text-purple">* </span>Заглавие / link (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                <input class="form-control" type="text" name="{{$langTitleAdditionalSixth}}" value="{{ old($langTitleAdditionalSixth) }}">
                                                @if($errors->has($langTitleAdditionalSixth))
                                                    <span class="help-block">{{ trans($errors->first($langTitleAdditionalSixth)) }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group @if($errors->has($langDescriptionAdditionalSixth)) has-error @endif">
                    <textarea name="{{$langDescriptionAdditionalSixth}}" class="ckeditor col-xs-12" rows="9">
                        {{ old($langDescriptionAdditionalSixth) }}
                    </textarea>
                                                @if($errors->has($langDescriptionAdditionalSixth))
                                                    <span class="help-block">{{ trans($errors->first($langDescriptionAdditionalSixth)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="form-group @if($errors->has($langUrlToShop)) has-error @endif">
                                            <label class="control-label p-b-10">Връзка към магазина (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                            <input class="form-control" type="text" name="{{$langUrlToShop}}" value="{{ old($langUrlToShop) }}">
                                            @if($errors->has($langUrlToShop))
                                            <span class="help-block">{{ trans($errors->first($langUrlToShop)) }}</span>
                                            @endif
                                        </div> --}}
                    </div>
                @endforeach
            </div>
            <ul class="nav nav-tabs-second">
                @foreach($languages as $language)
                    <li @if($language->code == env('DEF_LANG_CODE')) class="active" @endif><a langcode="{{$language->code}}">{{$language->code}}</a></li>
                @endforeach
            </ul>
            <div class="form form-horizontal">
                <div class="form-body">
                    <div class="form-group insertFileContainer">
                        <label class="control-label col-md-3"><i class="fas fa-file"></i> Вмъкване на файл в едитора:</label>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="file_title" class="form-control input-sm file-title" placeholder="Заглавие на файл">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-4">
                                    <select class="form-control file-select select2" name="file" id="fileName">
                                        <option disabled="" selected="" value=""> избери файл</option>
                                        @foreach($files as $file)
                                            <option>{{$file}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-4">
                                    <button id="fileInsert" data-editor="" folder-path="{{ $filesPathUrl }}" name="file_insert" class="btn btn-sm grey margin-bottom-10"><i class="fa fa-upload"></i> вмъкни файл</button>
                                    <p class="help-block">1. Изберете заглавие на файла</p>
                                    <p class="help-block">2. Изберете файл от падащото меню</p>
                                    <p class="help-block">3. Кликнете в едитора, където искате да се покаже файла.</p>
                                    <p class="help-block">4. Натиснете бутонът "Вмъкни файл".</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group catalogInsert">
                        <label class="control-label col-md-3"><i class="fas fa-book-open"></i> Вмъкване на каталог в едитора:</label>
                        <div class="col-md-9">
                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-4">
                                    <select class="form-control file-select select2" name="file" id="catalogName">
                                        <option disabled="" selected="" value=""> избери каталог</option>
                                        @foreach($mainCatalogs as $mainCatalog)
                                            @php
                                                $catalogTranslation = $mainCatalog->translations()->where('language_id', 1)->first();
                                            @endphp
                                            <option value="{{ $mainCatalog->id }}">{{$catalogTranslation->short_description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-4">
                                    <button id="catalogInsertBtn" data-editor="" folder-path="{{ $filesPathUrl }}" name="file_insert" class="btn btn-sm grey margin-bottom-10"><i class="fa fa-upload"></i> вмъкни каталог</button>
                                    <p class="help-block">1. Изберете каталог от падащото меню</p>
                                    <p class="help-block">2. Кликнете в едитора, където искате да се покаже файла.</p>
                                    <p class="help-block">3. Натиснете бутонът "Вмъкни каталог".</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3">Изображение:</label>
                        <div class="col-md-9">
                            <input type="file" name="image" class="filestyle" data-buttonText="{{trans('administration_messages.browse_file')}}" data-iconName="fas fa-upload" data-buttonName="btn green" data-badge="true">
                            <p class="help-block">{!! $fileRulesInfo !!}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3">Нов продукт:</label>
                        <div class="col-md-6">
                            <label class="switch pull-left">
                                <input type="checkbox" name="is_new_product" class="success" data-size="small" {{(old('is_new_product') ? 'checked' : 'active')}}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Промо продукт:</label>
                        <div class="col-md-6">
                            <label class="switch pull-left">
                                <input type="checkbox" name="is_in_promotion" class="success" data-size="small" {{(old('is_in_promotion') ? 'checked' : 'active')}}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('product_id_code')) has-error @endif">
                        <label class="control-label col-md-3">Продуктов код (ID номер):</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="product_id_code" value="{{ old('product_id_code') }}">
                        </div>
                        @if($errors->has('product_id_code'))
                            <span class="help-block">{{ trans($errors->first('product_id_code')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('model')) has-error @endif">
                        <label class="control-label col-md-3">Модел:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="model" value="{{ old('model') }}">
                        </div>
                        @if($errors->has('model'))
                            <span class="help-block">{{ trans($errors->first('model')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('barcode')) has-error @endif">
                        <label class="control-label col-md-3">Баркод:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="barcode" value="{{ old('barcode') }}">
                        </div>
                        @if($errors->has('barcode'))
                            <span class="help-block">{{ trans($errors->first('barcode')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('units_in_stock')) has-error @endif">
                        <label class="control-label col-md-3">Наличност:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="number" name="units_in_stock" value="{{ old('units_in_stock') ?: 1 }}">
                        </div>
                        @if($errors->has('units_in_stock'))
                            <span class="help-block">{{ trans($errors->first('units_in_stock')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('weight')) has-error @endif">
                        <label class="control-label col-md-3">Тегло (кг):</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="weight" value="{{ old('weight') }}">
                        </div>
                        @if($errors->has('weight'))
                            <span class="help-block">{{ trans($errors->first('weight')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('width')) has-error @endif">
                        <label class="control-label col-md-3">Широчина (см):</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="width" value="{{ old('width') }}">
                        </div>
                        @if($errors->has('width'))
                            <span class="help-block">{{ trans($errors->first('width')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('height')) has-error @endif">
                        <label class="control-label col-md-3">Височина (см):</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="height" value="{{ old('height') }}">
                        </div>
                        @if($errors->has('height'))
                            <span class="help-block">{{ trans($errors->first('height')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('length')) has-error @endif">
                        <label class="control-label col-md-3">Дължина (см):</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="length" value="{{ old('length') }}">
                        </div>
                        @if($errors->has('length'))
                            <span class="help-block">{{ trans($errors->first('length')) }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3"><span class="text-purple">* </span>Марка:</label>
                        <div class="col-md-3">
                            <select class="form-control select2" name="brand_id">
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{($brand->id==old('brand_id')) ? 'selected': ''}}>  {{ $brand->translations->firstWhere('language_id',1)->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('price')) has-error @endif">
                        <label class="control-label col-md-3">Цена без ДДС:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="price" value="{{ old('price') }}">
                        </div>
                        @if($errors->has('price'))
                            <span class="help-block">{{ trans($errors->first('price')) }}</span>
                        @endif
                    </div>
                    {{-- <div class="form-group @if($errors->has('package')) has-error @endif">
                        <label class="control-label col-md-3">Грамаж:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="number" min="0.00" name="package" value="{{ old('package') }}">
                        </div>
                        @if($errors->has('package'))
                        <span class="help-block">{{ trans($errors->first('package')) }}</span>
                        @endif
                    </div> --}}
                    {{-- <div class="form-group">
                        <label class="control-label col-md-3">Мерна единица:</label>
                        <div class="col-md-3">
                            <select class="form-control select2" name="measure_unit">
                                <option value="measure_1">гр.</option>
                                <option value="measure_2">кг.</option>
                                <option value="measure_3">мл.</option>
                                <option value="measure_4">л.</option>
                                <option value="measure_5">бр.</option>
                                <option value="measure_6">кутия</option>
                            </select>
                        </div>
                    </div> --}}
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
                            @if(count($products))
                                @foreach($products as $product)
                                    <tr class="pickPositionTr" data-position="{{$product->position}}">
                                        <td>{{$product->position}}</td>
                                        <td>{{$product->translations->firstWhere('language_id',$defaultLanguage->id)->title}}</td>
                                    </tr>
                                @endforeach
                                <tr class="pickPositionTr" data-position="{{$products->last()->position+1}}">
                                    <td>{{$products->last()->position+1}}</td>
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
