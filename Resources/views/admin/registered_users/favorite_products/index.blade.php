@extends('layouts.admin.app')
@section('content')
    @include('shop::admin.registered_users.favorite_products.breadcrumbs')
    @include('admin.notify')

    <div class="row m-t-40">
        <div class="col-xs-12">
            <div class="caption-wrapper">
                <h3>@lang('shop::admin.favorite_products.index') @lang('shop::admin.favorite_products.for_user') <strong>{{ $registeredUser->first_name . ' ' . $registeredUser->last_name }}</strong></h3>
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
                    <th>{{ __('admin.title') }}</th>
                    </thead>
                    <tbody>
                    @if(count($favoriteProducts))
                            <?php $i = 1; ?>
                        @foreach($favoriteProducts as $favorite)
                            <tr class="t-row row-{{$favorite->product->id}}">
                                <td class="width-2-percent">
                                    <div class="pretty p-default p-square">
                                        <input type="checkbox" class="checkbox-row" name="check[]" value="{{$favorite->product->id}}"/>
                                        <div class="state p-primary">
                                            <label></label>
                                        </div>
                                    </div>
                                </td>
                                <td class="width-2-percent">{{$i}}</td>
                                <td>
                                    {{ $favorite->product->title}}
                                </td>
                            </tr>
                            <tr class="t-row-details row-{{$favorite->product->id}}-details hidden">
                                <td colspan="2"></td>
                                <td colspan="1">
                                    <table class="table-details">
                                        <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="width-220">
                                    <img class="thumbnail img-responsive" src="{{ $favorite->product->getFileUrl() }}"/>
                                </td>
                            </tr>
                                <?php $i++; ?>
                        @endforeach
                        <tr style="display: none;">
                            <td colspan="3" class="no-table-rows">{{ trans('shop::admin.favorite_products.no_records') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="3" class="no-table-rows">{{ trans('shop::admin.favorite_products.no_records') }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
