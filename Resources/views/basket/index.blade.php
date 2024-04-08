@php use App\Helpers\WebsiteHelper; @endphp@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    <section class="section-top-container section-top-container-cart">
        @include('shop::front.partials.choose_address_head')
        @include('shop::basket.breadcrumbs')
    </section>
    <div class="page-wrapper">

        <div class="cart-wrapper">
            <div class="shell">
                @include('front.notify')

                <x-shop::front.basket.step_one.basket_step_one_index :basket="$basket"/>
            </div>
        </div>
    </div>
@endsection
