@extends('layouts.app')
@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script>
        $(".select2").select2({language: "bg"});
    </script>
@endsection
@section('content')
    <div class="alert alert-warning"><strong>Внимание!</strong> За да добавите или разгледате продукт е необходимо да изберете категория.</div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label page-label col-md-3"><span class="text-purple">* </span>Изберете категория:</label>
            <div class="col-md-4">
                <select class="form-control select2 products-select" name="navigations">
                    <option value="" selected>--- Моля, изберете ---</option>
                    @foreach($categories as $category)
                        <optgroup label="{{ $category->translations->firstWhere('language_id',1)->title}}">
                            @foreach($category->product_categories as $productCategory)
                                <option value="{{ $productCategory->id }}">  {{ $productCategory->translations->firstWhere('language_id',1)->title}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endsection
