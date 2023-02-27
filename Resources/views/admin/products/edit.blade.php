@extends('layouts.app')
@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>


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
        <form class="my-form" action="{{ url('/admin/products/'.$product->id.'/update') }}" method="POST" data-form-type="update" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{(old('position')) ? old('position') : $product->position}}">
            <div class="navigation-id-old hidden">{{old('product_category_id')}}</div>
            <div class="navigation-id-current hidden">{{$product->product_category_id}}</div>

            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ url('/admin/products') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label page-label col-md-3"><span class="text-purple">* </span>Към категория:</label>
            <div class="col-md-4">
                <select class="form-control select2 inner-page-products-select" name="product_category_id">
                    @foreach($categories as $categ)
                        <optgroup label="{{ $categ->translations->firstWhere('language_id',1)->title}}">
                            @foreach($categ->product_categories as $categProduct)
                                <option value="{{ $categProduct->id }}" {{($categProduct->id==$product->id) ? 'selected': ''}}>  {{ $categProduct->translations->firstWhere('language_id',1)->title}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning"><strong>Внимание! </strong>Промяната на загланието (името) или на активността (видимостта) на продукта ще се отрази в sitemap-a на сайта и може да доведе до промени в индексирането на Вашия сайт от търсачките.</div>
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
                    <?php $langTitle = 'title_' . $language->code;
                    $langShortDescr = 'short_description_' . $language->code;
                    $langDescription = 'first_text_' . $language->code;
                    $langVisible = 'visible_' . $language->code;
                    $langUrlToShop = 'redirect_url_to_shop_' . $language->code;
                    $productTranslation = (is_null($product->translations->where('language_id', $language->id)->first())) ? null : $product->translations->where('language_id', $language->id)->first();
                    ?>
                    <div id="{{$language->code}}" class="tab-pane fade in @if($language->code == env('DEF_LANG_CODE')) active @endif}}">
                        <div class="form-group @if($errors->has($langTitle)) has-error @endif">
                            <label class="control-label p-b-10"><span class="text-purple">* </span>Заглавие / link (<span class="text-uppercase">{{$language->code}}</span>):</label>
                            <input class="form-control" type="text" name="{{$langTitle}}" value="{{ old($langTitle) ? old($langTitle) : (!is_null($productTranslation) ? $productTranslation->title : '') }}">
                            @if($errors->has($langTitle))
                                <span class="help-block">{{ trans($errors->first($langTitle)) }}</span>
                            @endif
                        </div>
                        <div class="form-group @if($errors->has($langShortDescr)) has-error @endif">
                            <label class="control-label p-b-10">Кратко описание (<span class="text-uppercase">{{$language->code}}</span>):</label>
                            <textarea name="{{$langShortDescr}}" class="form-control" rows="3">{{ old($langShortDescr) ? old($langShortDescr) : (!is_null($productTranslation) ? $productTranslation->short_description : '') }}</textarea>
                            @if($errors->has($langShortDescr))
                                <span class="help-block">{{ trans($errors->first($langShortDescr)) }}</span>
                            @endif
                        </div>
                        <div class="form-group @if($errors->has($langDescription)) has-error @endif">
                    <textarea name="{{$langDescription}}" class="ckeditor col-xs-12" rows="9">
                        {{ old($langDescription) ? old($langDescription) : (!is_null($productTranslation) ? $productTranslation->first_text : '') }}
                    </textarea>
                            @if($errors->has($langDescription))
                                <span class="help-block">{{ trans($errors->first($langDescription)) }}</span>
                            @endif
                        </div>
                        <div class="form-group m-t-10 m-b-60">
                            <label class="control-label col-md-3">Покажи в езикова версия (<span class="text-uppercase">{{$language->code}}</span>):</label>
                            <div class="col-md-6">
                                <label class="switch pull-left">
                                    <input type="checkbox" name="{{$langVisible}}" class="success" data-size="small" {{ old($langVisible) ? 'checked' : ((!is_null($productTranslation) && $productTranslation->visible) ? 'checked': 'active') }}>
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
                                                    $langAdditionalFieldAmount = 'additional_field_amount'.$language->id.$f;
                                                    $aditionalField = $product->aditional_fields()->where('field_id', $f)->where('language_id', $language->id)->first()
                                                @endphp
                                                <div>
                                                    <div class="col-md-6">
                                                        <div class="form-group @if($errors->has($langAdditionalFieldTitle)) has-error @endif">
                                                            <label class="control-label p-b-10">Заглавие на поле {{$f}} (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                            <input class="form-control" type="text" name="{{$langAdditionalFieldTitle}}" value="{{ old($langAdditionalFieldTitle) ? old($langAdditionalFieldTitle) : (!is_null($aditionalField) ? $aditionalField->name : '') }}">
                                                            @if($errors->has($langAdditionalFieldTitle))
                                                                <span class="help-block">{{ trans($errors->first($langAdditionalFieldTitle)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group @if($errors->has($langAdditionalFieldAmount)) has-error @endif">
                                                            <label class="control-label p-b-10">Стойност на поле {{$f}} (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                            <input class="form-control" type="text" name="{{$langAdditionalFieldAmount}}" value="{{ old($langAdditionalFieldTitle) ? old($langAdditionalFieldTitle) : (!is_null($aditionalField) ? $aditionalField->text : '') }}">
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
                                @for($i=1; $i<7; $i++)
                                    @include('admin.products.additional_text', ['language' => $language, 'i' => $i])
                                @endfor
                            </div>
                        </div>
                        {{-- <div class="form-group @if($errors->has($langUrlToShop)) has-error @endif">
                            <label class="control-label p-b-10">Връзка към магазина (<span class="text-uppercase">{{$language->code}}</span>):</label>
                            <input class="form-control" type="text" name="{{$langUrlToShop}}" value="{{ (old($langUrlToShop)) ? old($langUrlToShop) : (!is_null($productTranslation)) ? $productTranslation->redirect_url_to_shop : '' }}">
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
                            <div>
                                @if ($product->filename != '' && file_exists($product->fullImageFilePath()))
                                    <div class="overlay-delete-img hidden">
                                        <a href="{{ url('/admin/products/'.$product->id.'/img/delete') }}" class="del-link"><i class="fas fa-times"></i>
                                            <p>Изтрий</p></a>
                                    </div>
                                    <img class="thumbnail content-box1 has-img img-responsive" src="{{ $product->fullImageFilePathUrl() }}" width="300"/>
                                @else
                                    <img class="thumbnail img-responsive" src="{{ asset('/admin/assets/system_images/product_img.png') }}" width="300"/>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3">Нов продукт:</label>
                        <div class="col-md-6">
                            <label class="switch pull-left">
                                <input type="checkbox" name="is_new_product" class="success" data-size="small" {{ old('is_new_product') ? 'checked' : (($product->is_new_product) ? 'checked': '') }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Промо продукт:</label>
                        <div class="col-md-6">
                            <label class="switch pull-left">
                                <input type="checkbox" name="is_in_promotion" class="success" data-size="small" {{ old('is_in_promotion') ? 'checked' : (($product->is_in_promotion) ? 'checked': '')}}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('product_id_code')) has-error @endif">
                        <label class="control-label col-md-3">Продуктов код (SKU номер):</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="product_id_code" value="{{ old('product_id_code') ? old('product_id_code') : (!is_null($product) ? $product->product_id_code : '') }}">
                        </div>
                        @if($errors->has('product_id_code'))
                            <span class="help-block">{{ trans($errors->first('product_id_code')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('model')) has-error @endif">
                        <label class="control-label col-md-3">Модел:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="model" value="{{ old('model') ? old('model') : (!is_null($product) ? $product->model : '') }}">
                        </div>
                        @if($errors->has('model'))
                            <span class="help-block">{{ trans($errors->first('model')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('barcode')) has-error @endif">
                        <label class="control-label col-md-3">Баркод:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="barcode" value="{{ old('barcode') ? old('barcode') : (!is_null($product) ? $product->barcode : '') }}">
                        </div>
                        @if($errors->has('barcode'))
                            <span class="help-block">{{ trans($errors->first('barcode')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('units_in_stock')) has-error @endif">
                        <label class="control-label col-md-3">Наличност:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="number" name="units_in_stock" value="{{ old('units_in_stock') ? old('units_in_stock') : (!is_null($product) ? $product->units_in_stock : '') }}">
                        </div>
                        @if($errors->has('units_in_stock'))
                            <span class="help-block">{{ trans($errors->first('units_in_stock')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('weight')) has-error @endif">
                        <label class="control-label col-md-3">Тегло (кг):</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="weight" value="{{ old('weight') ? old('weight') : (!is_null($product) ? $product->weight : '') }}">
                        </div>
                        @if($errors->has('weight'))
                            <span class="help-block">{{ trans($errors->first('weight')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('width')) has-error @endif">
                        <label class="control-label col-md-3">Широчина (см):</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="width" value="{{ old('width') ? old('width') : (!is_null($product) ? $product->width : '') }}">
                        </div>
                        @if($errors->has('width'))
                            <span class="help-block">{{ trans($errors->first('width')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('height')) has-error @endif">
                        <label class="control-label col-md-3">Височина (см):</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="height" value="{{ old('height') ? old('height') : (!is_null($product) ? $product->height : '') }}">
                        </div>
                        @if($errors->has('height'))
                            <span class="help-block">{{ trans($errors->first('height')) }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('length')) has-error @endif">
                        <label class="control-label col-md-3">Дължина (см):</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="length" value="{{ old('length') ? old('length') : (!is_null($product) ? $product->length : '') }}">
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
                                    <option value="{{ $brand->id }}" {{($product->brand_id==$brand->id || ($brand->id==old('brand_id'))) ? 'selected': ''}}>  {{ $brand->translations->firstWhere('language_id',1)->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('price')) has-error @endif">
                        <label class="control-label col-md-3">Цена без ДДС:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="price" value="{{ old('price') ? old('price') : (!is_null($product) ? $product->price : '') }}">
                        </div>
                        @if($errors->has('price'))
                            <span class="help-block">{{ trans($errors->first('price')) }}</span>
                        @endif
                    </div>
                    {{-- <div class="form-group @if($errors->has('package')) has-error @endif">
                        <label class="control-label col-md-3">Грамаж:</label>
                        <div class="col-md-3">
                            <input class="form-control" type="number" min="0.00" name="package" value="{{ (old('package')) ? old('package') : (!is_null($productTranslation)) ? $productTranslation->package : '' }}">
                        </div>
                        @if($errors->has('package'))
                        <span class="help-block">{{ trans($errors->first('package')) }}</span>
                        @endif
                    </div> --}}
                    {{-- <div class="form-group">
                        <label class="control-label page-label col-md-3"><span class="text-purple">* </span>Мерна единица:</label>
                        <div class="col-md-4">
                            <select class="form-control select2" name="measure_unit">
                                <option value="measure_1" {{($product->measure_unit == old('measure_unit') || $product->measure_unit == 'measure_1') ? 'selected': ''}}>гр.</option>
                                <option value="measure_2" {{($product->measure_unit == old('measure_unit') || $product->measure_unit == 'measure_2') ? 'selected': ''}}>кг.</option>
                                <option value="measure_3" {{($product->measure_unit == old('measure_unit') || $product->measure_unit == 'measure_3') ? 'selected': ''}}>мл.</option>
                                <option value="measure_4" {{($product->measure_unit == old('measure_unit') || $product->measure_unit == 'measure_4') ? 'selected': ''}}>л.</option>
                                <option value="measure_5" {{($product->measure_unit == old('measure_unit') || $product->measure_unit == 'measure_5') ? 'selected': ''}}>бр.</option>
                                <option value="measure_6" {{($product->measure_unit == old('measure_unit') || $product->measure_unit == 'measure_6') ? 'selected': ''}}>кутия</option>
                            </select>
                        </div>
                    </div> --}}
                    {{-- <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3">Партньори предлагащи продукта:</label>
                        <div class="col-md-6">
                            <label class="switch pull-left">
                              <select class="selectpicker" multiple data-live-search="true" name="partners">
                                  <option>Mustard</option>
                                  <option>Ketchup</option>
                                  <option>Relish</option>
                              </select>
                          </label>
                      </div>
                    </div> --}}
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3">Активен (видим) в сайта:</label>
                        <div class="col-md-6">
                            <label class="switch pull-left">
                                <input type="checkbox" name="active" class="success" data-size="small" {{(old('active') ? 'checked' : (($product->active) ? 'checked': ''))}}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-md-3">Позиция в сайта:</label>
                        <div class="col-md-6">
                            <p class="position-label">№ {{ $product->position }}</p>
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
                            @if(count($products))
                                @foreach($products as $prod)
                                    <tr class="pickPositionTr" data-position="{{$prod->position}}">
                                        <td>{{$prod->position}}</td>
                                        <td>{{$prod->translations->firstWhere('language_id',$defaultLanguage->id)->title}}</td>
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
                                    <a role="button" class="btn back-btn margin-bottom-10 cancel-position-change" current-position="{{ $product->position }}" data-dismiss="modal"><i class="fa fa-reply"></i> назад</a>
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
