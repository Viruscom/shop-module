@extends('layouts.app')
@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap-confirmation.js') }}"></script>
    <script>
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            container: 'body',
        });
        $(".select2").select2({language: "bg"});
    </script>
@endsection
@section('content')
    <div class="col-md-12 m-b-10">
        <div class="form-group">
            <label class="control-label page-label col-md-3"><span class="text-purple">* </span>Навигация:</label>
            <div class="col-md-4">
                <select class="form-control select2 product-categories-select" name="navigations">
                    @foreach($navigations as $nav)
                        <option value="{{ $nav->id }}" {{($navigation->id==$nav->id) ? 'selected': ''}}>{{ $nav->translations->firstWhere('language_id',1)->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-xs-12 p-0">
        <div class="bg-grey top-search-bar">
            <div class="checkbox-all pull-left p-10 p-l-0">
                <div class="pretty p-default p-square">
                    <input type="checkbox" id="selectAll" class="tooltips" data-toggle="tooltip" data-placement="right" data-original-title="Маркира/Демаркира всички елементи" data-trigger="hover"/>
                    <div class="state p-primary">
                        <label></label>
                    </div>
                </div>
            </div>
            <div class="collapse-buttons pull-left p-7">
                <a class="btn btn-xs expand-btn"><i class="fas fa-angle-down fa-2x" class="tooltips" data-toggle="tooltip" data-placement="right" data-original-title="Разпъва всички маркирани елементи"></i></a>
                <a class="btn btn-xs collapse-btn hidden"><i class="fas fa-angle-up fa-2x" class="tooltips" data-toggle="tooltip" data-placement="right" data-original-title="Прибира всички маркирани елементи"></i></a>
            </div>
            <div class="search pull-left hidden-xs">
                <div class="input-group">
                    <input type="text" name="search" class="form-control input-sm search-text" placeholder="Търси">
                    <span class="input-group-btn">
					<button class="btn btn-sm submit"><i class="fa fa-search"></i></button>
				</span>
                </div>
            </div>

            <div class="action-mass-buttons pull-right">
                <a href="{{ url('/admin/product_categories/'.Request::segment(4).'/create') }}" role="button" class="btn btn-lg tooltips green" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Създай нов">
                    <i class="fas fa-plus"></i>
                </a>
                <a href="{{ url('/admin/product_categories/active/multiple/0/') }}" class="btn btn-lg tooltips light-grey-eye mass-unvisible" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Маркирай всички селектирани като НЕ активни/видими">
                    <i class="far fa-eye-slash"></i>
                </a>
                <a href="{{ url('/admin/product_categories/active/multiple/1/') }}" class="btn btn-lg tooltips grey-eye mass-visible" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Маркирай всички селектирани като активни/видими">
                    <i class="far fa-eye"></i>
                </a>
                <a href="#" class="btn btn-lg tooltips red mass-delete">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <div class="hidden" id="mass-delete-url">{{ url('/admin/product_categories/delete/multiple/') }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <th class="width-2-percent"></th>
                    <th class="width-2-percent">Ред</th>
                    <th>Заглавие</th>
                    <th class="width-220">Действия</th>
                    </thead>
                    <tbody>
                    @if(count($productCategories))
                        <?php $i = 1;?>
                        @foreach($productCategories as $productCategory)
                            <?php
                            $navDefaultTtanslation = $productCategory->translations()->where('language_id', 1)->first();
                            ?>
                            <tr class="t-row row-{{$productCategory->id}}">
                                <td class="width-2-percent">
                                    <div class="pretty p-default p-square">
                                        <input type="checkbox" class="checkbox-row" name="check[]" value="{{$productCategory->id}}"/>
                                        <div class="state p-primary">
                                            <label></label>
                                        </div>
                                    </div>
                                </td>
                                <td class="width-2-percent">{{$i}}</td>
                                <td>
                                    <span class="text-uppercase">{{ $navDefaultTtanslation->language->code }}: </span>
                                    {{ $navDefaultTtanslation->title }}
                                </td>
                                <td class="pull-right">
                                    <a href="{{ url('/admin/product_categories/'.$productCategory->id.'/edit') }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="public-view btn hidden-xs light-grey-eye visibility-activate" modal-link="{{ url('/admin/publicView/product_categories/'.$productCategory->id) }}"><i class="fas fa-desktop"></i></a>
                                    @if(!$productCategory->active)
                                        <a href="{{ url('/admin/product_categories/active/'.$productCategory->id.'/1') }}" role="button" class="btn light-grey-eye visibility-activate"><i class="far fa-eye-slash"></i></a>
                                    @else
                                        <a href="{{ url('/admin/product_categories/active/'.$productCategory->id.'/0') }}" role="button" class="btn grey-eye visibility-unactive"><i class="far fa-eye"></i></a>
                                    @endif
                                    @if($i !== 1)
                                        <a href="{{ url('/admin/product_categories/move/up/'.$productCategory->id) }}" role="button" class="move-up btn yellow"><i class="fas fa-angle-up"></i></a>
                                    @endif
                                    @if($i != count($productCategories))
                                        <a href="{{ url('/admin/product_categories/move/down/'.$productCategory->id) }}" role="button" class="move-down btn yellow"><i class="fas fa-angle-down"></i></a>
                                    @endif
                                    <a href="{{ url('/admin/product_categories/'.$productCategory->id.'/delete') }}" class="btn red" data-toggle="confirmation"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            <tr class="t-row-details row-{{$productCategory->id}}-details hidden">
                                <td colspan="2"></td>
                                <td colspan="1">
                                    <table class="table-details-titles">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <p><span class="text-uppercase">{{ $navDefaultTtanslation->language->code }}: </span>
                                                    {{ $navDefaultTtanslation->title }}</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table-details">
                                        <tbody>
                                        <tr>
                                            <td width="28%">SEO:
                                                @if ($navDefaultTtanslation->seo_description != "")
                                                    <span class="text-purple"><i class="fa fa-check"></i></span>
                                                @else
                                                    <span class="font-grey"><i class="fa fa-times"></i></span>
                                                @endif
                                            </td>
                                            <td width="19%">снимки в хедър:
                                                <span class="text-purple">{{$productCategory->in_header}}</span>
                                            </td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table-details-buttons">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <span class="margin-right-10">SEO</span>
                                                <a class="btn btn-sm green" href="{{ url('/admin/seo/product_categories/'.$productCategory->id.'/edit') }}" role="button"><i class="fas fa-pencil-alt"></i></a>
                                            </td>
                                            <td>
                                                <span class="margin-right-10">Галерия</span>
                                                <a class="btn btn-sm green" href="{{ url('/admin/galleries/'.$galleryProductTypeId.'/'.$productCategory->id.'/create') }}" role="button"><i class="fa fa-plus"></i></a>
                                                <a class="btn btn-sm purple-a" href="{{ url('/admin/galleries/loadGalleries/'.$galleryProductTypeId.'/'.$productCategory->id.'/') }}" role="button"><i class="fa fa-bars"></i></a>
                                            </td>
                                            <td>
                                                <span class="margin-right-10">Продукти</span>
                                                <a class="btn btn-sm green" href="{{ url('/admin/products/'.$productCategory->id.'/create') }}" role="button"><i class="fa fa-plus"></i></a>
                                                <a class="btn btn-sm purple-a" href="{{ url('/admin/products/loadProducts/'.$productCategory->id) }}" role="button"><i class="fa fa-bars"></i></a>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="width-220">
                                    <img class="thumbnail img-responsive" src="{{ $productCategory->fullImageFilePathUrl() }}"/>
                                </td>
                            </tr>
                            <?php $i++;?>
                        @endforeach
                        <tr style="display: none;">
                            <td colspan="4" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="4" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
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
