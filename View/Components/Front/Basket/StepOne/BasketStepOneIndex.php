<?php

    namespace Modules\Shop\View\Components\Front\Basket\StepOne;

    use Illuminate\View\Component;
    use Illuminate\View\View;

    class BasketStepOneIndex extends Component
    {
        public $basket;

        /**
         * Create a new component instance.
         *
         * @return void
         */
        public function __construct($basket)
        {
            $this->basket = $basket;
        }

        /**
         * Get the view / contents that represent the component.
         *
         * @return View|string
         */
        public function render()
        {
            if (!is_null($this->basket) || $this->basket->basket_products->count() >= 1) {
                return view('shop::components.front\basket\step_one\basket_step_one_index');
            }

            return view('shop::components.front\basket\step_one\basket_step_one_empty');
        }
    }
