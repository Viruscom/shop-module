@extends('layouts.admin.app')
@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/plugins/foundation-datepicker/datepicker.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/foundation-datepicker/datepicker.js') }}"></script>
    <script>
        $(".select2").select2({language: "bg"});
    </script>
@endsection
@section('content')
    @include('shop::admin.adboxes_products.breadcrumbs')
    @include('admin.notify')
    <form class="my-form" action="{{ route('admin.product-adboxes.update', ['id' => $adBox->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{(old('position')) ? old('position') : $adBox->position}}">

            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    @if ($adBox->type != $waitingAction)
                        <a href="{{ route('admin.product-adboxes.return-to-waiting', ['id'=>$adBox->id]) }}" role="button" class="btn btn-lg btn yellow margin-bottom-10 tooltips" style="padding: 8px 10px;" data-toggle="tooltip" data-placement="left" data-original-title="Върни карето в изчакващи"><img src="{{ asset('admin/assets/images/back_to_wait.svg') }}" width="23px"></a>
                    @endif
                    <a href="{{route('admin.product-adboxes.index') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
        </div>
        @if($adBox->type == $waitingAction)
            <input type="radio" name="type" class="adbox-type hidden" value="1" checked>
        @endif
        <div class="row">
            <div class="col-md-12">
                <h4>{{ __('shop::admin.product_adboxes.edit') }}: {{ $adBox->product->title }}</h4><br>
            </div>
            <div class="col-sm-12 col-xs-12">
                <ul class="nav nav-tabs">
                    @foreach($languages as $language)
                        <li @if($language->code === config('default.app.language.code')) class="active" @endif><a data-toggle="tab" href="#{{$language->code}}">{{$language->code}} <span class="err-span-{{$language->code}} hidden text-purple"><i class="fas fa-exclamation"></i></span></a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($languages as $language)
                        <div id="{{$language->code}}" class="tab-pane fade in @if($language->code === config('default.app.language.code')) active @endif">
                            <div class="row">
                                <div class="col-md-12">
                                    @include('admin.partials.on_edit.show_in_language_visibility_checkbox', ['model'=> $adBox, 'fieldName' => 'visible_' . $language->code])
                                </div>
                            </div>
                        </div>

                </div>
                @endforeach
            </div>

            <div class="col-sm-12 col-xs-12">
                @include('admin.partials.on_edit.form_actions_bottom')
            </div>
        </div>
    </form>
@endsection
