@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
    <link href="{{ asset('admin/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.fixedHeader.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var table = $('#countries').DataTable({
                fixedHeader: true,
            });
        });
    </script>
@endsection

@section('content')
    @include('shop::admin.settings.main.breadcrumbs')
    @include('admin.notify')
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
                        @if(array_key_exists('Shop', $activeModules))
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span>Email (За получаване на поръчки)</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">{{ __('admin.email') }}:</label>
                                        <div class="col-md-6">
                                            <input type="text" name="shop_orders_email" value="{{ old('shop_orders_email') ?: $postSetting->shop_orders_email }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

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
                            <table class="table" id="countries">
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
                                            $sale = false;
                                            if (in_array($country->id, $salesCountries)) {
                                                $sale = true;
                                            }
                                        @endphp
                                        <tr class="t-row row-{{$country->id}} {{ $sale ? 'sale-background':'' }}">
                                            <td class="width-2-percent">
                                                <div class="pretty p-default p-square">
                                                    <input type="checkbox" class="checkbox-row" name="sales_countries[]" value="{{$country->id}}"/>
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
                                            <?php $i++; ?>
                                    @endforeach
                                    <tr style="display: none;">
                                        <td colspan="3" class="no-table-rows">{{ trans('shop::admin.product_brands.no_records') }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="3" class="no-table-rows">{{ trans('shop::admin.product_brands.no_records') }}</td>
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
