@extends('layouts.front.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/plugins/cubeportfolio/css/cubeportfolio.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/front/plugins/cubeportfolio/css/remove_padding.css') }}">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('/front/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/front/plugins/cubeportfolio/js/main.js') }}"></script>
@endsection
@section('content')
    @include('front.partials.inner_header')
    @include('front.partials.breadcrumbs')

    <section class="section-article">
        <article class="article-single">
            <div class="shell">
                <div class="article-head">
                    <div class="article-info">
                        <!-- //<p class="brand"></p> -->

                        <p class="path" data-aos="fade-up" data-aos-delay="50"><a href="" class="link-more link-more-alt">About Saffron</a></p>
                    </div>

                    <h3 class="article-title" data-aos="fade-up" data-aos-delay="150">{{ $viewArray['currentModel']->title }}</h3>
                </div>

                <div class="article-body" data-aos="fade-up" data-aos-delay="200">
                    <div class="article-inner">
                        {!! $viewArray['currentModel']->parent->translate($languageSlug)->description !!}

                        @include('front.partials.content.after_description_modules', ['model' => $viewArray['currentModel']])
                        @include('front.partials.content.brand_additional_titles_and_texts', ['model' => $viewArray['currentModel'], 'translation' => $viewArray['currentModel']->parent->translate($languageSlug)])
                    </div>

                </div>
            </div>
        </article>

        <x-inner-gallery :current-model="$viewArray['currentModel']"/>
    </section>
@endsection
