<div class="breadcrumbs">
    <ul>
        <li>
            <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('shop.index') }}" class="text-black">@lang('shop::admin.shop.index')</a>
        </li>
        @if(url()->current() === route('shop.create'))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('shop.create') }}" class="text-purple">@lang('shop::admin.shop.create')</a>
            </li>
        @elseif(url()->current() === route('admin.banners.edit', ['id' => Request::segment(3)]))
           <li>
{{--                <i class="fa fa-angle-right"></i>
{{--                <a href="{{ route('ad-boxes.edit') }}" class="text-purple">@lang('shop::admin.shop.edit')</a>
{{--            </li>--}}
        @endif
    </ul>
</div>

<div class="breadcrumbs">
    <ul>
        @if(url()->current() === route('admin.shop.index'))
            <li>
                <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i></a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="{{ route('admin.shop.index') }}" class="text-black">@lang('admin.shop.index')</a>
            </li>
        @elseif(url()->current() === route('admin.banners.create'))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.shop.create') }}" class="text-purple">@lang('admin.shop.create')</a>
            </li>
        @elseif(url()->current() === route('admin.shop.edit', ['id' => Request::segment(3)]))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.shop.edit', ['id' => Request::segment(3)]) }}" class="text-purple">@lang('admin.shop.edit')</a>
            </li>
        @endif
    </ul>
</div>

