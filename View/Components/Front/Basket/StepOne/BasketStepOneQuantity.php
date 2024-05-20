<?php
namespace Modules\Shop\View\Components\Front\Basket\StepOne;
use Illuminate\View\Component;
class BasketStepOneQuantity extends Component
{
    public $basketProduct;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($basketProduct)
    {
        $this->basketProduct = $basketProduct;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('shop::components.front.basket.step_one.basket_step_one_quantity', [
            'basketProduct' => $this->basketProduct
        ]);
    }
}
