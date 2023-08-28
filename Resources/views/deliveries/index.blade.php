@extends('layouts.admin.app')

@section('content')
    @include('shop::deliveries.breadcrumbs')
    @include('admin.notify')
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <th>{{ __('shop::admin.deliveries.delivery_system') }}</th>
                    <th>{{ __('shop::admin.deliveries.status') }}</th>
                    <th class="text-right">{{ __('admin.actions') }}</th>
                    </thead>
                    <tbody>
                    @if(count($deliveries))
                            <?php $i = 1; ?>
                        @foreach($deliveries as $delivery)
                            <tr class="t-row row-{{$delivery->id}}">
                                <td>{{$delivery->type}}</td>
                                <td>
                                    @if($delivery->active)
                                        <label class="label label-success">{{ __('admin.active_status') }}</label>
                                    @else
                                        <label class="label label-default">{{ __('admin.disactive_status') }}</label>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if($delivery->hasEditView())
                                        <a href="{{route('deliveries.edit',['id'=>$delivery->id])}}" class="btn green tooltips" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{ __('admin.edit') }}"><i class="fas fa-pencil-alt"></i></a>
                                    @endif
                                </td>
                            </tr>

                            <tr class="t-row-details row-{{$delivery->id}}-details hidden">

                            </tr>
                                <?php $i++; ?>
                        @endforeach

                        <tr style="display: none;">
                            <td colspan="3" class="no-table-rows">{{ __('shop::admin.deliveries.no-deliveries') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="3" class="no-table-rows">{{ __('shop::admin.deliveries.no-deliveries') }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
