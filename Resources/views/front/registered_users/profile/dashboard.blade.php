@php use Carbon\Carbon; @endphp@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    @include('shop::front.partials.registered_user_head')
    <div class="page-wrapper">
        {{--        @include('shop::front.registered_users.profile.breadcrumbs')--}}
        @include('front.notify')
        <section class="settings-page">
            <div class="shell">
                @include('shop::front.registered_users.profile.partials.menu')
                <div class="page-content-shop">
                    <h3 class="page-title">{{ __('shop::front.registered_user_profile.my_account') }}</h3>

                    <div class="box-cols">
                        <div class="col col-1of2">
                            <h5><span>{{ __('shop::front.registered_user_profile.hello') }},</span> {{ $registeredUser->first_name }} {{ $registeredUser->last_name }}!</h5>
                            @if($registeredUser->email != '')
                                <p><span>{{ __('shop::front.registered_user_profile.email') }}:</span> {{ $registeredUser->email }} </p>
                            @endif
                            @if($registeredUser->phone != '')
                                <p><span>{{ __('shop::front.registered_user_profile.phone') }}:</span> {{ $registeredUser->phone }} </p>
                            @endif

                            <a href="{{ route('shop.registered_user.account.personal-data', ['languageSlug' => $languageSlug]) }}" class="btn btn-outline">{{ __('shop::front.registered_user_profile.edit') }}</a>
                        </div>

                        <div class="col col-1of2">
                            <h5>{{ __('shop::front.registered_user_profile.newsletter') }}</h5>

                            <p>{{ __('shop::front.registered_user_profile.not_subscribed') }}</p>

                            <a href="{{ route('shop.registered_user.account.subscribe', ['languageSlug' => $languageSlug]) }}" class="btn btn-outline" onclick="event.preventDefault();
                                    document.getElementById('subscribe-form').submit();">
                                @if($registeredUser->newsletter_subscribed)
                                    {{ __('shop::front.registered_user_profile.unsubscribe') }}
                                @else
                                    {{ __('shop::front.registered_user_profile.subscribe') }}
                                @endif
                            </a>
                            <form id="subscribe-form" action="{{ route('shop.registered_user.account.subscribe', ['languageSlug' => $languageSlug]) }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>

                    <h5>{{ __('shop::front.registered_user_profile.last_orders') }}</h5>

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
                            @forelse($orders as $order)
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

                        <div class="table-bottom">
                            <a href="{{ route('shop.registered_user.account.orders.get-orders', ['languageSlug' => $languageSlug]) }}" class="btn btn-outline">{{ __('shop::front.registered_user_profile.view_all') }}</a>
                        </div>
                    </div>

                    <div class="box-cols">
                        <div class="col col-1of2">
                            <div class="box-text">
                                <div class="box-content">
                                    <h4>{{ __('shop::front.registered_user_profile.shipping_address') }}</h4>
                                    @if(!is_null($defaultShipmentAddress))
                                        <p>{{ $defaultShipmentAddress->name }}</p>

                                        <p>{{ $defaultShipmentAddress->street . ', № ' . $defaultShipmentAddress->street_number }}</p>

                                        <p>{{ $defaultShipmentAddress->city->name }} {{ $defaultShipmentAddress->zip_code }} </p>

                                        <a href="" class="btn btn-outline">{{ __('shop::front.registered_user_profile.edit') }}</a>
                                    @else
                                        <p>Няма добавен адрес.</p>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="col col-1of2">
                            <div class="box-text">
                                <div class="box-content">
                                    <h4>{{ __('shop::front.registered_user_profile.billing_address') }}</h4>
                                    @if(!is_null($defaultPaymentAddress))
                                        <p>{{ $defaultPaymentAddress->name }}</p>

                                        <p>{{ $defaultPaymentAddress->street . ', № ' . $defaultPaymentAddress->street_number }}</p>

                                        <p>{{ $defaultPaymentAddress->city->name }} {{ $defaultPaymentAddress->zip_code }} </p>

                                        <a href="" class="btn btn-outline">{{ __('shop::front.registered_user_profile.edit') }}</a>
                                    @else
                                        <p>Няма добавен адрес.</p>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
