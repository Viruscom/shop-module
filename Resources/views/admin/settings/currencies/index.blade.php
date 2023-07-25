@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @include('shop::admin.settings.currencies.breadcrumbs')
    @include('admin.notify')

    <div class="row">
        <div class="col-sm-12">
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
                        <div class="action-mass-buttons pull-right">
                            <a href="{{ route('admin.shop.settings.index') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
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
                            <th>{{ __('shop::admin.currencies.code') }}</th>
                            <th>{{ __('shop::admin.currencies.name') }}</th>
                            <th>{{ __('admin.actions') }}</th>
                            </thead>
                            <tbody>
                            @if(count($currencies))
                                    <?php $i = 1; ?>
                                @foreach($currencies as $currency)
                                    @php
                                        $sale = 0;
                                    @endphp
                                    <tr class="t-row row-{{$currency->id}} {{ $sale ? 'sale-background':'' }}">
                                        <td class="width-2-percent">
                                            <div class="pretty p-default p-square">
                                                <input type="checkbox" class="checkbox-row" name="sales_countries[]" value="{{$currency->id}}" {{ $sale ? 'checked':'' }}/>
                                                <div class="state p-primary">
                                                    <label></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="width-2-percent">{{$i}}</td>
                                        <td>{{ $currency->code}}</td>
                                        <td>{{ $currency->name}}</td>
                                        <td class="text-right">
                                            <a class="btn yellow" href="{{ route('admin.currencies.manual-exchange-rate-update', ['id' => $currency->id]) }}" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="@lang('shop::admin.currencies.manual_exchange_rate_update')"><i class="fas fa-exchange-alt"></i></a>
                                        </td>
                                    </tr>
                                        <?php $i++; ?>
                                @endforeach
                                <tr style="display: none;">
                                    <td colspan="5" class="no-table-rows">{{ trans('shop::admin.currencies.no_records') }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" class="no-table-rows">{{ trans('shop::admin.currencies.no_records') }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
