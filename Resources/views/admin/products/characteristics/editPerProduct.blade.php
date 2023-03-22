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
    <form action="{{ route('products.characteristics-by-product.update', ['id'=> $mainProduct->id]) }}" method="POST">
        @csrf
        <div class="col-xs-12 p-0">
            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" href="#" class="btn btn-lg btn-light-blue m-b-0" role="button"><i class="fas fa-sync tooltips" data-toggle="tooltip" data-placement="auto" data-original-title="Обнови промените"></i></button>
                    <a href="{{ url()->previous() }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <th class="width-2-percent">Ред</th>
                        <th>Заглавие</th>
                        <th>Стойност</th>
                        </thead>
                        <tbody>
                        @if(count($characteristics))
                            <?php $i = 1;?>
                            @foreach($characteristics as $characteristic)
                                <?php
                                $characteristicDefaultTranslation = $characteristic->characteristic->defaultTranslation;
                                if (is_null($characteristicDefaultTranslation)) {
                                    continue;
                                }
                                ?>
                                <tr class="t-row row-{{$characteristic->id}}">
                                    <td class="width-2-percent text-center">{{$i}}</td>
                                    <td>
                                        <span class="text-uppercase">{{ $characteristicDefaultTranslation->language->code }}: </span>
                                        {{ $characteristicDefaultTranslation->title}}
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="characteristicValue[{{ $characteristic->characteristic->id }}]" value="{{ (is_null($characteristic->value)) ? '': $characteristic->value->value  }}">
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
    </form>
@endsection
