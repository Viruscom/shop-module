@extends('layouts.admin.app')
@section('styles')
    <link href="{{ asset('admin/assets/css/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(".select2").select2({language: "bg"});
        $('.select2').css('min-width', '100%');
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
    @include('admin.partials.common.importers')
    @if($productCategories->isEmpty() || $brands->isEmpty())
        <div class="alert alert-warning">{!! __('shop::admin.products.create_not_allowed_add_product_category') !!}</div>
    @else
        <form id="productForm" class="my-form" action="{{ route('admin.products.store', ['category_id' => Request::segment(5)]) }}" method="POST" data-form-type="store" enctype="multipart/form-data">
            <div class="col-xs-12 p-0">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="position" value="{{old('position')}}">
                <div class="navigation-id-old hidden">{{old('category_id')}}</div>

                @include('admin.partials.on_create.form_actions_top')
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label page-label col-md-3"><span class="text-purple">* </span>@lang('shop::admin.products.attach_to_category'):</label>
                    <div class="col-md-5">
                        <select class="form-control select2" name="category_id" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option value="" data-select2-id="3">@lang('admin.common.please_select')</option>
                            @foreach($productCategories as $index => $category)
                                @include('shop::admin.products.categories_options_integer_value', ['category' => $category, 'depth' => [$index + 1]])
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
                            <div id="{{$language->code}}" class="tab-pane fade in @if($language->code === config('default.app.language.code')) active @endif">
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'title_' . $language->code, 'label' => trans('admin.title'), 'required' => true])
                                @include('admin.partials.on_create.form_fields.textarea_without_ckeditor', ['fieldName' => 'announce_' . $language->code, 'rows' => 4, 'label' => trans('admin.announce'), 'required' => false])
                                @include('admin.partials.on_create.form_fields.textarea', ['fieldName' => 'description_' . $language->code, 'rows' => 9, 'label' => trans('admin.description'), 'required' => false])
                                @include('admin.partials.on_create.show_in_language_visibility_checkbox', ['fieldName' => 'visible_' . $language->code])

                                @include('shop::admin.products.additional_fields', ['language' => $language, 'maxFields' => 10, 'isCreate' => true])

                                {{--                                <div class="additional-textareas-wrapper">--}}
                                {{--                                    <hr>--}}
                                {{--                                    <h3>{{ __('admin.common.additional_texts') }}</h3>--}}
                                {{--                                    <div class="panel-group" id="accordion-{{$language->id}}">--}}
                                {{--                                        @for($i=1; $i<7; $i++)--}}
                                {{--                                            @include('admin.partials.on_create.additional_titles_and_texts', ['language' => $language, 'i' => $i])--}}
                                {{--                                        @endfor--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                            </div>
                        @endforeach
                    </div>
                    <ul class="nav nav-tabs-second">
                        @foreach($languages as $language)
                            <li @if($language->code === config('default.app.language.code')) class="active" @endif><a langcode="{{$language->code}}">{{$language->code}}</a></li>
                        @endforeach
                    </ul>
                    @include('admin.partials.on_create.seo')
                    <div class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <hr>
                                <div class="col-md-6">
                                    <h5><b><i>{{ __('shop::admin.products.main_product_mage') }}</i></b></h5>
                                    @include('admin.partials.on_create.form_fields.upload_file')
                                </div>

                                <div class="col-md-6">
                                    <h5><b><i>{{ __('shop::admin.products.product_labels') }}</i></b></h5>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 text-left">{{ __('shop::admin.products.label_new_product') }}:</label>
                                        <div class="col-md-6">
                                            <label class="switch pull-left">
                                                <input type="checkbox" name="is_new" class="success" data-size="small" {{(old('is_new') ? 'checked' : 'active')}}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label class="control-label col-md-3">{{ __('shop::admin.products.label_promo_product') }}:</label>--}}
                                    {{--                                        <div class="col-md-6">--}}
                                    {{--                                            <label class="switch pull-left">--}}
                                    {{--                                                <input type="checkbox" name="is_promo" class="success" data-size="small" {{(old('is_promo') ? 'checked' : 'active')}}>--}}
                                    {{--                                                <span class="slider"></span>--}}
                                    {{--                                            </label>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}

                                </div>
                            </div>

                            <div class="row">
                                <hr>
                            </div>

                            <div class="col-md-6 p-r-30">
                                @include('admin.partials.on_create.form_fields.select', ['fieldName' => 'brand_id', 'label' => trans('shop::admin.products.brand'), 'models' => $brands, 'required' => true, 'labelClass' => 'select-label-fix', 'class' => 'select-fix'])
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'measure_unit_value', 'label' => __('shop::admin.products.measure_unit_value'), 'required' => true])
                                @include('admin.partials.on_create.form_fields.select', ['fieldName' => 'measure_unit_id', 'label' => trans('shop::admin.products.measure_unit'), 'models' => $measureUnits, 'required' => true, 'labelClass' => 'select-label-fix', 'class' => 'select-fix'])
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'supplier_delivery_price', 'label' => trans('shop::admin.products.supplier_delivery_price'), 'required' => true, 'class' => 'width-p100'])
                                {{--                                @include('admin.partials.on_create.checkbox', ['fieldName' => 'catalog_from_price', 'label' => trans('shop::admin.products.from_price'), 'required' => false])--}}
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'price', 'label' => trans('shop::admin.products.price'), 'required' => true, 'class' => 'width-p100'])

                                {{--                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'barcode', 'label' => trans('shop::admin.products.barcode'), 'required' => false])--}}
                            </div>

                            <div class="col-md-6">
                                @include('admin.partials.on_create.form_fields.input_integer', ['fieldName' => 'units_in_stock', 'label' => trans('shop::admin.products.units_in_stock'), 'required' => true,'fieldNameValue' => old('units_in_stock') ?: 1, 'min' => 1, 'max'=> 999999999999])
                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'sku', 'label' => trans('shop::admin.products.sku_number'), 'required' => false])
                                @if(array_key_exists('YanakSoftApi', $activeModules))
                                    @include('yanaksoftapi::admin.partials.on_create_select', ['fieldName' => 'stk_idnumb', 'label' => trans('shop::admin.yanak_soft_api.choose_product'), 'models' => $yanakProducts, 'required' => true, 'labelClass' => 'select-label-fix', 'class' => 'select-fix', 'withPleaseSelect' => true])
                                @endif
                                {{--                                @include('admin.partials.on_create.checkbox', ['fieldName' => 'catalog_from_discounted_price', 'label' => trans('shop::admin.products.from_price'), 'required' => false])--}}
                                {{--                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'catalog_discounted_price', 'label' => trans('shop::admin.products.catalog_discounted_price'), 'required' => false, 'class' => 'width-p100'])--}}
                                {{--                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'weight', 'label' => trans('shop::admin.products.weight'), 'required' => false])--}}
                                {{--                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'width', 'label' => trans('shop::admin.products.width'), 'required' => false])--}}
                                {{--                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'height', 'label' => trans('shop::admin.products.height'), 'required' => false])--}}
                                {{--                                @include('admin.partials.on_create.form_fields.input_text', ['fieldName' => 'length', 'label' => trans('shop::admin.products.length'), 'required' => false])--}}
                            </div>

                            @if(array_key_exists('RetailObjectsRestourant', $activeModules))
                                @include('retailobjectsrestourant::admin.product_additives.additives_list')
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="m-t-40 m-b-20"><i class="fas fa-tachometer-alt fa-2x"></i> <span>ДДС ставки</span></h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="alert alert-warning"><strong>Внимание!</strong> ДДС ставките определят продукта в коя ддс категория ще попадне за всяка държава, в която продавате.</div>
                                </div>
                                @foreach($saleCountries as $saleCountry)
                                    <div class="col-md-4 col-xs-6">
                                        <h4>Държава: <strong>{{ $saleCountry->country->name }}</strong></h4>
                                        <p>
                                            <select class="form-control @error('saleCountries['.$saleCountry->country->id.'][vat_category]') is-invalid @enderror" name="saleCountries[{{$saleCountry->country->id}}][vat_category]" required>
                                                @foreach($saleCountry->country->vat_categories as $category)
                                                    <option value="{{$category->id}}" {{old('saleCountries['.$saleCountry->country->id.'][vat_category]')==$category->id ? 'selected':''}}>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    </div>
                                @endforeach
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
    @endif
@endsection
