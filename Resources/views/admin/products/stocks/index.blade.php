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
            {{--            <div class="checkbox-all pull-left p-10 p-l-0">--}}
            {{--                <div class="pretty p-default p-square">--}}
            {{--                    <input type="checkbox" id="selectAll" class="tooltips" data-toggle="tooltip" data-placement="right" data-original-title="Маркира/Демаркира всички елементи" data-trigger="hover"/>--}}
            {{--                    <div class="state p-primary">--}}
            {{--                        <label></label>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="collapse-buttons pull-left p-7">--}}
            {{--                <a class="btn btn-xs expand-btn"><i class="fas fa-angle-down fa-2x" class="tooltips" data-toggle="tooltip" data-placement="right" data-original-title="Разпъва всички маркирани елементи"></i></a>--}}
            {{--                <a class="btn btn-xs collapse-btn hidden"><i class="fas fa-angle-up fa-2x" class="tooltips" data-toggle="tooltip" data-placement="right" data-original-title="Прибира всички маркирани елементи"></i></a>--}}
            {{--            </div>--}}

            <div class="action-mass-buttons pull-right">
                <a href="{{ route('products.stocks.internal_suppliers.create') }}" role="button" class="btn btn-lg tooltips green" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Създай нов снабдител">
                    <i class="fas fa-plus"></i>
                </a>
                {{--                <a href="{{ url('/admin/contents/active/multiple/0/') }}" class="btn btn-lg tooltips light-grey-eye mass-unvisible" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Маркирай всички селектирани като НЕ активни/видими">--}}
                {{--                    <i class="far fa-eye-slash"></i>--}}
                {{--                </a>--}}
                {{--                <a href="{{ url('/admin/contents/active/multiple/1/') }}" class="btn btn-lg tooltips grey-eye mass-visible" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Маркирай всички селектирани като активни/видими">--}}
                {{--                    <i class="far fa-eye"></i>--}}
                {{--                </a>--}}
                <a href="{{ route('products.stocks.internal_suppliers.index') }}" class="btn btn-lg tooltips btn-light-blue m-b-0" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Виж всички снабдители">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <a href="{{ route('products.stocks.internal_suppliers.archived') }}" class="btn btn-lg tooltips btn-light-blue m-b-0" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Виж всички архивирани снабдители">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <a href="{{ route('products.stocks.movements.index') }}" class="btn btn-lg tooltips btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Виж всички движения"><i class="fas fa-history"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 mt-3 m-b-40">
            <h4>Филтър</h4>
            <div class="bg-grey p-2" style="display: flex;justify-content: space-between;height: auto;flex-direction: column;padding: 10px;">
                <div style="display: flex;">
                    <input type="text" name="name" class="form-control" placeholder="Въведете име на продукт" autocomplete="off">
                    <input type="text" name="sku" class="form-control" placeholder="Въведете SKU номер" autocomplete="off">
                    <select type="text" name="category_id" class="form-control">
                        <option value="">---Моля, изберете категория---</option>
                        @foreach($productCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->defaultTranslation->title }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary submit m-l-5"><i class="fa fa-search"></i></button>
                </div>
                <div class="m-t-10" style="display: flex;">
                    @foreach($productAttributes as $attribute)
                        <div>
                            <label for="">{{ $attribute->defaultTranslation->title }}</label>
                            <select name="" id="" class="form-control">
                                <option value="">---Моля, изберете---</option>
                                @foreach($productAttributeValues as $attributeId=>$valuesArray)
                                    @if($attributeId == $attribute->id)
                                        @foreach($valuesArray as $key=>$value)
                                            <option value="{{ $value->id }}">{{ $value->defaultTranslation->title }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <th class="width-2-percent"></th>
                    <th class="width-2-percent">Ред</th>
                    <th>Заглавие</th>
                    <th class="width-130 text-right">SKU номер</th>
                    <th class="width-130 text-right">Наличност</th>
                    <th class="width-130 text-right">Действия</th>
                    </thead>
                    <tbody>
                    <?php $i = 1;?>
                    @foreach($products as $product)
                        <?php
                        $productDefaultTranslation = $product->defaultTranslation;
                        if (is_null($productDefaultTranslation)) {
                            continue;
                        }
                        $combosCount = count($product->combos);
                        ?>
                        <tr class="t-row row-{{$product->id}}">
                            <td class="width-2-percent"></td>
                            <td class="width-2-percent">{{$i}}</td>
                            <td>
                                <img src="{{ $product->fullImageFilePathUrl() }}" height="30" class="m-r-5">
                                {{ $productDefaultTranslation->title}}
                                @if($combosCount > 0)
                                @endif
                            </td>
                            <td class="width-130 text-right">{{ $product->product_id_code }}</td>
                            <td class="width-130 text-right">
                                <input type="number" value="{{ $product->units_in_stock }}" name="new_quantity" style="width: 90px">
                            </td>
                            <td class="pull-right">
                                <a href="#" class="btn tooltips btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Виж всички движения за продукта"><i class="fas fa-history"></i></a>
                            </td>
                        </tr>
                        @if($combosCount > 0)
                            <tr class="t-row-details row-{{$product->id}}-details hidden">
                                <td colspan="6" class="p-0">
                                    <div style="padding: 0px 2%;border-top: 1px solid #c8286440;">
                                        <h4>Продуктови комбинации</h4>
                                    </div>
                                    <table style="min-width: 100%; max-width: 100%;">
                                        <tbody>
                                        @foreach($product->combos as $combo)
                                            <tr class="product-combos-tr">
                                                <td class="width-2-percent"></td>
                                                <td class="width-2-percent"></td>
                                                <td>
                                                    <div>{{ $productDefaultTranslation->title }}</div>
                                                    <div class="combination-details">
                                                        @foreach($combo->combination as $key=>$combinationValue)
                                                            @if($combinationValue != $product->id)
                                                                @foreach($productAttributeValues as $productAttributeId=>$attributeValueArray)
                                                                    @foreach($attributeValueArray as $attributeValue)
                                                                        @if($attributeValue->id == $combinationValue)
                                                                            <div>
                                                                                <span>{{ $attributeValue->productAttribute->defaultTranslation->title }}:</span>
                                                                                <span>{{ $attributeValue->defaultTranslation->title }}</span>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="width-130 text-right">{{ $combo->sku }}</td>
                                                <td class="width-130 text-right">
                                                    <input type="number" value="{{ $combo->quantity }}" name="new_quantity" style="width: 90px">
                                                </td>
                                                <td class="width-130 text-right">
                                                    <a href="#" class="btn tooltips btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Виж всички движения за продукта"><i class="fas fa-history"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </td>

                            </tr>
                        @endif
                        <?php $i++;?>
                    @endforeach
                    <tr style="display: none;">
                        <td colspan="5" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
