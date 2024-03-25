@php use App\Helpers\WebsiteHelper; @endphp
<ul class="sidebar-nav">
    <li class="{{ WebsiteHelper::isActiveRoute('shop.dashboard') ? 'active' : '' }}">
        <a href="{{ route('shop.dashboard', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.my_account') }}</a>
    </li>
    <li class="{{ WebsiteHelper::isActiveRoute('shop.registered_user.account.favorites') ? 'active' : '' }}">
        <a href="{{ route('shop.registered_user.account.favorites', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.wishlist') }}</a>
    </li>
    <li class="{{ WebsiteHelper::isActiveRoute('shop.registered_user.account.orders.get-orders') ? 'active' : '' }}">
        <a href="{{ route('shop.registered_user.account.orders.get-orders', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.orders') }}</a>
    </li>
    <li class="{{ WebsiteHelper::isActiveRoute('shop.registered_user.account.addresses.*') ? 'active' : '' }}">
        <a href="{{ route('shop.registered_user.account.addresses', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.addresses') }}</a>
    </li>
{{--    <li class="{{ WebsiteHelper::isActiveRoute('shop.registered_user.account.addresses.billing.*') ? 'active' : '' }}">--}}
{{--        <a href="{{ route('shop.registered_user.account.addresses.billing', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.addresses') }}</a>--}}
{{--    </li>--}}
    <li class="{{ WebsiteHelper::isActiveRoute('shop.registered_user.account.companies.*') || WebsiteHelper::isActiveRoute('shop.registered_user.account.companies') ? 'active' : '' }}">
        <a href="{{ route('shop.registered_user.account.companies', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.firms') }}</a>
    </li>
    {{--    <li class="{{ WebsiteHelper::isActiveRoute('admin.brands.*') ? 'active' : '' }}">--}}
    {{--        <a href="#">{{ __('shop::front.registered_user_profile.discounts') }}</a>--}}
    {{--    </li>--}}
    {{--    <li class="{{ WebsiteHelper::isActiveRoute('admin.brands.*') ? 'active' : '' }}">--}}
    {{--        <a href="#">{{ __('shop::front.registered_user_profile.returns') }}</a>--}}
    {{--    </li>--}}
    <li class="{{ WebsiteHelper::isActiveRoute('shop.registered_user.account.personal-data') ? 'active' : '' }}">
        <a href="{{ route('shop.registered_user.account.personal-data', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.personal_data') }}</a>
    </li>
    <li class="{{ WebsiteHelper::isActiveRoute('shop.logout') ? 'active' : '' }}">
        <a href="{{ route('shop.logout', ['languageSlug' => $languageSlug]) }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>{{ __('shop::front.registered_user_profile.logout') }}</a>
        <form id="logout-form" action="{{ route('shop.logout', ['languageSlug' => $languageSlug]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
</ul>

<select name="" id="" class="select-custom sidebar-select">
    <option value="{{ route('shop.dashboard', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.my_account') }}</option>
    <option value="{{ route('shop.registered_user.account.favorites', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.wishlist') }}</option>
    <option value="{{ route('shop.registered_user.account.orders.get-orders', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.orders') }}</option>
    <option value="{{ route('shop.registered_user.account.addresses', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.addresses') }}</option>
    <option value="{{ route('shop.registered_user.account.companies', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.firms') }}</option>
    {{--    <option value="#">{{ __('shop::front.registered_user_profile.discounts') }}</option>--}}
    {{--    <option value="#">{{ __('shop::front.registered_user_profile.returns') }}</option>--}}
    <option value="{{ route('shop.registered_user.account.personal-data', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.personal_data') }}</option>
    <option value="{{ route('shop.logout', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.logout') }}</option>
</select>
