<div class="breadcrumbs">
    <ul>
        <li>
            <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('admin.products.index') }}" class="text-black">{{ __('shop::admin.products.index') }}</a>
        </li>
        @if(url()->current() === route('admin.products.create'))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.products.create') }}" class="text-purple">{{ __('shop::admin.products.create') }}</a>
            </li>
        @elseif(Request::segment(4) !== null && url()->current() === route('admin.products.edit', ['id' => Request::segment(4)]))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.products.edit', ['id' => Request::segment(4)]) }}" class="text-purple">{{ __('shop::admin.products.edit') }}</a>
            </li>
        @endif
    </ul>
</div>
