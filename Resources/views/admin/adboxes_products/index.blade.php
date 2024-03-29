@extends('layouts.admin.app')

@section('content')
    @include('shop::admin.adboxes_products.breadcrumbs')
    @include('admin.notify')
    @include('admin.partials.index.top_search_with_mass_buttons', ['mainRoute' => Request::segment(3), 'noCreate' => ''])

    <div class="row">
        <div class="col-xs-12">
            <h3>{{ __('shop::admin.product_adboxes.waiting_action') }}</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <th class="width-2-percent"></th>
                    <th class="width-2-percent">{{ __('shop::admin.common.number') }}</th>
                    <th class="width-130">{{ __('shop::admin.common.type') }}</th>
                    <th>{{ __('shop::admin.common.title') }}</th>
                    <th class="width-220 text-right">{{ __('shop::admin.common.actions') }}</th>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @forelse ($adBoxesWaitingAction as $adBoxWaitingAction)
                        <tr class="t-row row-{{$adBoxWaitingAction->id}}">
                            <td class="width-2-percent">
                                <div class="pretty p-default p-square">
                                    <input type="checkbox" class="checkbox-row" name="check[]" value="{{$adBoxWaitingAction->id}}"/>
                                    <div class="state p-primary">
                                        <label></label>
                                    </div>
                                </div>
                            </td>
                            <td class="width-2-percent">{{$i}}</td>
                            <td><label class="label label-default">{{ trans('shop::admin.product_adboxes.type_0') }}</label></td>
                            <td>
                                {{ $adBoxWaitingAction->product->title }}
                            </td>
                            <td class="pull-right">
                                <a href="{{ route('admin.product-adboxes.edit', ['id' => $adBoxWaitingAction->id]) }}" class="btn green tooltips" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{ __('admin.edit') }}"><i class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('admin.product-adboxes.delete', ['id' => $adBoxWaitingAction->id]) }}" class="btn red btn-delete-confirm tooltips" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{ __('admin.delete') }}"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <tr class="t-row-details row-{{$adBoxWaitingAction->id}}-details hidden">
                            <td colspan="2"></td>
                            <td colspan="2"></td>
                            <td class="width-220"></td>
                        </tr>
                            <?php $i++; ?>
                    @empty
                        <tr>
                            <td colspan="5" class="no-table-rows">{{ trans('shop::admin.product_adboxes.no_records') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>{!! trans('shop::admin.product_adboxes.index') !!}: {{ trans('shop::admin.product_adboxes.type_1') }}</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <th class="width-2-percent"></th>
                    <th class="width-2-percent">{{ __('shop::admin.common.number') }}</th>
                    <th class="width-130">{{ __('shop::admin.common.type') }}</th>
                    <th>{{ __('shop::admin.common.title') }}</th>
                    <th class="width-220 text-right">{{ __('shop::admin.common.actions') }}</th>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @forelse ($adBoxesFirstType as $adBoxFirstType)
                        <tr class="t-row row-{{$adBoxFirstType->id}}">
                            <td class="width-2-percent">
                                <div class="pretty p-default p-square">
                                    <input type="checkbox" class="checkbox-row" name="check[]" value="{{$adBoxFirstType->id}}"/>
                                    <div class="state p-primary">
                                        <label></label>
                                    </div>
                                </div>
                            </td>
                            <td class="width-2-percent">{{$i}}</td>
                            <td><label class="label btn-light-green">{{ trans('shop::admin.product_adboxes.type_1') }}</label></td>
                            <td>
                                {{ $adBoxFirstType->product->title }}
                            </td>
                            <td class="pull-right">
                                @include('admin.partials.index.action_buttons', ['mainRoute' => Request::segment(3), 'models' => $adBoxesFirstType, 'model' => $adBoxFirstType, 'showInPublicModal' => false])
                            </td>
                        </tr>
                        <tr class="t-row-details row-{{$adBoxFirstType->id}}-details hidden">
                            <td colspan="2"></td>
                            <td colspan="2">
                                <table class="table-details">
                                    <tbody>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="width-220">

                            </td>
                        </tr>
                            <?php $i++; ?>
                    @empty
                        <tr>
                            <td colspan="5" class="no-table-rows">{{ trans('shop::admin.product_adboxes.no_records') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
