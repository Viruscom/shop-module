<?php

    namespace Modules\Shop\View\Components\Front\Basket\StepOne;

    use Illuminate\View\Component;
    use Modules\Shop\Models\Shop;

    class BasketSummary extends Component
    {
        public $basket;
        public $totalDefaultFormatted;
        public $totalDiscountedFormatted;
        public $totalDiscountsFormatted;
        public $promoCode;

        /**
         * Create a new component instance.
         *
         * @return void
         */
        public function __construct($basket)
        {
            $this->basket                   = $basket;
            $this->totalDefaultFormatted    = $this->formatPrice($basket->total_default);
            $this->totalDiscountedFormatted = $this->formatPrice($basket->total_discounted);
            $this->totalDiscountsFormatted  = $this->formatPrice($basket->total_default - $basket->total_discounted);
            $this->promoCode                = $this->basket->promo_code;
        }

        private function formatPrice($price)
        {
            return Shop::formatPrice($price);
        }

        public function render()
        {
            return view('shop::components.front.basket.step_one.basket_summary', [
                'basket'                   => $this->basket,
                'totalDefaultFormatted'    => $this->totalDefaultFormatted,
                'totalDiscountedFormatted' => $this->totalDiscountedFormatted,
                'totalDiscounts'           => $this->totalDiscountsFormatted,
            ]);
        }
    }
