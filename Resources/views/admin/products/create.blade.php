@extends('layouts.admin.app')
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
    @include('shop::admin.products.breadcrumbs')
    @include('admin.notify')

    <form class="my-form" action="{{ route('admin.products.store') }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{old('position')}}">
            <div class="navigation-id-old hidden">{{old('category_id')}}</div>

            @include('admin.partials.on_create.form_actions_top')
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label page-label col-md-3"><span class="text-purple">* </span>@lang('shop::admin.products.attach_to_category'):</label>
                <div class="col-md-4">
                    <label>
                        <select class="form-control select2 inner-page-products-select" name="category_id">
                            @foreach($productCategories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id')===$category->id ? 'selected': '' }}>  {{ $category->title }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
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
                            @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'title_' . $language->code, 'label' => trans('admin.title'), 'required' => true])
                            @include('admin.partials.on_create.form_fields.textarea', ['fieldName' => 'announce_' . $language->code, 'rows' => 3, 'label' => trans('admin.announce'), 'required' => false])
                            @include('admin.partials.on_create.form_fields.textarea', ['fieldName' => 'description_' . $language->code, 'rows' => 9, 'label' => trans('admin.description'), 'required' => false])
                            @include('admin.partials.on_create.show_in_language_visibility_checkbox', ['fieldName' => 'visible_' . $language->code])

                            <div class="panel-group" id="additional_fields">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 data-toggle="collapse" data-parent="#additional_fields" href="#additional_fields_collapse-{{$language->id}}-1" class="panel-title expand">
                                            <a href="#">???????????????????????? ????????????</a>
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
                                                                <label class="control-label p-b-10">???????????????? ???? ???????? {{$f}} (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                                                <input class="form-control" type="text" name="{{$langAdditionalFieldTitle}}" value="{{ old($langAdditionalFieldTitle) }}">
                                                                @if($errors->has($langAdditionalFieldTitle))
                                                                    <span class="help-block">{{ trans($errors->first($langAdditionalFieldTitle)) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group @if($errors->has($langAdditionalFieldAmount)) has-error @endif">
                                                                <label class="control-label p-b-10">???????????????? ???? ???????? {{$f}} (<span class="text-uppercase">{{$language->code}}</span>):</label>
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
                                <h3>{{ __('admin.common.additional_texts') }}</h3>
                                <div class="panel-group" id="accordion-{{$language->id}}">
                                    @for($i=1; $i<7; $i++)
                                        @include('admin.partials.on_create.additional_titles_and_texts', ['language' => $language, 'i' => $i])
                                    @endfor
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
                <ul class="nav nav-tabs-second">
                    @foreach($languages as $language)
                        <li @if($language->code === config('default.app.language.code')) class="active" @endif><a langcode="{{$language->code}}">{{$language->code}}</a></li>
                    @endforeach
                </ul>
                <div class="form form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group insertFileContainer col-md-6">
                                <div class="col-md-12">
                                    <h3 class="m-t-40 m-b-20"><i class="fas fa-file fa-2x"></i> {{ __('admin.files.index') }}</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="m-t-10 m-b-10">{{ __('admin.files.import_file_in_editor') }}:</div>
                                            <label for="file_title" class="m-t-10">{{ __('admin.files.title_of_file') }}</label>
                                            <input type="text" name="file_title" id="file_title" class="form-control file-title" placeholder="???????????????? ???? ????????">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-12">
                                            <label for="fileName">{{ __('admin.files.file') }}</label><select class="form-control file-select select2" name="file" id="fileName">
                                                <option disabled="" selected="" value=""> {{ __('admin.files.choose_file') }}</option>
                                                @foreach($files as $file)
                                                    <option>{{$file}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-12">
                                            <button id="fileInsert" data-editor="" folder-path="{{ $filesPathUrl }}" name="file_insert" class="btn btn-sm grey margin-bottom-10"><i class="fa fa-upload"></i> {{ __('admin.files.import_file') }}</button>
                                            <p class="help-block">{{ __('admin.files.help_step_1') }}</p>
                                            <p class="help-block">{{ __('admin.files.help_step_2') }}</p>
                                            <p class="help-block">{{ __('admin.files.help_step_3') }}</p>
                                            <p class="help-block">{{ __('admin.files.help_step_4') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (array_key_exists('Catalogs', $activeModules) && isset($mainCatalogs))
                                <div class="form-group catalogInsert col-md-6">
                                    <div class="col-md-12">
                                        <h3 class="m-t-40 m-b-20"><i class="fas fa-book-open fa-2x"></i> {{ __('admin.catalogs') }}</h3>
                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-12">
                                                <div class="m-t-10 m-b-10">???????????????? ???? ?????????????? ?? ??????????????:</div>
                                                <label for="catalogName">??????????????</label><select class="form-control file-select select2" name="file" id="catalogName">
                                                    <option disabled="" selected="" value=""> ???????????? ??????????????</option>
                                                    @foreach($mainCatalogs as $mainCatalog)
                                                        <option value="{{ $mainCatalog->id }}">{{$mainCatalog->short_description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-md-12">
                                                <button id="catalogInsertBtn" data-editor="" folder-path="{{ $filesPathUrl }}" name="file_insert" class="btn btn-sm grey margin-bottom-10"><i class="fa fa-upload"></i> ???????????? ??????????????</button>
                                                <p class="help-block">1. ???????????????? ?????????????? ???? ???????????????? ????????</p>
                                                <p class="help-block">2. ???????????????? ?? ??????????????, ???????????? ???????????? ???? ???? ???????????? ??????????.</p>
                                                <p class="help-block">3. ?????????????????? ?????????????? "???????????? ??????????????".</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                @include('admin.partials.on_create.form_fields.upload_file')
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-3">?????? ??????????????:</label>
                                <div class="col-md-6">
                                    <label class="switch pull-left">
                                        <input type="checkbox" name="is_new_product" class="success" data-size="small" {{(old('is_new_product') ? 'checked' : 'active')}}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">?????????? ??????????????:</label>
                                <div class="col-md-6">
                                    <label class="switch pull-left">
                                        <input type="checkbox" name="is_in_promotion" class="success" data-size="small" {{(old('is_in_promotion') ? 'checked' : 'active')}}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 p-r-30">
                                @include('admin.partials.on_create.form_fields.select', ['fieldName' => 'brand_id', 'label' => trans('shop::admin.products.brand'), 'models' => $brands, 'required' => true, 'labelClass' => 'select-label-fix', 'class' => 'select-fix'])
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'price', 'label' => trans('shop::admin.products.price'), 'required' => true, 'class' => 'width-p100'])
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'product_id_code', 'label' => trans('shop::admin.products.sku_number'), 'required' => false])
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'barcode', 'label' => trans('shop::admin.products.barcode'), 'required' => false])
                                @include('admin.partials.on_create.form_fields.input_integer', ['fieldName' => 'units_in_stock', 'label' => trans('shop::admin.products.units_in_stock'), 'required' => true,'fieldNameValue' => old('units_in_stock') ?: 1, 'min' => 1, 'max'=> 999999999999])
                            </div>

                            <div class="col-md-6">
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'weight', 'label' => trans('shop::admin.products.weight'), 'required' => false])
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'width', 'label' => trans('shop::admin.products.width'), 'required' => false])
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'height', 'label' => trans('shop::admin.products.height'), 'required' => false])
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'length', 'label' => trans('shop::admin.products.length'), 'required' => false])
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                @include('admin.partials.on_create.active_checkbox')
                                <hr>
                                @include('admin.partials.on_create.position_in_site_button')
                            </div>
                        </div>
                    </div>
                    @include('admin.partials.on_create.form_actions_bottom')
                </div>
            </div>
        </div>
        @include('admin.partials.modals.positions_on_create', ['parent' => $products])
    </form>
@endsection
