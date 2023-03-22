<?php

namespace Modules\Shop\Entities;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shop\Models\Admin\Products\Product;
use Modules\ShopDiscounts\Entities\Discount;

class Basket extends Model
{
    use HasFactory;

    public $discounts_to_apply;
    public $total                      = 0;
    public $total_discounted           = 0;
    public $total_free_delivery        = false;
    public $calculated_basket_products = [];
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'key'];
    public static function getCurrent()
    {
        if (Auth::check()) {
            $basket = Basket::where('user_id', Auth::user()->id)->first();
            if (is_null($basket)) {
                $basket = Basket::create(['user_id' => Auth::user()->id, 'key' => null]);
            }
        } else {
            $basket = Basket::where('key', $_COOKIE['sbuuid'])->first();
            if (is_null($basket)) {
                $basket = Basket::create(['user_id' => null, 'key' => $_COOKIE['sbuuid']]);
            }
        }

        return $basket;
    }
    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function merge($basket)
    {
        foreach ($basket->basket_products as $basketProduct) {
            $product = Product::find($basketProduct->product_id);
            if (is_null($product)) {
                continue;
            }

            $currBasketProduct = $this->basket_products->where('product_id', $basketProduct->product_id)->first();
            if (is_null($currBasketProduct)) {
                $this->basket_products()->create(['product_id' => $basketProduct->product_id, 'product_quantity' => $basketProduct->product_quantity]);
            } else {
                $currBasketProduct->increment('product_quantity', $basketProduct->product_quantity);
            }
        }
        $basket->delete();
    }
    /**
     * @return HasMany
     */
    public function basket_products()
    {
        return $this->hasMany(BasketProduct::class);
    }
    public function calculate($basketProducts, $country, $city)
    {
        $this->discounts_to_apply         = self::getDefaultDiscountsArray();
        $this->total                      = 0;
        $this->total_discounted           = 0;
        $this->total_free_delivery        = false;
        $this->calculated_basket_products = [];

        $toDelete = [];
        foreach ($basketProducts as $basketProduct) {
            //if the product is deleted
            if (is_null($basketProduct->product)) {
                array_push($toDelete, $basketProduct->id);
                continue;
            }
            //TODO: check quantities and decrement?
            //after that check
            if ($basketProduct->product_quantity == 0) {
                array_push($toDelete, $basketProduct->id);
                continue;
            }

            $basketProduct->price            = $basketProduct->product->price;
            $basketProduct->discounts_amount = 0;

            $quantityDiscount = Discount::getQuantityDiscount($basketProduct);
            if (!is_null($quantityDiscount)) {
                $this->addDiscount('quantity', $basketProduct->product->id, $quantityDiscount);
                $basketProduct->price = $quantityDiscount->product_price;
            }

            $basketProduct->vat               = $basketProduct->product->getVat($country, $city);
            $basketProduct->vat_applied_price = $basketProduct->price + ($basketProduct->price * ($basketProduct->vat / 100));
            $basketProduct->end_price         = $basketProduct->product_quantity * $basketProduct->vat_applied_price;

            $fixedFreeDeliveryDiscount = Discount::getFreeDeliveryDiscount($basketProduct, $this->promo_code);
            if (!is_null($fixedFreeDeliveryDiscount)) {
                $this->addDiscount('delivery', $basketProduct->product->id, $fixedFreeDeliveryDiscount);
                $basketProduct->free_delivery = true;
            }

            if (!isset($this->discounts_to_apply['quantity'][$basketProduct->product->id])) {
                $fixedDiscounts = Discount::getFixedDiscounts($basketProduct, $this->promo_code);
                if (!is_null($fixedDiscounts)) {
                    $this->addDiscounts('fixed', $basketProduct->product->id, $fixedDiscounts);
                    $basketProduct->discounts_amount = Discount::getDiscountsAmount($fixedDiscounts, $basketProduct->vat_applied_price);
                }
            }

            $basketProduct->vat_applied_discounted_price = $basketProduct->vat_applied_price - $basketProduct->discounts_amount;
            $basketProduct->end_discounted_price         = $basketProduct->product_quantity * $basketProduct->vat_applied_discounted_price;

            array_push($this->calculated_basket_products, $basketProduct);
            $this->total += $basketProduct->end_discounted_price;
        }
        if (count($toDelete) > 0) {
            $this->basket_products->whereIn('id', $toDelete)->delete();
        }

        $this->addGlobalDiscount('fixed', Discount::getGlobalFixed($this));
        $this->addGlobalDiscount('delivery', Discount::getGlobalDelivery($this));
        $this->setTotalDiscounted();
        $this->setTotalFreeDelivery();
    }
    public static function getDefaultDiscountsArray()
    {
        return [
            'delivery' => [],
            'fixed'    => [],
            'quantity' => [],
            'global'   => [
                'delivery' => null,
                'fixed'    => null,
            ]
        ];
    }
    public function addDiscount($key, $productId, $discount)
    {
        if (!isset($this->discounts_to_apply[$key])) {
            return;
        }

        $this->discounts_to_apply[$key][$productId][$discount->id] = $discount;
    }
    public function addDiscounts($key, $productId, $discounts)
    {
        if (!isset($this->discounts_to_apply[$key])) {
            return;
        }

        $this->discounts_to_apply[$key][$productId] = $discounts;
    }
    public function addGlobalDiscount($key, $discount)
    {
        if (!isset($this->discounts_to_apply['global'][$key])) {
            return;
        }

        $this->discounts_to_apply['global'][$key] = $discount;
    }
    public function setTotalDiscounted()
    {
        $this->total_discounted = $this->total;
        if (isset($this->discountToApply) && isset($this->discountToApply['global']) && isset($this->discountToApply['global']['fixed']) && !is_null($this->discountToApply['global']['fixed'])) {
            if ($this->discountToApply['global']['fixed']->type_id == Discount::$FIXED_AMOUNT_TYPE_ID) {
                $this->total_discounted = $this->total - $this->discountToApply['global']['fixed']->value;
            } else {
                $this->total_discounted = $this->total - $this->total * ($this->discountToApply['global']['fixed']->value / 100);
            }
        }
    }
    public function setTotalFreeDelivery()
    {
        $this->total_free_delivery = isset($this->discountToApply) && isset($this->discountToApply['global']) && isset($this->discountToApply['global']['delivery']) && !is_null($this->discountToApply['global']['delivery']);
    }


    // public function getCity(){
    //     if($this->zip_code == null){
    //         $this->city = null;
    //     }else{
    //         if(is_null($this->city) || !in_array($this->zip_code, explode(",", $this->city->zip_codes))){
    //             $cities = \DB::table('cities')->whereRaw('find_in_set('.$this->zip_code.',zip_codes) <> 0')->get();
    //             if($cities->count() == 0){
    //                 $this->city = null;
    //             }else{
    //                 $this->city = $cities->first();
    //             }
    //         }
    //     }

    //     return $this->city;
    // }
}
