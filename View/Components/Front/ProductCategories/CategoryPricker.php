<?php

    namespace Modules\Shop\View\Components\Front\ProductCategories;

    use Illuminate\View\Component;

    class CategoryPricker extends Component
    {
        public $categories;
        public $languageSlug;

        public function __construct($categories, $languageSlug)
        {
            $this->languageSlug = $languageSlug;
            $this->categories   = $categories->map(function ($category) {
                $categoryTranslation = $category->translate($this->languageSlug);
                if (!is_null($categoryTranslation)) {
                    $this->setCategoryParams($categoryTranslation, $category);

                    if ($category->subCategories->isNotEmpty()) {
                        $category->subCategories = $category->subCategories->map(function ($subCategory) {
                            $subCategoryTranslation = $subCategory->translate($this->languageSlug);
                            if (!is_null($subCategoryTranslation)) {
                                $this->setCategoryParams($subCategoryTranslation, $subCategory);

                                return $subCategory;
                            }

                            return null;
                        })->filter();
                    }

                    return $category;
                }

                return null;
            })->filter();
        }

        private function setCategoryParams($categoryTranslation, $category): void
        {
            $category->isActive = url()->current() == url($this->languageSlug . '/' . $categoryTranslation->url);
            $category->url      = url($this->languageSlug . '/' . $categoryTranslation->url);
            // Assuming title is part of the translated attributes
            $category->title   = $categoryTranslation->title ?? $category->title;
            $category->fileUrl = $category->getFileUrl();
        }

        public function render()
        {
            return view('shop::components.front\productcategories\categorypricker');
        }
    }
