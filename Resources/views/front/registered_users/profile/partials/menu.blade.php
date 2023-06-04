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
        <a href="{{ route('shop.registered_user.account.personal-data', ['languageSlug' => $languageSlug]) }}">{{ __('shop::front.registered_user_profile.personal_data') }}</a>
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
