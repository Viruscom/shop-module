<div class="category-picker">
    <ul>
        @foreach($categories as $category)
            @php
                $categoryTranslation = $category->translate($languageSlug);
                if (is_null($categoryTranslation)) {
                    continue;
                }
            @endphp
            <li data-aos="fade-up" class="{{ url()->current() == url($languageSlug . '/' . $categoryTranslation->url) ? 'active' : '' }}">
                <a href="{{ url($languageSlug . '/' . $categoryTranslation->url) }}">
                    <img src="{{ $category->getFileUrl() }}" alt="{{ $category->title }}">

                    <span>{{ $category->title }}</span>
                </a>
            </li>
            @if($category->subCategories->isNotEmpty())
                @foreach($category->subCategories as $subCategory)
                    @php
                        $subCategoryTranslation = $subCategory->translate($languageSlug);
                        if (is_null($subCategoryTranslation)) {
                            continue;
                        }
                    @endphp
                    <li data-aos="fade-up" class="{{ url()->current() == url($languageSlug . '/' . $subCategoryTranslation->url) ? 'active' : '' }}">
                        <a href="{{ url($languageSlug . '/' . $subCategoryTranslation->url) }}">
                            <img src="{{ $subCategory->getFileUrl() }}" alt="{{ $subCategory->title }}">

                            <span>{{ $subCategory->title }}</span>
                        </a>
                    </li>
                @endforeach
            @endif
        @endforeach
    </ul>
</div>

