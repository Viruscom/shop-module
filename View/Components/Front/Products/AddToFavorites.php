<?php

    namespace Modules\Shop\View\Components\Front\Products;

    use Auth;
    use Illuminate\View\Component;
    use Illuminate\View\View;

    class AddToFavorites extends Component
    {
        public $languageSlug;
        public $product;

        /**
         * Create a new component instance.
         *
         * @return void
         */
        public function __construct($languageSlug, $product)
        {
            $this->languageSlug = $languageSlug;
            $this->product      = $product;
        }

        /**
         * Get the view / contents that represent the component.
         *
         * @return View|string
         */
        public function render()
        {
            if (Auth::guard('shop')->guest()) {
                return null;
            } else {
                if (!$this->product->isInFavoriteProducts()) {
                    return view('shop::components.front\products\add_to_favorites');
                }

                return view('shop::components.front\products\remove_from_favorites');
            }
        }
    }
