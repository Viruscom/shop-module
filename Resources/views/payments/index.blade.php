@extends('layouts.admin.app')

@section('content')
    @include('admin.notify')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('shop::admin.payments.position') }}</th>
                        <th>{{ __('shop::admin.payments.payment_system') }}</th>
                        <th>{{ __('shop::admin.payments.status') }}</th>
                        <th class="text-right">{{ __('admin.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($payments))
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{$payment->position}}</td>
                                <td>{{ __('shop::admin.payment_systems.'.$payment->type) }}</td>
                                <td>{{$payment->active}}</td>
                                <td class="text-right">
                                    @if($payment->hasEditView())
                                        <a class="btn btn-warning" href="{{route('payments.edit',['id'=>$payment->id])}}">{{ __('edit') }}</a>
                                    @endif
                                </td>
                            </tr>
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
