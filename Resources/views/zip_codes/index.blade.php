@extends('layouts.admin.app')

@section('content')
    @include('shop::zip_codes.breadcrumbs')
    @include('admin.notify')
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <td>{{ __('shop::admin.post_codes.city') }}</td>
                    <td>{{ __('shop::admin.post_codes.state') }}</td>
                    <td>{{ __('shop::admin.post_codes.country') }}</td>
                    <td>{{ __('shop::admin.post_codes.index') }}</td>
                    <th class="text-right">{{ __('admin.actions') }}</th>
                    </thead>
                    <tbody>
                    @if(count($cities))
                            <?php $i = 1; ?>
                        @foreach($cities as $city)
                            <tr class="t-row row-{{$city->id}}">
                                <td>{{$city->name}}</td>
                                <td>{{$city->state->name}}</td>
                                <td>{{$city->country->name}}</td>
                                <td>{{$city->zip_codes}}</td>
                                <td class="text-right">
                                    <a href="{{route('zip_codes.edit',['id'=>$city->id])}}" class="btn green tooltips" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{ __('admin.edit') }}"><i class="fas fa-pencil-alt"></i></a>
                                </td>
                            </tr>

                            <tr class="t-row-details row-{{$city->id}}-details hidden">

                            </tr>
                                <?php $i++; ?>
                        @endforeach

                        <tr style="display: none;">
                            <td colspan="3" class="no-table-rows">{{ __('shop::admin.post_codes.no-records') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="3" class="no-table-rows">{{ __('shop::admin.post_codes.no-records') }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
