@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">VATS Categories for {{$country->name}}
                        <a class="btn btn-success" href="{{route('vats.countries.categories.create',['id'=>$country->id])}}">Create</a>
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
                                <td>Name</td>
                                <td>VAT</td>
                                <td>ACTION</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($country->vat_categories as $category)
                                <tr>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->vat}}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{route('vats.countries.categories.edit',['id'=>$category->id])}}">edit</a>
                                        <a class="btn btn-danger" href="{{route('vats.countries.categories.delete',['id'=>$category->id])}}">delete</a>
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
