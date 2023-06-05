@extends('layouts.admin.app')
@section('styles')
    <link href="{{ asset('admin/assets/css/select2.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(".select2").select2({language: "bg"});
        });
    </script>
@endsection
@section('content')
    @include('shop::admin.products.breadcrumbs')
    @include('admin.notify')
    <div class="col-md-12 m-b-10">
        <div class="form-group">
            <label class="control-label page-label col-md-3"><span class="text-purple">* </span>Категория:</label>
            <div class="col-md-4">
                <select class="form-control select2 products-select" name="category_id">
                    <option value="">@lang('admin.common.please_select')</option>
                    @foreach($categories as $category)
                        <option value="{{ route('admin.products.index_by_category', ['category_id' => $category->id]) }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endsection
