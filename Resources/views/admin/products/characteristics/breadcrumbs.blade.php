<div class="breadcrumbs">
    <ul>
        <li>
            <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('admin.products.characteristics.index') }}" class="text-black">{{ __('shop::admin.product_characteristics.index') }}</a>
        </li>
        @if(url()->current() === route('admin.products.characteristics.create'))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.products.characteristics.create') }}" class="text-purple">{{ __('shop::admin.product_characteristics.create') }}</a>
            </li>
        @elseif(Request::segment(4) !== null && url()->current() === route('admin.products.edit', ['id' => Request::segment(4)]))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.products.characteristics.edit', ['id' => Request::segment(4)]) }}" class="text-purple">{{ __('shop::admin.product_characteristics.edit') }}</a>
            </li>
        @endif
    </ul>
</div>
