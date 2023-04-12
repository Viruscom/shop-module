@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Payments
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <td>Position</td>
                                <td>Payment</td>
                                <td>Active</td>
                                <td>ACTION</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{$payment->position}}</td>
                                    <td>{{$payment->type}}</td>
                                    <td>{{$payment->active}}</td>
                                    <td>
                                        @if($payment->hasEditView())
                                            <a class="btn btn-warning" href="{{route('payments.edit',['id'=>$payment->id])}}">edit</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
