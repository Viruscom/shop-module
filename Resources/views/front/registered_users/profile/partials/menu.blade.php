<ul class="sidebar-nav">
    <li class="active">
        <a href="{{ route('shop.dashboard', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.my_account') }}</a>
    </li>
    <li>
        <a href="{{ route('shop.registered_user.account.favorites', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.wishlist') }}</a>
    </li>
    <li>
        <a href="{{ route('shop.registered_user.account.orders.get-orders', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.orders') }}</a>
    </li>
    <li>
        <a href="">{{ __('shop::front.registered_user_profile.addresses') }}</a>
    </li>
    <li>
        <a href="{{ route('shop.registered_user.account.companies', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.firms') }}</a>
    </li>
    <li>
        <a href="#">{{ __('shop::front.registered_user_profile.discounts') }}</a>
    </li>
    <li>
        <a href="#">{{ __('shop::front.registered_user_profile.returns') }}</a>
    </li>
    <li>
        <a href="{{ route('shop.registered_user.account.personal-data', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.personal_data') }}</a>
    </li>
    <li>
        <a href="{{ route('shop.logout', ['languageSlug' => $languageSlug]) }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>{{ __('shop::front.registered_user_profile.logout') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
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
