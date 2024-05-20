<?php

    namespace Modules\Shop\View\Components\Front\Basket\StepOne;

    use Illuminate\Support\Facades\Auth;
    use Illuminate\View\Component;

    class BasketStepOneFavIcon extends Component
    {
        public $isGuest;
        public $isInFavoriteProducts;
        public $basketProduct;
        public $basketProductId;
        public $languageSlug;

        /**
         * Create a new component instance.
         *
         * @return void
         */
        public function __construct($languageSlug, $basketProduct)
        {
            $this->isGuest              = Auth::guard('shop')->guest();
            $this->languageSlug         = $languageSlug;
            $this->basketProduct        = $basketProduct;
            $this->basketProductId      = $basketProduct->product->id;
            $this->isInFavoriteProducts = $basketProduct->product->isInFavoriteProducts();
        }

        public function render()
        {
            if ($this->isGuest) {
                return null;
            }

            return view('shop::components.front.basket.step_one.basket_step_one_favicon', [
                'isInFavoriteProducts' => $this->isInFavoriteProducts,
                'basketProductId'      => $this->basketProductId
            ]);
        }
    }
