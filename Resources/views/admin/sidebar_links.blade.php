@php use App\Helpers\WebsiteHelper;use Illuminate\Http\Request; @endphp
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFive" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseFive" aria-expanded="false" aria-controls="collapseFour">
        <h4 class="panel-title">
            <a>
                <img src="{{ asset('admin/assets/images/cart.svg') }}" width="20" style="margin-right: 10px;"> <span>{!! trans('shop::admin.shop.index') !!}</span>
            </a>
        </h4>
    </div>
    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
        <div class="panel-body">
            <ul class="nav">
                <li><a href="{{ route('admin.shop.orders') }}" class="{{ WebsiteHelper::isActiveRoute('admin.shop.orders.*') ? 'active' : '' }}"><i class="fas fa-box"></i> <span>{!! trans('shop::admin.orders.index') !!}</span></a></li>
                {{--                <li><a href="{{ url('/admin/shop/not_placed_orders') }}"><img src="{{ asset('admin/assets/images/cart_abandoned.svg') }}" width="20" style="margin-right: 10px;"> <span>{!! trans('shop::admin.abandoned_baskets.index') !!}</span></a></li>--}}
                {{--                <li><a href="{{ route('orders.returns.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.orders.returns.*') ? 'active' : '' }}"><img src="{{ asset('admin/assets/images/return_order.svg') }}" width="24" alt="" style="margin-right: 12px;"> <span>{!! trans('shop::admin.returned_products.index') !!}</span></a></li>--}}
                @if(array_key_exists('ShopDiscounts', $activeModules))
                    <li><a href="{{ route('discounts.index') }}" class="{{ WebsiteHelper::isActiveRoute('discounts.*') ? 'active' : '' }}"><i class="fas fa-percent"></i> <span>@lang('shop::admin.discounts.index')</span></a></li>
                @endif
                <li><a href="{{ route('admin.shop.registered-users.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.shop.registered-users.*') ? 'active' : '' }}"><i class="fas fa-user-friends"></i> <span>{!! trans('shop::admin.registered_users.index') !!}</span></a></li>
                {{--                <li><a href="https://main.reklamnipodaraci.com/admin/shop/h-18-reports"><i class="fas fa-user-friends"></i>--}}
                {{--                        <span>{{ __('shop::admin.h18_reports.index') }}</span></a></li>--}}
                <li><a href="{{ route('admin.shop.settings.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.shop.settings.*') ? 'active' : '' }}"><i class="fas fa-cogs"></i> <span>{!! trans('shop::admin.shop.settings_index') !!}</span></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFour" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
        <h4 class="panel-title">
            <a>
                <i class="far fa-list-alt"></i> <span>{!! trans('shop::admin.products.index') !!}</span>
            </a>
        </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
        <div class="panel-body">
            <ul class="nav">
                <li><a href="{{ route('admin.brands.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.brands.*') ? 'active' : '' }}"><i class="fas fa-copyright"></i> <span>{!! trans('shop::admin.product_brands.index') !!}</span></a></li>
                <li><a href="{{ route('admin.product-categories.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.product-categories.*') ? 'active' : '' }}"><i class="fas fa-outdent"></i> <span>{!! trans('shop::admin.product_categories.index') !!}</span></a></li>
                <li><a href="{{ route('admin.products.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.products.*') && !WebsiteHelper::isActiveRoute('admin.product_characteristics.*') ? 'active' : '' }}"><i class="far fa-list-alt"></i> <span>{!! trans('shop::admin.products.index') !!}</span></a></li>
                @if(array_key_exists('RetailObjectsRestourant', $activeModules))
                    <li><a href="{{ route('admin.product.additives.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.product.additives.*') ? 'active' : '' }}"><i class="far fa-list-alt"></i> <span>{!! trans('retailobjectsrestourant::admin.product_additives.index') !!}</span></a></li>
                @endif
{{--                <li><a href="{{ route('admin.product-attributes.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.product-attributes.*') ? 'active' : '' }}"><img src="{{ asset('admin/assets/images/product_attribute.svg') }}" alt="@lang('shop::admin.product_attributes.index')" width="18" style="margin-right: 12px;"> <span>{!! trans('shop::admin.product_attributes.index') !!}</span></a></li>--}}
{{--                <li><a href="{{ route('admin.product_characteristics.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.product_characteristics.*') ? 'active' : '' }}"><img src="{{ asset('admin/assets/images/product_characteristics.svg') }}" alt="@lang('shop::admin.product_characteristics.index')" width="18" style="margin-right: 12px;"> <span>{!! trans('shop::admin.product_characteristics.index') !!}</span></a></li>--}}
{{--                <li><a href="{{ route('admin.product-combinations.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.product-combinations.*') ? 'active' : '' }}"><img src="{{ asset('admin/assets/images/product_combinations.svg') }}" alt="@lang('shop::admin.product_combinations.index')" width="18" style="margin-right: 12px;"> <span>{!! trans('shop::admin.product_combinations.index') !!}</span></a></li>--}}
                <li><a href="{{ route('admin.product-collections.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.product-collections.*') ? 'active' : '' }}"><i class="fas fa-layer-group"></i> <span>{!! trans('shop::admin.product_collections.index') !!}</span></a></li>
{{--                <li><a href="{{ route('admin.product-stocks.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.product-stocks.*') ? 'active' : '' }}"><i class="fas fa-inventory"></i><span>{!! trans('shop::admin.product_stocks.index') !!}</span></a></li>--}}
            </ul>
        </div>
    </div>
</div>


