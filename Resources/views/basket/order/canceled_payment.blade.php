@php use App\Helpers\WebsiteHelper; @endphp@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    <section class="section-top-container section-top-container-cart">
        @include('shop::front.partials.choose_address_head')
        @include('shop::basket.breadcrumbs')
    </section>
    <div class="page-wrapper">
        <div class="cart-wrapper">
            <div class="shell">
                <div class="cart-content">
                    <h3 class="title-main title-border title-alt">Поръчката не е платена!</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
