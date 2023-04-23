@extends('layouts.admin.app')
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
    <form class="my-form" action="{{ route('admin.products.update', ['id' => $product->id]) }}" method="POST" data-form-type="update" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{(old('position')) ?: $product->position}}">
            <div class="navigation-id-old hidden">{{old('category_id')}}</div>
            <div class="navigation-id-current hidden">{{$product->category_id}}</div>

            @include('admin.partials.on_edit.form_actions_top')
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label page-label col-md-3"><span class="text-purple">* </span>@lang('shop::admin.products.attach_to_category'):</label>
                <div class="col-md-4">
                    <label>
                        <select class="form-control select2 inner-page-products-select" name="category_id">
                            @foreach($productCategories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id')===$category->id || $category->id === $product->category_id) ? 'selected': '' }}>  {{ $category->title }}</option>
                            @endforeach
                        </select>
                    </label>
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
                        <li @if($language->code === config('default.app.language.code')) class="active" @endif><a data-toggle="tab" href="#{{$language->code}}">{{$language->code}} <span class="err-span-{{$language->code}} hidden text-purple"><i class="fas fa-exclamation"></i></span></a></li>
                    @endforeach
                </ul>
                <div class="tab-content m-b-0">
                    @foreach($languages as $language)
                        <div id="{{$language->code}}" class="tab-pane fade in @if($language->code === config('default.app.language.code')) active @endif">
                            @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'title_' . $language->code, 'label' => trans('admin.title'), 'required' => true, 'model' => $product])
                            @include('admin.partials.on_edit.form_fields.textarea', ['fieldName' => 'announce_' . $language->code, 'rows' => 3, 'label' => trans('admin.announce'), 'required' => false, 'model' => $product])
                            @include('admin.partials.on_edit.form_fields.textarea', ['fieldName' => 'description_' . $language->code, 'rows' => 9, 'label' => trans('admin.description'), 'required' => false, 'model' => $product])
                            @include('admin.partials.on_edit.show_in_language_visibility_checkbox', ['fieldName' => 'visible_' . $language->code, 'model' => $product])

                            <div class="panel-group" id="additional_fields">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 data-toggle="collapse" data-parent="#additional_fields" href="#additional_fields_collapse-{{$language->id}}-1" class="panel-title expand">
                                            <a href="#">Допълнителни полета</a>
                                        </h4>
                                    </div>
                                    {{--                                <div id="additional_fields_collapse-{{$language->id}}-1" class="panel-collapse collapse">--}}
                                    {{--                                    <div class="panel-body">--}}
                                    {{--                                        <div class="row">--}}
                                    {{--                                            @for($f=1; $f<=10; $f++)--}}
                                    {{--                                                @php--}}
                                    {{--                                                    $langAdditionalFieldTitle = 'additional_field_title'.$language->id.$f;--}}
                                    {{--                                                    $langAdditionalFieldAmount = 'additional_field_amount'.$language->id.$f;--}}
                                    {{--                                                    $aditionalField = $product->aditional_fields()->where('field_id', $f)->where('language_id', $language->id)->first()--}}
                                    {{--                                                @endphp--}}
                                    {{--                                                <div>--}}
                                    {{--                                                    <div class="col-md-6">--}}
                                    {{--                                                        <div class="form-group @if($errors->has($langAdditionalFieldTitle)) has-error @endif">--}}
                                    {{--                                                            <label class="control-label p-b-10">Заглавие на поле {{$f}} (<span class="text-uppercase">{{$language->code}}</span>):</label>--}}
                                    {{--                                                            <input class="form-control" type="text" name="{{$langAdditionalFieldTitle}}" value="{{ old($langAdditionalFieldTitle) ? old($langAdditionalFieldTitle) : (!is_null($aditionalField) ? $aditionalField->name : '') }}">--}}
                                    {{--                                                            @if($errors->has($langAdditionalFieldTitle))--}}
                                    {{--                                                                <span class="help-block">{{ trans($errors->first($langAdditionalFieldTitle)) }}</span>--}}
                                    {{--                                                            @endif--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="col-md-6">--}}
                                    {{--                                                        <div class="form-group @if($errors->has($langAdditionalFieldAmount)) has-error @endif">--}}
                                    {{--                                                            <label class="control-label p-b-10">Стойност на поле {{$f}} (<span class="text-uppercase">{{$language->code}}</span>):</label>--}}
                                    {{--                                                            <input class="form-control" type="text" name="{{$langAdditionalFieldAmount}}" value="{{ old($langAdditionalFieldTitle) ? old($langAdditionalFieldTitle) : (!is_null($aditionalField) ? $aditionalField->text : '') }}">--}}
                                    {{--                                                            @if($errors->has($langAdditionalFieldAmount))--}}
                                    {{--                                                                <span class="help-block">{{ trans($errors->first($langAdditionalFieldAmount)) }}</span>--}}
                                    {{--                                                            @endif--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            @endfor--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    {{--                                </div>--}}
                                </div>
                            </div>

                            <div class="additional-textareas-wrapper">
                                <hr>
                                <h3>{{ __('admin.common.additional_texts') }}</h3>
                                <div class="panel-group" id="accordion-{{$language->id}}">
                                    @for($i=1; $i<7; $i++)
                                        @include('admin.partials.on_edit.additional_title_and_text', ['model' => $product, 'language' => $language, 'i' => $i])
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <ul class="nav nav-tabs-second">
                    @foreach($languages as $language)
                        <li @if($language->code == env('DEF_LANG_CODE')) class="active" @endif><a langcode="{{$language->code}}">{{$language->code}}</a></li>
                    @endforeach
                </ul>
                @include('admin.partials.on_edit.seo', ['model' => $product->seoFields])
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
                        @if (array_key_exists('Catalogs', $activeModules) && isset($mainCatalogs))
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
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                @include('admin.partials.on_edit.form_fields.upload_file', ['model' => $product, 'deleteRoute' => route('admin.products.delete-image', ['id'=>$product->id])])
                                <hr>
                            </div>
                        </div>

                        <div class="row">
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
                        </div>

                        <div class="row">
                            <div class="col-md-6 p-r-30">
                                @include('admin.partials.on_edit.form_fields.select', ['fieldName' => 'brand_id', 'label' => trans('shop::admin.products.brand'), 'models' => $brands, 'modelId' => $product->brand_id, 'required' => true, 'labelClass' => 'select-label-fix', 'class' => 'select-fix'])
                                @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'price', 'label' => trans('shop::admin.products.price'), 'required' => true, 'class' => 'width-p100', 'model' => $product])
                                @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'product_id_code', 'label' => trans('shop::admin.products.sku_number'), 'required' => false, 'model' => $product])
                                @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'barcode', 'label' => trans('shop::admin.products.barcode'), 'required' => false, 'model' => $product])
                                @include('admin.partials.on_edit.form_fields.input_integer', ['fieldName' => 'units_in_stock', 'label' => trans('shop::admin.products.units_in_stock'), 'required' => true,'fieldNameValue' => old('units_in_stock') ?: $product->units_in_stock, 'min' => 1, 'max'=> 999999999999])
                            </div>

                            <div class="col-md-6">
                                @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'weight', 'label' => trans('shop::admin.products.weight'), 'required' => false, 'model' => $product])
                                @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'width', 'label' => trans('shop::admin.products.width'), 'required' => false, 'model' => $product])
                                @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'height', 'label' => trans('shop::admin.products.height'), 'required' => false, 'model' => $product])
                                @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'length', 'label' => trans('shop::admin.products.length'), 'required' => false, 'model' => $product])
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                @include('admin.partials.on_edit.active_checkbox', ['model' => $product])
                                <hr>
                                @include('admin.partials.on_edit.position_in_site_button', ['model' => $product, 'models' => $products])
                            </div>
                        </div>
                    </div>
                    @include('admin.partials.on_edit.form_actions_bottom')
                </div>
            </div>
        </div>
        @include('admin.partials.modals.positions_on_edit', ['parent' => $products, 'model'=>$product])
    </form>
@endsection
