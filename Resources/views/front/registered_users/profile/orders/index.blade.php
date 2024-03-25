@php use Carbon\Carbon; @endphp@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    @include('shop::front.partials.registered_user_head')
    <div class="page-wrapper">
        <section class="settings-page">
            <div class="shell">
                @include('shop::front.registered_users.profile.partials.menu')

                <div class="page-content-shop">
                    <h3 class="page-title">@lang('shop::front.registered_user_profile.orders')</h3>

                    <div class="table-wrapper">
                        <div class="table-holder">
                            <div class="table-orders">
                                <table>
                                    <thead>
                                    <th>{{ __('shop::front.registered_user_profile.order') }}</th>
                                    <th>{{ __('shop::front.registered_user_profile.date') }}</th>
                                    <th>{{ __('shop::front.registered_user_profile.recipient') }}</th>
                                    <th class="align-right">{{ __('shop::front.registered_user_profile.total') }}</th>
                                    <th>{{ __('shop::front.registered_user_profile.status') }}</th>
                                    <th class="align-right"></th>
                                    </thead>

                                    <tbody>
                                    @forelse($registeredUser->orders as $order)
                                        <tr>
                                            <td><strong>{{ $order->id }}</strong></td>
                                            <td>{{ Carbon::parse($order->created_at)->format('d.m.Y') }}</td>
                                            <td>{{ $order->first_name . ' ' . $order->last_name }}</td>
                                            <td class="align-right"><strong>{{ $order->totalEndDiscountedPrice() }} @lang('front.currency')</strong></td>
                                            <td>{{ $order->getReadableShipmentStatus() }}</td>
                                            <td class="align-right">
                                                <a href="{{ route('shop.registered_user.account.orders.show', ['languageSlug' => $languageSlug, 'order_hash' => encrypt($order->id)]) }}"><strong>{{ __('shop::front.registered_user_profile.details') }}</strong></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="alert alert-danger">@lang('admin.no-records')</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
