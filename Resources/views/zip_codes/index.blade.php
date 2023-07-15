@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ZipCodes
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
                                <td>State</td>
                                <td>Country</td>
                                <td>Zip codes</td>
                                <td>ACTION</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cities as $city)
                                <tr>
                                    <td>{{$city->name}}</td>
                                    <td>{{$city->state->name}}</td>
                                    <td>{{$city->country->name}}</td>
                                    <td>{{$city->zip_codes}}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{route('zip_codes.edit',['id'=>$city->id])}}">edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $cities->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
