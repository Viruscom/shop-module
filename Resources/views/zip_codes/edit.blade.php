@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Zip Codes for {{$city->name, $city->state->name, $city->country->name}}
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{route('zip_codes.update',['id'=>$city->id])}}">
                            @csrf

                            <div class="form-group row">
                                <label for="zip_codes" class="col-md-4 col-form-label text-md-right">{{ __('Zip codes(comma separated)') }}*</label>

                                <div class="col-md-6">
                                    <textarea id="zip_codes" class="form-control @error('zip_codes') is-invalid @enderror" name="zip_codes" required autocomplete="zip_codes" autofocus rows="10">{{ $city->zip_codes }}</textarea>

                                    @error('zip_codes')
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
