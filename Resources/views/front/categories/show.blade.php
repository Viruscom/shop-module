@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/plugins/cubeportfolio/css/cubeportfolio.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/plugins/cubeportfolio/css/remove_padding.css') }}">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('/front/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/front/plugins/cubeportfolio/js/main.js') }}"></script>
@endsection

@section('content')
    <section class="section-top-container">
        @include('shop::front.partials.choose_address_head')
        @include('front.partials.breadcrumbs')

        <h3 class="title" data-aos="fade-up" data-aos-delay="100">{{ $viewArray['currentModel']->title }}</h3>

        <x-shop::front.productcategories.categorypricker :categories="$categories" language-slug="$languageSlug"/>

        @if(!is_null($viewArray['currentModel']->parent->main_category))
            <div class="top-nav-pages hover-images">
                <a href="{{ $viewArray['currentModel']->parent->mainCategory->getUrl($languageSlug) }}" data-aos="fade-up" data-aos-delay="100">
                    <img src="{{ asset('front/assets/icons/arrow.svg') }}" alt="">

                    <img src="{{ asset('front/assets/icons/arrow-red.svg') }}" alt="">

                    {{ __('admin.common.back') }}
                </a>
            </div>
        @endif
    </section>

    @if($viewArray['currentModel']->announce != '')
        <section class="section-text">
            <div class="shell">
                <div class="section-content">
                    <p data-aos="fade-up" data-aos-delay="150">{!! $viewArray['currentModel']->announce !!}</p>
                </div>
            </div>
        </section>
    @endif

    @include('shop::front.categories.list_products', ['products' => $viewArray['currentModel']->parent->getActiveProducts])

    <section class="section-bottom">
        <div class="shell">
            <div class="section-content">
                <img src="{{ asset('front/assets/icons/bottom-icon-2.svg') }}" alt="" data-aos="fade-up" data-aos-delay="50">

                <p data-aos="fade-up" data-aos-delay="150">{!! $viewArray['currentModel']->description !!}</p>
            </div>
        </div>
    </section>
@endsection
