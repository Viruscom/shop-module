@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update City VAT category {{$category->vat_category->name}} for {{$category->city->name}}({{$category->city->state->country->name}})
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{route('vats.countries.states.cities.categories.update',['id' => $category->id])}}">
                            @csrf

                            <div class="form-group row">
                                <label for="vat" class="col-md-4 col-form-label text-md-right">{{ __('VAT') }}*</label>

                                <div class="col-md-6">
                                    <input type="number" min="0" max="100" step="0.01" id="vat" class="form-control @error('vat') is-invalid @enderror" name="vat" value="{{ $category->vat }}" required autocomplete="vat" autofocus>

                                    @error('vat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
