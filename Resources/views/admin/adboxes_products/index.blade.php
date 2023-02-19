@extends('layouts.admin.app')
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

        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                placement: 'auto',
                trigger: 'hover',
                html: true
            });
        });
    </script>
@endsection
@section('content')
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
                <a href="{{ url('/admin/product_adboxes/active/multiple/0/') }}" class="btn btn-lg tooltips light-grey-eye mass-unvisible" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Маркирай всички селектирани като НЕ активни/видими">
                    <i class="far fa-eye-slash"></i>
                </a>
                <a href="{{ url('/admin/product_adboxes/active/multiple/1/') }}" class="btn btn-lg tooltips grey-eye mass-visible" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Маркирай всички селектирани като активни/видими">
                    <i class="far fa-eye"></i>
                </a>
                <a href="#" class="btn btn-lg tooltips red mass-delete">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <div class="hidden" id="mass-delete-url">{{ url('/admin/product_adboxes/delete/multiple/') }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>Продуктови карета очакващи действие</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <th class="width-2-percent"></th>
                    <th class="width-2-percent">Ред</th>
                    <th class="width-130">Статус</th>
                    <th>Заглавие</th>
                    <th class="width-220">Действия</th>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @forelse ($adBoxesWaitingAction as $adBoxWaitingAction)
                            <?php
                            $adBoxWaitingActionTranslation = $adBoxWaitingAction->getTranslation(1)->first();
                            ?>
                        <tr class="t-row row-{{$adBoxWaitingAction->id}}">
                            <td class="width-2-percent">
                                <div class="pretty p-default p-square">
                                    <input type="checkbox" class="checkbox-row" name="check[]" value="{{$adBoxWaitingAction->id}}"/>
                                    <div class="state p-primary">
                                        <label></label>
                                    </div>
                                </div>
                            </td>
                            <td class="width-2-percent">{{$i}}</td>
                            <td><label class="label label-default">{{ trans('administration_messages.adboxes_type_0') }}</label></td>
                            <td>
                                <span class="text-uppercase">{{ $adBoxWaitingActionTranslation->language->code }}: </span>
                                {{ $adBoxWaitingActionTranslation->title }}
                            </td>
                            <td class="pull-right">
                                <a href="{{ url('/admin/product_adboxes/'.$adBoxWaitingAction->id.'/edit') }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                                <a href="{{ url('/admin/product_adboxes/'.$adBoxWaitingAction->id.'/delete') }}" class="btn red" data-toggle="confirmation"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <tr class="t-row-details row-{{$adBoxWaitingAction->id}}-details hidden">
                            <td colspan="2"></td>
                            <td colspan="2"></td>
                            <td class="width-220"></td>
                        </tr>
                            <?php $i++; ?>
                    @empty
                        <tr>
                            <td colspan="5" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>Продуктови карета: {{ trans('administration_messages.adboxes_type_1') }}</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <th class="width-2-percent"></th>
                    <th class="width-2-percent">Ред</th>
                    <th class="width-130">Тип каре</th>
                    <th>Заглавие</th>
                    <th class="width-220">Действия</th>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @forelse ($adBoxesFirstType as $adBoxFirstType)
                            <?php
                            $adBoxFirstTypeTranslation = $adBoxFirstType->getTranslation(1)->first();
                            ?>
                        <tr class="t-row row-{{$adBoxFirstType->id}}">
                            <td class="width-2-percent">
                                <div class="pretty p-default p-square">
                                    <input type="checkbox" class="checkbox-row" name="check[]" value="{{$adBoxFirstType->id}}"/>
                                    <div class="state p-primary">
                                        <label></label>
                                    </div>
                                </div>
                            </td>
                            <td class="width-2-percent">{{$i}}</td>
                            <td><label class="label btn-light-green">{{ trans('administration_messages.adboxes_type_1') }}</label></td>
                            <td>
                                <span class="text-uppercase">{{ $adBoxFirstTypeTranslation->language->code }}: </span>
                                {{ $adBoxFirstTypeTranslation->title }}
                            </td>
                            <td class="pull-right">
                                <a href="{{ url('/admin/product_adboxes/'.$adBoxFirstType->id.'/edit') }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                                @if(!$adBoxFirstType->active)
                                    <a href="{{ url('/admin/product_adboxes/active/'.$adBoxFirstType->id.'/1') }}" role="button" class="btn light-grey-eye visibility-activate"><i class="far fa-eye-slash"></i></a>
                                @else
                                    <a href="{{ url('/admin/product_adboxes/active/'.$adBoxFirstType->id.'/0') }}" role="button" class="btn grey-eye visibility-unactive"><i class="far fa-eye"></i></a>
                                @endif
                                @if($i !== 1)
                                    <a href="{{ url('/admin/product_adboxes/move/up/'.$adBoxFirstType->id) }}" role="button" class="move-up btn yellow"><i class="fas fa-angle-up"></i></a>
                                @endif
                                @if($i != count($adBoxesFirstType))
                                    <a href="{{ url('/admin/product_adboxes/move/down/'.$adBoxFirstType->id) }}" role="button" class="move-down btn yellow"><i class="fas fa-angle-down"></i></a>
                                @endif
                                <a href="{{ url('/admin/product_adboxes/'.$adBoxFirstType->id.'/delete') }}" class="btn red" data-toggle="confirmation"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <tr class="t-row-details row-{{$adBoxFirstType->id}}-details hidden">
                            <td colspan="2"></td>
                            <td colspan="2">
                                <table class="table-details">
                                    <tbody>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="width-220">

                            </td>
                        </tr>
                            <?php $i++; ?>
                    @empty
                        <tr>
                            <td colspan="5" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
