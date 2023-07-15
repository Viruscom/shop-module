<div class="breadcrumbs">
    <ul>
        <li>
            <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('admin.shop.registered-users.favorite-products.index', ['id' => $registeredUser]) }}" class="text-black">@lang('shop::admin.favorite_products.index')</a>
        </li>
    </ul>
</div>
