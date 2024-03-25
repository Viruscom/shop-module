@if(!is_null($icons))
    <ul class="list-alergens">
        @foreach($icons as $icon)
                <?php
                $iconTranslation = $icon->translate($languageSlug);
                if (is_null($iconTranslation)) {
                    continue;
                }
                ?>
            <li>
                <div class="list-tooltip top-center">
                    <h4>{{ $iconTranslation->title }}</h4>
                    @if($iconTranslation->short_description != '')
                        <p>{!! $iconTranslation->short_description !!}</p>
                    @endif
                </div>
                <img src="{{ $icon->getFileUrl() }}" alt="">
            </li>
        @endforeach
    </ul>
@endif
