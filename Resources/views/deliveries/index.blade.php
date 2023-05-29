@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Deliveries
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
                                <td>Delivery</td>
                                <td>Active</td>
                                <td>ACTION</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deliveries as $delivery)
                                <tr>
                                    <td>{{$delivery->position}}</td>
                                    <td>{{$delivery->type}}</td>
                                    <td>{{$delivery->active}}</td>
                                    <td>
                                        @if($delivery->hasEditView())
                                            <a class="btn btn-warning" href="{{route('deliveries.edit',['id'=>$delivery->id])}}">edit</a>
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
