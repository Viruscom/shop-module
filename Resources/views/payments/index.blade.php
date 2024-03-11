@extends('layouts.admin.app')

@section('content')
    @include('shop::payments.breadcrumbs')
    @include('admin.notify')
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <th>{{ __('shop::admin.payments.payment_system') }}</th>
                    <th>{{ __('shop::admin.payments.status') }}</th>
                    <th class="text-right">{{ __('admin.actions') }}</th>
                    </thead>
                    <tbody>
                    @if(count($payments))
                            <?php $i = 1; ?>
                        @foreach($payments as $payment)
                            <tr class="t-row row-{{$payment->id}}">
                                <td>{{ __('shop::admin.payment_systems.'.$payment->type) }}</td>
                                <td>
                                    @if($payment->active)
                                        <label class="label label-success">{{ __('admin.active_status') }}</label>
                                    @else
                                        <label class="label label-default">{{ __('admin.disactive_status') }}</label>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if($payment->hasEditView())
                                        <a href="{{route('payments.edit',['id'=>$payment->id])}}" class="btn green tooltips" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{ __('admin.edit') }}"><i class="fas fa-pencil-alt"></i></a>
                                    @endif
                                </td>
                            </tr>
                            <tr class="t-row-details row-{{$payment->id}}-details hidden">

                            </tr>
                                <?php $i++; ?>
                        @endforeach
                        <tr style="display: none;">
                            <td colspan="4" class="no-table-rows">{{ __('shop::admin.payments.no-payments') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="4" class="no-table-rows">{{ __('shop::admin.payments.no-payments') }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
