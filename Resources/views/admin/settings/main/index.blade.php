@extends('layouts.admin.app')

@section('styles')
    <style>
        .sale-background {
            color:            #ffffff;
            background-color: #2d8f3c !important;
        }

        .sale-check-wrapper {
            display:         flex;
            align-items:     center;
            justify-content: flex-end;
        }

        .sale-check-wrapper > i {
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')
    @include('shop::admin.settings.main.breadcrumbs')
    @include('admin.notify')

    <script>
        var selectedCountries = [];

        function pushToArray(countryId, sale) {
            if (sale) {
                selectedCountries.push(countryId);
            }
        }

        function checkboxChecked() {
            for (var i = 0; i < selectedCountries.length; i++) {
                var checkbox     = document.querySelector('.checkbox-row[value="' + selectedCountries[i] + '"]');
                checkbox.checked = true;
                checkbox.dispatchEvent(new Event('change'));
            }
        }

        window.onload = function () {
            checkboxChecked();
        };
    </script>
    <form action="{{ route('admin.shop.settings.main.update') }}" method="POST">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ route('admin.shop.settings.index') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form form-horizontal">
                    <div class="form-body">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span>@lang('shop::admin.main_settings.index')</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @foreach($shopSettings as $shopSetting)
                                    <div class="form-group">
                                        <label class="control-label col-md-3">{{ __('shop::admin.main_settings.'.$shopSetting->key) }}:</label>
                                        <div class="col-md-6">
                                            <input type="text" name="shopSettings[{{$shopSetting->key}}]" value="{{ old($shopSetting->key) ?: $shopSetting->value }}" class="form-control">
                                        </div>
                                    </div>
                                @endforeach
                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ __('shop::admin.main_settings.email_for_orders') }}:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="shop_orders_email" value="{{ old('shop_orders_email') ?: $postSetting->shop_orders_email }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="caption-wrapper">
                            <h3>@lang('shop::admin.main_settings.sale_in_countries')</h3>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="alert alert-warning">{!! trans('shop::admin.main_settings.sales_counties_warning') !!}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bg-grey top-search-bar">
                            <div class="checkbox-all pull-left p-10 p-l-0">
                                <div class="pretty p-default p-square">
                                    <input type="checkbox" id="selectAll" class="tooltips" data-toggle="tooltip" data-placement="right" data-original-title="Маркира/Демаркира всички елементи" data-trigger="hover">
                                    <div class="state p-primary">
                                        <label></label>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse-buttons pull-left p-7">
                                <a class="btn btn-xs expand-btn"><i class="fas fa-angle-down fa-2x" data-toggle="tooltip" data-placement="right" data-original-title="Разпъва всички маркирани елементи"></i></a>
                                <a class="btn btn-xs collapse-btn hidden"><i class="fas fa-angle-up fa-2x" data-toggle="tooltip" data-placement="right" data-original-title="Прибира всички маркирани елементи"></i></a>
                            </div>
                            <div class="search pull-left hidden-xs">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control input-sm search-text" placeholder="Търси">
                                    <span class="input-group-btn">
                                <button class="btn btn-sm submit"><i class="fa fa-search"></i></button>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <th class="width-2-percent"></th>
                                <th class="width-2-percent">{{ __('admin.number') }}</th>
                                <th>{{ __('shop::admin.main_settings.country') }}</th>
                                <th>{{ __('shop::admin.main_settings.active_sales_country') }}</th>
                                </thead>
                                <tbody>
                                @if(count($countries))
                                        <?php $i = 1; ?>
                                    @foreach($countries as $country)
                                        @php
                                            $sale = 0;
                                            if (in_array($country->id, $salesCountries)) {
                                                $sale = 1;
                                            }
                                        @endphp
                                        <tr class="t-row row-{{$country->id}} {{ $sale ? 'sale-background':'' }}">
                                            <td class="width-2-percent">
                                                <div class="pretty p-default p-square">
                                                    <input type="checkbox" class="checkbox-row" name="sales_countries[]" value="{{$country->id}}" {{ $sale ? 'checked':'' }}/>
                                                    <div class="state p-primary">
                                                        <label></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="width-2-percent">{{$i}}</td>
                                            <td>{{ $country->name}}</td>
                                            <td class="text-right">
                                                @if($sale)
                                                    <span class="sale-check-wrapper"><i class="far fa-check-circle fa-2x"></i> @lang('shop::admin.main_settings.you_sale_here')</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <script>
                                            pushToArray({{ $country->id }}, {{ $sale }});
                                        </script>
                                            <?php $i++; ?>
                                    @endforeach
                                    <tr style="display: none;">
                                        <td colspan="4" class="no-table-rows">{{ trans('shop::admin.product_brands.no_records') }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="4" class="no-table-rows">{{ trans('shop::admin.product_brands.no_records') }}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="submit" value="submit" class="btn save-btn margin-bottom-10"><i class="fas fa-save"></i> запиши</button>
                                    <a href="{{ route('admin.shop.settings.index') }}" role="button" class="btn back-btn margin-bottom-10"><i class="fa fa-reply"></i> {{ __('admin.common.back') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
