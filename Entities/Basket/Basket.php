<?php

namespace Modules\Shop\Entities\Basket;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
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

    public static function productsCount()
    {
        $basket = Basket::getCurrent();
        if (is_null($basket)) {
            return 0;
        }

        $productsCount = 0;
        foreach ($basket->basket_products as $basketProduct) {
            $productsCount += $basketProduct->product_quantity;
        }

        return $productsCount;
    }
    public static function getCurrent()
    {
        if (Auth::guard('shop')->check()) {
            $basket = Basket::where('user_id', Auth::guard('shop')->user()->id)->first();
            if (is_null($basket)) {
                $basket = Basket::create(['user_id' => Auth::guard('shop')->user()->id, 'key' => null]);
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
        return $this->belongsTo(ShopRegisteredUser::class);
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
        $this->total_default              = 0;
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

            $basketProduct->default_price    = $basketProduct->product->price;
            $basketProduct->price            = $basketProduct->product->price;
            $basketProduct->discounts_amount = 0;

            // vuv  $basketProduct->price poprincip pazim cenata na produkta zalojena ot admina no tuk v tova par4e kod q modificirame ako ima zalojena otstupka za broika
            $quantityDiscount = Discount::getQuantityDiscount($basketProduct);
            if (!is_null($quantityDiscount)) {
                $this->addDiscount('quantity', $basketProduct->product->id, $quantityDiscount);
                // eto tk naprime ako ima zalojena otstupka za koli4estvo $basketProduct->price 6te prieme stoinostta spored dobavenata broika ot produkta v koli4kata i diskaunta kojto i suotvetstva
                $basketProduct->price = $quantityDiscount->product_price;
            }

            //vata na produkta v koi4kata
            $basketProduct->vat = $basketProduct->product->getVat($country, $city);

            //tova e cenata na produkta bez nikakvi na4isleni otstupki samo s adnato dds
            $basketProduct->vat_applied_default_price = $basketProduct->default_price + ($basketProduct->default_price * ($basketProduct->vat / 100));

            // cenata zalojena ot admina  + quantity discaount na product v koli4kata + na4islen vat
            $basketProduct->vat_applied_price = $basketProduct->price + ($basketProduct->price * ($basketProduct->vat / 100));

            //tova e cenata zalojena ot admina + quantity discaount za producta s pribaven vat i umnojena po broikata na produkta v koli4kata
            $basketProduct->end_price = $basketProduct->product_quantity * $basketProduct->vat_applied_price;

            //tova e cenata zalojena ot admina za producta s pribaven vat i umnojena po broikata na produkta v koli4kata
            $basketProduct->end_default_price = $basketProduct->product_quantity * $basketProduct->vat_applied_default_price;
            $this->total_default              += $basketProduct->end_default_price;

            $fixedFreeDeliveryDiscount = Discount::getFreeDeliveryDiscount($basketProduct, $this->promo_code);
            if (!is_null($fixedFreeDeliveryDiscount)) {
                $this->addDiscount('delivery', $basketProduct->product->id, $fixedFreeDeliveryDiscount);
                // tova e dali konkretniq produkt ot koli4kata ima bezplatna dostavka
                $basketProduct->free_delivery = true;
            }

            //tuka proverqvame dali ima na4islena otstupka za koli4estvo . Samo ako nqma na4islena togava shte na4islimi fiksirana otstupka za produka
            if (!isset($this->discounts_to_apply['quantity'][$basketProduct->product->id])) {
                $fixedDiscounts = Discount::getFixedDiscounts($basketProduct, $this->promo_code);
                if (!is_null($fixedDiscounts)) {
                    $this->addDiscounts('fixed', $basketProduct->product->id, $fixedDiscounts);
                    // v tova pole pazim 4islovoto izrevenie na diskauntite koito imaa
                    $basketProduct->discounts_amount = Discount::getDiscountsAmount($fixedDiscounts, $basketProduct->vat_applied_price);
                }
            }

            // tova pazi cenata koqto e s nalojeno dds ot po-gore kato ot neq e izvadena stojnostta na fiksiranite diskaunti bilo te levovi ili procentovi
            $basketProduct->vat_applied_discounted_price = $basketProduct->vat_applied_price - $basketProduct->discounts_amount;
            //tova pazi gorniq red umnoven po brojkata na produkti v koli4kata
            $basketProduct->end_discounted_price = $basketProduct->product_quantity * $basketProduct->vat_applied_discounted_price;

            array_push($this->calculated_basket_products, $basketProduct);
            //tova pazi totala ot vsi4ki produkti
            $this->total += $basketProduct->end_discounted_price;
        }
        if (count($toDelete) > 0) {
            $this->basket_products->whereIn('id', $toDelete)->delete();
        }

        $this->addGlobalDiscount('fixed', Discount::getGlobalFixed($this));
        $this->addGlobalDiscount('delivery', Discount::getGlobalDelivery($this));
        //tova setva property $basket->total_discounted koeto predstavlqva $basket->total s na4isleni ako ima fisirano diskaunti za cqlata kolichka bez znaènie ot produktite v neq
        $this->setTotalDiscounted();
        //tova setva dali cqlata koli4ka ima free delivery
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
