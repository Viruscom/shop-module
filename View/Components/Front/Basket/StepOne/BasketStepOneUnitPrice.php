<?php

    namespace Modules\Shop\View\Components\Front\Basket\StepOne;

    use Illuminate\View\Component;
    use Modules\Shop\Models\Shop;

    class BasketStepOneUnitPrice extends Component
    {
        public $vatAppliedDefaultPrice;
        public $vatAppliedDiscountedPrice;

        /**
         * Create a new component instance.
         *
         * @return void
         */
        public function __construct($basketProduct)
        {
            $this->vatAppliedDefaultPrice    = $this->formatPrice($basketProduct->vat_applied_default_price);
            $this->vatAppliedDiscountedPrice = $this->formatPrice($basketProduct->vat_applied_discounted_price);
        }

        private function formatPrice($price): string
        {
            return Shop::formatPrice($price);
        }

        /**
         * Get the view / contents that represent the component.
         *
         * @return \Illuminate\View\View|string
         */
        public function render()
        {
            return view('shop::components.front.basket.step_one.basket_step_one_unit_price', [
                'vatAppliedDiscountedPrice' => $this->vatAppliedDiscountedPrice,
                'vatAppliedDefaultPrice'    => $this->vatAppliedDefaultPrice,
            ]);
        }
    }
