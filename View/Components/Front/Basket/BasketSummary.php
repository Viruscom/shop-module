<?php

    namespace Modules\Shop\View\Components\Front\Basket;

    use Illuminate\View\Component;
    use Illuminate\View\View;
    use Modules\Shop\Models\Shop;

    class BasketSummary extends Component
    {
        public $basket;
        public $totalDefaultFormatted;
        public $totalDiscountedFormatted;
        public $totalDiscountsFormatted;

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
        }

        private function formatPrice($price)
        {
            return Shop::formatPrice($price);
        }

        /**
         * Get the view / contents that represent the component.
         *
         * @return View|string
         */
        public function render()
        {
            return view('shop::components.front\basket\step_one\basket_summary');
        }
    }
