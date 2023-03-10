@extends('layouts.app')

@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        try {
            CKEDITOR.timestamp = new Date();
            CKEDITOR.replace('editor');
        } catch {
        }
        $(".select2").select2({language: "bg"});
    </script>
@endsection

@section('content')
    <form class="my-form" action="{{ route('products.characteristics.update', ['id'=>$productCharacteristic->id]) }}" method="POST" data-form-type="store" enctype="multipart/form-data">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="position" value="{{(old('position')) ?: $productCharacteristic->position}}">

            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ url()->previous() }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <ul class="nav nav-tabs">
                    @foreach($languages as $language)
                        <li @if($language->code == env('DEF_LANG_CODE')) class="active" @endif}}><a data-toggle="tab" href="#{{$language->code}}">{{$language->code}} <span class="err-span-{{$language->code}} hidden text-purple"><i class="fas fa-exclamation"></i></span></a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($languages as $language)
                        @php
                            $langTitle = 'title_'.$language->code;
                            $productCharacteristicTranslation = (is_null($productCharacteristic->translations->where('language_id', $language->id)->first())) ? null: $productCharacteristic->translations->where('language_id', $language->id)->first()
                        @endphp
                        <div id="{{$language->code}}" class="tab-pane fade in @if($language->code == env('DEF_LANG_CODE')) active @endif}}">
                            <div class="form-group @if($errors->has($langTitle)) has-error @endif">
                                <label class="control-label p-b-10">???????????????? (<span class="text-uppercase">{{$language->code}}</span>):</label>
                                <input class="form-control" type="text" name="{{$langTitle}}" value="{{ old($langTitle) ?: (!is_null($productCharacteristicTranslation) ? $productCharacteristicTranslation->title : '') }}">
                                @if($errors->has($langTitle))
                                    <span class="help-block">{{ trans($errors->first($langTitle)) }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form form-horizontal">
                    <div class="form-body">
                        <hr>
                        <div style="display: flex; justify-content: space-between;">
                            <h4>?????????????????? ?????? ???????????????????? ??????????????????</h4>
                            <div style="display: flex;">
                                <div class="checkbox-all pull-left p-10 p-l-0">
                                    <div class="pretty p-default p-square">
                                        <input type="checkbox" id="selectAll" class="tooltips" data-toggle="tooltip" data-placement="auto" data-original-title="??????????????/?????????????????? ???????????? ????????????????????" data-trigger="hover"/>
                                        <div class="state p-primary">
                                            <label>????????????????/???????????????????? ???????????? ??????????????????</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex">
                            @forelse($productCategories as $category)
                                <div class="pretty p-default p-square">
                                    <input type="checkbox" class="checkbox-row" name="productCategories[]" value="{{$category->id}}" {{ in_array($category->id, $selectedProductCategories) ? 'checked':'' }}/>
                                    <div class="state p-primary">
                                        <label>{{ $category->defaultTranslation->title }}</label>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-warning">???????? ???????????????? ?????? ?????????????? ??????????????????</div>
                            @endforelse
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-md-3">?????????????? (??????????) ?? ??????????:</label>
                            <div class="col-md-6">
                                <label class="switch pull-left">
                                    <input type="checkbox" name="active" class="success" data-size="small" {{(old('active') ? 'checked' : ((!is_null($productCharacteristic) && $productCharacteristic->active) ? 'checked': 'active'))}}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-md-3">?????????????? ?? ??????????:</label>
                            <div class="col-md-6">
                                <p class="position-label">??? {{ $productCharacteristic->position }}</p>
                                <a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal">????????, ???????????????? ??????????????</a>
                                <p class="help-block">(?????? ???? ???????????????? ??????????????, ?????????????? ???? ???????????? ???????? ????????????????)</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="submit" value="submit" class="btn save-btn margin-bottom-10"><i class="fas fa-save"></i> ????????????</button>
                                <a href="{{ url()->previous() }}" role="button" class="btn back-btn margin-bottom-10"><i class="fa fa-reply"></i> ??????????</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close text-purple" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">???????????????? ??????????????</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-hover table-positions">
                                <table class="table table-striped table-hover table-positions">
                                    <tbody>
                                    @if(count($characteristics))
                                        @foreach($characteristics as $characteristic)
                                            <tr class="pickPositionTr" data-position="{{$characteristic->position}}">
                                                <td>{{$characteristic->position}}</td>
                                                <td>{{$characteristic->defaultTranslation->title}}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="pickPositionTr" data-position="{{$characteristics->last()->position+1}}">
                                            <td>{{$characteristics->last()->position+1}}</td>
                                            <td>--{{trans('administration_messages.last_position')}}--</td>
                                        </tr>
                                    @else
                                        <tr class="pickPositionTr" data-position="1">
                                            <td>1</td>
                                            <td>--{{trans('administration_messages.last_position')}}--</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </table>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <a href="#" class="btn save-btn margin-bottom-10 accept-position-change" data-dismiss="modal"><i class="fas fa-save"></i> ????????????????</a>
                                        <a role="button" class="btn back-btn margin-bottom-10 cancel-position-change" current-position="{{ $productCharacteristic->position }}" data-dismiss="modal"><i class="fa fa-reply"></i> ??????????</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
    </div>
@endsection
