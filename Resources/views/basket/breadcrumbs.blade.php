@php use App\Helpers\WebsiteHelper; @endphp
<div class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
    <ul>
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="{{ WebsiteHelper::homeUrl() }}"> <span itemprop="name">{{ __('front.breadcrumbs.home') }}</span></a>
            <meta itemprop="position" content="1"/>
        </li>

        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="{{ url()->current() }}">
                <span itemprop="name">{!! trans('shop::front.basket.index') !!}</span>
            </a>
            <meta itemprop="position" content="2"/>
        </li>
    </ul>
</div>
