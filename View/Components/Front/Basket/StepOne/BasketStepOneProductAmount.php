<?php

    namespace Modules\Shop\View\Components\Front\Basket\StepOne;

    use Illuminate\View\Component;
    use Modules\Shop\Models\Shop;

    class BasketStepOneProductAmount extends Component
    {
        public $basketProduct;
        public $basketProductId;
        public $endDiscountedPrice;
        public $productPrint;

        /**
         * Create a new component instance.
         *
         * @return void
         */
        public function __construct($basketProduct)
        {
            $this->basketProduct      = $basketProduct;
            $this->basketProductId    = $basketProduct->product->id;
            $this->endDiscountedPrice = $this->formatPrice($basketProduct->end_discounted_price);
            $this->productPrint       = is_null($basketProduct->product_print) ? '' : $basketProduct->product_print;
        }

        private function formatPrice($price): string
        {
            return Shop::formatPrice($price);
        }

        public function render()
        {
            return view('shop::components.front.basket.step_one.basket_step_one_product_amount', [
                'basketProduct'      => $this->basketProduct,
                'basketProductId'    => $this->basketProductId,
                'endDiscountedPrice' => $this->endDiscountedPrice,
                'productPrint'       => $this->productPrint,
            ]);
        }
    }
