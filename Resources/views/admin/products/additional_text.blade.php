@php
    $fieldNumberWord = ($i==1) ? 'first' : (($i==2) ? 'secound' : (($i==3) ? 'third' : (($i==4) ? 'fourth' : (($i==5) ? 'fifth' : (($i==6) ? 'sixth' : '')))));
    $langTitleAdditional = 'title_additional_'.$fieldNumberWord.'_' . $language->code;
    $langDescriptionAdditional = 'text_additional_'.$fieldNumberWord.'_' . $language->code;
@endphp
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion-{{$language->id}}" href="#collapse-{{$language->id}}-{{$i}}" class="panel-title">
            <a href="#">Допълнително заглавие и текст {{ $i }} {{ old($langTitleAdditional) ? old($langTitleAdditional) : (!is_null($productTranslation) ? '| '.$productTranslation->{'title_additional_'.$fieldNumberWord} : '') }}</a>
        </h4>
    </div>
    <div id="collapse-{{$language->id}}-{{$i}}" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="form-group @if($errors->has($langTitleAdditional)) has-error @endif">
                <label class="control-label p-b-10">Заглавие (<span class="text-uppercase">{{$language->code}}</span>):</label>
                <input class="form-control" type="text" name="{{$langTitleAdditional}}" value="{{ old($langTitleAdditional) ? old($langTitleAdditional) : (!is_null($productTranslation) ? $productTranslation->{'title_additional_'.$fieldNumberWord} : '') }}">
                @if($errors->has($langTitleAdditional))
                    <span class="help-block">{{ trans($errors->first($langTitleAdditional)) }}</span>
                @endif
            </div>
            <div class="form-group @if($errors->has($langDescriptionAdditional)) has-error @endif">
                <textarea name="{{$langDescriptionAdditional}}" class="ckeditor col-xs-12" rows="9">
                    {{ old($langDescriptionAdditional) ? old($langDescriptionAdditional) : (!is_null($productTranslation) ? $productTranslation->{'text_additional_'.$fieldNumberWord} : '') }}
                </textarea>
                @if($errors->has($langDescriptionAdditional))
                    <span class="help-block">{{ trans($errors->first($langDescriptionAdditionals)) }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
