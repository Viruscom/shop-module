@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Cities VATS {{$state->name}}({{$state->country->name}})
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
                                <td>City</td>
                                <td>VAT</td>
                                <td>ACTION</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($state->cities as $city)
                                <tr>
                                    <td>{{$city->name}}</td>
                                    <td>{{$city->vat}}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{route('vats.countries.states.cities.edit',['id'=>$city->id])}}">edit</a>
                                        <a class="btn btn-info" href="{{route('vats.countries.states.cities.categories.index',['id'=>$city->id])}}">categories</a>
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
