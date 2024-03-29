<div class="category-picker">
    <ul>
        @foreach($categories as $category)
            <li data-aos="fade-up" class="{{ $category->isActive ? 'active':'' }}">
                <a href="{{ $category->url }}">
                    <img src="{{ $category->fileUrl }}" alt="{{ $category->title }}">

                    <span>{{ $category->title }}</span>
                </a>
            </li>
            @if($category->subCategories->isNotEmpty())
                @foreach($category->subCategories as $subCategory)
                    <li data-aos="fade-up" class="{{ $subCategory->isActive ? 'active':'' }}">
                        <a href="{{ $subCategory->url }}">
                            <img src="{{ $subCategory->fileUrl }}" alt="{{ $subCategory->title }}">

                            <span>{{ $subCategory->title }}</span>
                        </a>
                    </li>
                @endforeach
            @endif
        @endforeach
    </ul>
</div>
