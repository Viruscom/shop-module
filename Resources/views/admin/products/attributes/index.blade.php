@extends('layouts.app')
@section('scripts')
    <script src="{{ asset('admin/js/bootstrap-confirmation.js') }}"></script>
    <script>
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            container: 'body',
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
                <a href="{{ route('products.attributes.create') }}" role="button" class="btn btn-lg tooltips green" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Създай нов">
                    <i class="fas fa-plus"></i>
                </a>
                <a href="#" class="btn btn-lg tooltips red mass-delete">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <div class="hidden" id="mass-delete-url">{{ route('products.attributes.delete-multiple') }}</div>
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
                    <th class="width-220 text-right">Действия</th>
                    </thead>
                    <tbody>
                    @if(!is_null($productAttributes))
                        <?php $i = 1;?>
                        @foreach($productAttributes as $attribute)
                            <?php
                            $attributeDefaultTranslation = $attribute->defaultTranslation;
                            if (is_null($attributeDefaultTranslation)) {
                                continue;
                            }
                            ?>
                            <tr class="t-row row-{{$attribute->id}}">
                                <td class="width-2-percent">
                                    <div class="pretty p-default p-square">
                                        <input type="checkbox" class="checkbox-row" name="characteristic[]" value="{{$attribute->id}}"/>
                                        <div class="state p-primary">
                                            <label></label>
                                        </div>
                                    </div>
                                </td>
                                <td class="width-2-percent">{{$i}}</td>
                                <td>
                                    <span class="text-uppercase">{{ $attributeDefaultTranslation->language->code }}: </span>
                                    {{ $attributeDefaultTranslation->title}}
                                </td>
                                <td class="pull-right">
                                    <a class="btn purple-a" href="{{ route('products.attributes.values.index', ['attr_id'=> $attribute->id]) }}" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="Стойности на атрибута"><i class="fa fa-bars"></i></a>

                                    <a href="{{ route('products.attributes.edit',['id'=>$attribute->id]) }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                                    @if($i !== 1)
                                        <a href="{{ route('products.attributes.move-up', ['id'=>$attribute->id]) }}" role="button" class="move-up btn yellow"><i class="fas fa-angle-up"></i></a>
                                    @endif
                                    @if($i != count($productAttributes))
                                        <a href="{{ route('products.attributes.move-down', ['id'=>$attribute->id]) }}" role="button" class="move-down btn yellow"><i class="fas fa-angle-down"></i></a>
                                    @endif
                                    <a href="{{ route('products.attributes.delete', ['id'=>$attribute->id]) }}" class="btn red" data-toggle="confirmation"><i class="fas fa-trash-alt"></i></a>
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
@endsection
