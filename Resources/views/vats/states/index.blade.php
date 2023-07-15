@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">States VATS {{$country->name}}
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
                                <td>State</td>
                                <td>VAT</td>
                                <td>ACTION</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($country->states as $state)
                                <tr>
                                    <td>{{$state->name}}</td>
                                    <td>{{$state->vat}}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{route('vats.countries.states.edit',['id'=>$state->id])}}">edit</a>
                                        <a class="btn btn-info" href="{{route('vats.countries.states.cities.index',['id'=>$state->id])}}">cities</a>
                                        <a class="btn btn-info" href="{{route('vats.countries.states.categories.index',['id'=>$state->id])}}">categories</a>
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
