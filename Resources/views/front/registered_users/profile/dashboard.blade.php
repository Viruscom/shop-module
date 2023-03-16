@extends('layouts.front.app')

@section('content')
    <div class="page-wrapper">
        @include('shop::front.registered_users.profile.breadcrumbs')

        <section class="settings-page">
            <div class="shell">
                <ul class="sidebar-nav">
                    <li class="active">
                        <a href="">{{ __('shop::front.registered_user_profile.my_account') }}</a>
                    </li>
                    <li>
                        <a href="">{{ __('shop::front.registered_user_profile.wishlist') }}</a>
                    </li>
                    <li>
                        <a href="">{{ __('shop::front.registered_user_profile.orders') }}</a>
                    </li>
                    <li>
                        <a href="">{{ __('shop::front.registered_user_profile.addresses') }}</a>
                    </li>
                    <li>
                        <a href="">{{ __('shop::front.registered_user_profile.firms') }}</a>
                    </li>
                    <li>
                        <a href="">{{ __('shop::front.registered_user_profile.discounts') }}</a>
                    </li>
                    <li>
                        <a href="">{{ __('shop::front.registered_user_profile.returns') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('shop.personal-data', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.personal_data') }}</a>
                    </li>
                    <li>
                        <form action="{{ route('shop.logout', ['languageSlug' => $languageSlug]) }}" method="POST">
                            @csrf
                            <button type="submit">{{ __('shop::front.registered_user_profile.logout') }}</button>
                        </form>
                    </li>
                </ul>

                <select name="" id="" class="select-custom sidebar-select">
                    <option value="">{{ __('shop::front.registered_user_profile.my_account') }}</option>
                    <option value="">{{ __('shop::front.registered_user_profile.wishlist') }}</option>
                    <option value="">{{ __('shop::front.registered_user_profile.orders') }}</option>
                    <option value="">{{ __('shop::front.registered_user_profile.addresses') }}</option>
                    <option value="">{{ __('shop::front.registered_user_profile.firms') }}</option>
                    <option value="">{{ __('shop::front.registered_user_profile.discounts') }}</option>
                    <option value="">{{ __('shop::front.registered_user_profile.returns') }}</option>
                    <option value="">{{ __('shop::front.registered_user_profile.personal_data') }}</option>
                    <option value="{{ route('shop.logout', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.logout') }}</option>
                </select>

                <div class="page-content">
                    <h3 class="page-title">{{ __('shop::front.registered_user_profile.my_account') }}</h3>

                    <div class="box-cols">
                        <div class="col col-1of2">
                            <h5><span>{{ __('shop::front.registered_user_profile.hello') }},</span> {{ $registeredUser->name }}!</h5>

                            <p>
                                <span>{{ __('shop::front.registered_user_profile.email') }}:</span> {{ $registeredUser->email }} </p>

                            <p>
                                <span>{{ __('shop::front.registered_user_profile.phone') }}:</span> +359896669928 </p>

                            <a href="" class="btn btn-outline">{{ __('shop::front.registered_user_profile.edit') }}</a>
                        </div>

                        <div class="col col-1of2">
                            <h5>{{ __('shop::front.registered_user_profile.newsletter') }}</h5>

                            <p>{{ __('shop::front.registered_user_profile.not_subscribed') }}</p>

                            <a href="" class="btn btn-outline">{{ __('shop::front.registered_user_profile.subscribe') }}</a>
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
                            <tr>
                                <td>132648</td>
                                <td>12.06.2020</td>
                                <td>Daniel Yordanov</td>
                                <td class="align-right">1 559.00 BGN</td>
                                <td>{{ __('shop::front.registered_user_profile.sent') }}</td>
                                <td class="align-right">
                                    <a href="">{{ __('shop::front.registered_user_profile.details') }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>132648</td>
                                <td>12.06.2020</td>
                                <td>Daniel Yordanov</td>
                                <td class="align-right">1 559.00 BGN</td>
                                <td>{{ __('shop::front.registered_user_profile.sent') }}</td>
                                <td class="align-right">
                                    <a href="">{{ __('shop::front.registered_user_profile.details') }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>132648</td>
                                <td>12.06.2020</td>
                                <td>Anna-Maria Daniel Yordanova-Popova Marinova</td>
                                <td class="align-right">1 559.00 BGN</td>
                                <td>{{ __('shop::front.registered_user_profile.sent') }}</td>
                                <td class="align-right">
                                    <a href="">{{ __('shop::front.registered_user_profile.details') }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>132648</td>
                                <td>12.06.2020</td>
                                <td>Daniel Yordanov</td>
                                <td class="align-right">1 559.00 BGN</td>
                                <td>{{ __('shop::front.registered_user_profile.sent') }}</td>
                                <td class="align-right">
                                    <a href="">{{ __('shop::front.registered_user_profile.details') }}</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="table-bottom">
                            <a href="" class="btn btn-outline">{{ __('shop::front.registered_user_profile.view_all') }}</a>
                        </div>
                    </div>

                    <div class="box-cols">
                        <div class="col col-1of2">
                            <div class="box-text">
                                <div class="box-content">
                                    <h4>{{ __('shop::front.registered_user_profile.shipping_address') }}</h4>

                                    <p>Daniel Yordanov</p>

                                    <p>+359896669928</p>

                                    <p>47-47B, Edisson Str., ground floor, office 6 Creative studio GD styles</p>

                                    <p>Sofia 1111 </p>

                                    <a href="" class="btn btn-outline">{{ __('shop::front.registered_user_profile.edit') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="col col-1of2">
                            <div class="box-text">
                                <div class="box-content">
                                    <h4>{{ __('shop::front.registered_user_profile.billing_address') }}</h4>

                                    <p>Daniel Yordanov</p>

                                    <p>200436302</p>

                                    <p>47-47B, Edisson Str., ground floor, office 6 Creative studio GD styles</p>

                                    <p>Sofia 1111</p>

                                    <a href="" class="btn btn-outline">{{ __('shop::front.registered_user_profile.edit') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
