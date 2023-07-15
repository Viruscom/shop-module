@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Countries VATS
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
                                <td>Country</td>
                                <td>VAT</td>
                                <td>ACTION</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($countries as $country)
                                <tr>
                                    <td>{{$country->name}}</td>
                                    <td>{{$country->vat}}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{route('vats.countries.edit',['id'=>$country->id])}}">edit</a>
                                        <a class="btn btn-info" href="{{route('vats.countries.states.index',['id'=>$country->id])}}">states</a>
                                        <a class="btn btn-info" href="{{route('vats.countries.categories.index',['id'=>$country->id])}}">categories</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $countries->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
