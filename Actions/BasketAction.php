<?php

namespace Modules\Shop\Actions;

use App\Classes\ProductHelper;
use App\Helpers\CacheKeysHelper;
use App\Helpers\LanguageHelper;
use App\Models\AdBox;
use App\Models\AdBoxTranslation;
use App\Models\Files\File;
use Cache;
use Illuminate\Http\Request;
use Modules\Shop\Entities\AdBoxProduct;
use Modules\Shop\Entities\Order;
use Modules\Shop\Models\Admin\Brand;
use Modules\Shop\Models\Admin\ProductCategory\Category;

class BasketAction
{
    public function storeOrder($request, $basket)
    {
        $order = Order::create($request->all());
        foreach ($basket->calculated_basket_products as $basketProduct) {
            $order->order_products()->create([
                                                 'product_id'                   => $basketProduct->product_id,
                                                 'product_quantity'             => $basketProduct->product_quantity,
                                                 'supplier_delivery_price'      => $basketProduct->product->supplier_delivery_price,
                                                 'price'                        => $basketProduct->product->price,
                                                 'discounts_amount'             => $basketProduct->discounts_amount,
                                                 'vat'                          => $basketProduct->vat,
                                                 'vat_applied_price'            => $basketProduct->vat_applied_price,
                                                 'end_price'                    => $basketProduct->end_price,
                                                 'free_delivery'                => $basketProduct->free_delivery ? 1 : 0,
                                                 'vat_applied_discounted_price' => $basketProduct->vat_applied_discounted_price,
                                                 'end_discounted_price'         => $basketProduct->end_discounted_price
                                             ]);
        }

        return $order;
    }
    public function sendEmailToClient($request, $basket)
    {

    }
    public function sendEmailToAdmin($request, $basket)
    {
    }
}
