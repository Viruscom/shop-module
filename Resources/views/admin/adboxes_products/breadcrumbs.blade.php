<div class="breadcrumbs">
    <ul>
        <li>
            <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('admin.product-adboxes.index') }}" class="text-black">@lang('shop::admin.product_adboxes.index')</a>
        </li>
       @if(Request::segment(4) !== null && url()->current() === route('admin.product-adboxes.edit', ['id' => Request::segment(4)]))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.product-adboxes.edit', ['id' => Request::segment(4)]) }}" class="text-purple">@lang('shop::admin.product_adboxes.edit')</a>
            </li>
        @endif
    </ul>
</div>
