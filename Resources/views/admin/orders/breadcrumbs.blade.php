<div class="breadcrumbs">
    <ul>
        <li>
            <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('admin.shop.orders') }}" class="text-black">@lang('shop::admin.orders.index')</a>
        </li>
        @if(url()->current() === route('admin.shop.orders.create'))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.shop.orders.create') }}" class="text-purple">@lang('shop::admin.orders.create')</a>
            </li>
        @elseif(url()->current() === route('admin.shop.orders.edit', ['id' => Request::segment(3)]))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.shop.orders.edit', ['id' => Request::segment(3)]) }}" class="text-purple">@lang('shop::admin.orders.edit')</a>
            </li>
        @endif
    </ul>
</div>

