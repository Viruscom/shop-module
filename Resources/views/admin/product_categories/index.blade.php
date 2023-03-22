@extends('layouts.admin.app')
@section('content')
    @include('shop::admin.product_categories.breadcrumbs')
    @include('admin.notify')
    @include('admin.partials.index.top_search_with_mass_buttons', ['mainRoute' => Request::segment(3)])

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <th class="width-2-percent"></th>
                    <th class="width-2-percent">{{ __('admin.number') }}</th>
                    <th>{{ __('admin.title') }}</th>
                    <th class="width-220">{{ __('admin.actions') }}</th>
                    </thead>
                    <tbody>
                    @if(!is_null($categories) && $categories->isNotEmpty())
                            <?php $i = 1; ?>
                        @foreach($categories as $category)
                            <tr class="t-row row-{{$category->id}}">
                                <td class="width-2-percent">
                                    <div class="pretty p-default p-square">
                                        <input type="checkbox" class="checkbox-row" name="check[]" value="{{$category->id}}"/>
                                        <div class="state p-primary">
                                            <label></label>
                                        </div>
                                    </div>
                                </td>
                                <td class="width-2-percent">{{$i}}</td>
                                <td>
                                    {{ $category->title }}
                                </td>
                                <td class="pull-right">
                                    @include('admin.partials.index.action_buttons', ['mainRoute' => Request::segment(3), 'models' => $categories, 'model' => $category, 'showInPublicModal' => false])
                                </td>
                            </tr>
                            <tr class="t-row-details row-{{$category->id}}-details hidden">
                                <td colspan="2"></td>
                                <td colspan="1">
                                    <table class="table-details">
                                        <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="width-220">
                                    <img class="thumbnail img-responsive" src="{{ $category->getFileUrl() }}"/>
                                </td>
                            </tr>
                                <?php $i++; ?>
                        @endforeach
                        <tr style="display: none;">
                            <td colspan="4" class="no-table-rows">{{ trans('shop::admin.product_categories.no_records') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="4" class="no-table-rows">{{ trans('shop::admin.product_categories.no_records') }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 90%; margin: 30px auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Изглед в публичната част</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>
@endsection
