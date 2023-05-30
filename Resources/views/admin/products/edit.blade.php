@extends('layouts.admin.app')
@section('styles')
    <link href="{{ asset('admin/assets/css/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
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
                <div class="col-md-5">
                    <select class="form-control select2 inner-page-products-select" name="category_id">
                        @foreach($productCategories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id')===$category->id || $category->id === $product->category_id) ? 'selected': '' }}>  {{ $category->title }}</option>
                        @endforeach
                    </select>
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
                        @php
                            $productTranslate = is_null($product->translate($language->code)) ? $product : $product->translate($language->code);
                        @endphp
                        <div id="{{$language->code}}" class="tab-pane fade in @if($language->code === config('default.app.language.code')) active @endif">
                            @include('admin.partials.on_edit.form_fields.input_text', ['fieldName' => 'title_' . $language->code, 'label' => trans('admin.title'), 'required' => true, 'model' => $product])
                            @include('admin.partials.on_edit.form_fields.textarea_without_ckeditor', ['fieldName' => 'announce_' . $language->code, 'rows' => 4, 'label' => trans('admin.announce'), 'required' => false, 'model' => $product])
                            @include('admin.partials.on_edit.form_fields.textarea', ['fieldName' => 'description_' . $language->code, 'rows' => 9, 'label' => trans('admin.description'), 'required' => false, 'model' => $product])
                            @include('admin.partials.on_edit.show_in_language_visibility_checkbox', ['fieldName' => 'visible_' . $language->code, 'model' => $product])

                            @include('shop::admin.products.additional_fields', ['language' => $language, 'maxFields' => 10])

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
                        <li @if($language->code === config('default.app.language.code')) class="active" @endif><a langcode="{{$language->code}}">{{$language->code}}</a></li>
                    @endforeach
                </ul>
                @include('admin.partials.on_edit.seo', ['model' => $product->seoFields])
                <div class="form form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            @include('admin.partials.common.import_file')
                            @include('admin.partials.common.import_catalog')
                        </div>

                        <div class="row">
                            <hr>
                            <div class="col-md-6">
                                <h5><b><i>{{ __('shop::admin.products.main_product_mage') }}</i></b></h5>
                                @include('admin.partials.on_edit.form_fields.upload_file', ['model' => $product, 'deleteRoute' => route('admin.products.delete-image', ['id'=>$product->id])])
                            </div>

                            <div class="col-md-6">
                                <h5><b><i>{{ __('shop::admin.products.product_labels') }}</i></b></h5>
                                <div class="form-group">
                                    <label class="control-label col-md-3 text-left">{{ __('shop::admin.products.label_new_product') }}:</label>
                                    <div class="col-md-6">
                                        <label class="switch pull-left">
                                            <input type="checkbox" name="is_new" class="success" data-size="small" {{ old('is_new') ? 'checked' : (($product->is_new) ? 'checked': '') }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ __('shop::admin.products.label_promo_product') }}:</label>
                                    <div class="col-md-6">
                                        <label class="switch pull-left">
                                            <input type="checkbox" name="is_promo" class="success" data-size="small" {{ old('is_promo') ? 'checked' : (($product->is_promo) ? 'checked': '')}}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <hr>
                            <div class="col-md-12">
                                @include('admin.partials.on_edit.form_fields.select', ['fieldName' => 'brand_id', 'label' => trans('shop::admin.products.brand'), 'models' => $brands, 'modelId' => $product->brand_id, 'required' => true, 'labelClass' => 'select-label-fix', 'class' => 'select-fix'])

                            </div>
                        </div>

                        <div class="col-md-6 p-r-30">
                            @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'supplier_delivery_price', 'label' => trans('shop::admin.products.supplier_delivery_price'), 'required' => true, 'class' => 'width-p100', 'model' => $product])
                            @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'price', 'label' => trans('shop::admin.products.price'), 'required' => true, 'class' => 'width-p100', 'model' => $product])
                            @include('admin.partials.on_edit.form_fields.input_integer', ['fieldName' => 'units_in_stock', 'label' => trans('shop::admin.products.units_in_stock'), 'required' => true,'fieldNameValue' => old('units_in_stock') ?: $product->units_in_stock, 'min' => 1, 'max'=> 999999999999])
                            @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'sku', 'label' => trans('shop::admin.products.sku_number'), 'required' => false, 'model' => $product])
                            @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'barcode', 'label' => trans('shop::admin.products.barcode'), 'required' => false, 'model' => $product])
                        </div>

                        <div class="col-md-6">
                            @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'weight', 'label' => trans('shop::admin.products.weight'), 'required' => false, 'model' => $product])
                            @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'width', 'label' => trans('shop::admin.products.width'), 'required' => false, 'model' => $product])
                            @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'height', 'label' => trans('shop::admin.products.height'), 'required' => false, 'model' => $product])
                            @include('admin.partials.on_edit.form_fields.input_text_without_lang', ['fieldName' => 'length', 'label' => trans('shop::admin.products.length'), 'required' => false, 'model' => $product])
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>ДДС ставки</h4>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                {{--                            TODO: VAT categories fields--}}
                            </div>
                            <div class="col-md-6 col-xs-12">

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
