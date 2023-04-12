<div class="breadcrumbs">
    <ul>
        <li>
            <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('admin.shop.registered-users.index') }}" class="text-black">@lang('shop::admin.registered_users.index')</a>
        </li>
        @if(Request::segment(4) !== null && url()->current() === route('admin.shop.registered-users.edit', ['id' => Request::segment(4)]))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.shop.registered-users.edit', ['id' => Request::segment(4)]) }}" class="text-purple">@lang('shop::admin.product_adboxes.edit')</a>
            </li>
        @endif
    </ul>
</div>
