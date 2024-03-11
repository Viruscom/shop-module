<?php

    namespace Modules\Shop\Entities\Basket;

    use Auth;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Http\Request;
    use Modules\Shop\Actions\BasketAction;
    use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
    use Modules\Shop\Helpers\ShopHelper;
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
        protected $fillable = ['user_id', 'key', 'promo_code'];

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
        // tova e getvane na koli4kata ot potrebitelksta chast
        public static function getCurrent()
        {
            if (Auth::guard('shop')->check()) {
                $basket = Basket::where('user_id', Auth::guard('shop')->user()->id)->first();
                if (is_null($basket)) {
                    $basket = Basket::create(['user_id' => Auth::guard('shop')->user()->id, 'key' => null]);
                }
            } else {
                if (!isset($_COOKIE['sbuuid'])) {
                    $_COOKIE['sbuuid'] = ShopHelper::setCookieSbuuid();
                }
                $basket = Basket::where('key', $_COOKIE['sbuuid'])->first();
                if (is_null($basket)) {
                    $basket = Basket::create(['user_id' => null, 'key' => $_COOKIE['sbuuid']]);
                }
            }

            return $basket;
        }

        //tova e getvane na kolichka pri edit na poru4ka
        /**
         * @return BelongsTo
         */
        public function user()
        {
            return $this->belongsTo(ShopRegisteredUser::class);
        }
        public static function getOrcreateOrderSystemBasket($order)
        {
            $basket = Basket::where('key', Basket::getOrderSystemBasketKey($order))->first();
            if (is_null($basket)) {
                return Basket::createOrderSystemBasket($order);
            }

            return $basket;
        }
        private static function getOrderSystemBasketKey($order)
        {
            return "basket_system_user_" . Auth::user()->id . "_order_" . $order->id;
        }
        // tova e kliu4a na koli4ka pri edit na order kakto zabelzvash v nefo ima Auth user id + order id
        private static function createOrderSystemBasket($order)
        {
            $basket = Basket::create(['user_id' => $order->user_id, 'key' => Basket::getOrderSystemBasketKey($order), 'promo_code' => $order->promo_code]);
            foreach ($order->order_products as $orderProduct) {
                $request      = new Request();
                $basketAction = new BasketAction();

                $basketAction->replicateArraysForProductPrint($orderProduct, $request);
                if ($request->has('allEmpty')) {
                    $newProductPrint = base64_encode($request->allEmpty);
                } else {
                    $newProductPrint = $basketAction->generateProductPrint($request);
                }

                $newProduct = $basket->basket_products()->create(['product_id' => $orderProduct->product->id, 'product_quantity' => $orderProduct->product_quantity, 'product_print' => $newProductPrint]);

                if (isset($request->additivesAdd)) {
                    $request['additivesAdd'] = $basketAction->clearAdditivesArray($request->additivesAdd);
                    $basketAction->storeAdditives($request->additivesAdd, $newProduct);
                }
                if (isset($request->additivesExcept)) {
                    $basketAction->storeExcepts($request->additivesExcept, $newProduct);
                }
                if (isset($request->selectedCollectionPivotProduct)) {
                    $basketAction->storeCollection($request->selectedCollectionPivotProduct, $newProduct);
                }
            }

            return $basket;
        }

        // ======================ADMIN SYSTEM BASKET tova e basketa koito se polzva pri i samo pri create na order prez admina =========================
        /**
         * @return HasMany
         */
        public function basket_products()
        {
            return $this->hasMany(BasketProduct::class);
        }
        public static function deleteOrderSystemBasket($order)
        {
            Basket::where('key', Basket::getOrderSystemBasketKey($order))->delete();
        }
        public static function getOrCreateAdminSystemBasket()
        {
            $basket = Basket::where('key', Basket::getAdminSystemBasketKey())->first();
            if (is_null($basket)) {
                return Basket::createAdminSystemBasket();
            }

            return $basket;
        }
        // tova e get na kliu4a na koli4ka pi i samo i edinstveno na create na poru4ka pri admin
        private static function getAdminSystemBasketKey()
        {
            return "basket_system_admin_" . Auth::user()->id;
        }
        //=======================END ADMIN SYSTEM BASKET
        private static function createAdminSystemBasket()
        {
            return Basket::create(['user_id' => null, 'key' => Basket::getAdminSystemBasketKey()]);
        }
        public static function deleteAdminSystemBasket()
        {
            Basket::where('key', Basket::getAdminSystemBasketKey())->delete();
        }
        public function merge($basket)
        {
            foreach ($basket->basket_products as $basketProduct) {
                $product = Product::find($basketProduct->product_id);
                if (is_null($product)) {
                    continue;
                }

                $currBasketProduct = $this->basket_products->where('product_id', $basketProduct->product_id)->where('product_print', $basketProduct->product_print)->first();
                if (is_null($currBasketProduct)) {
                    $newProduct = $this->basket_products()->create(['product_id' => $basketProduct->product_id, 'product_print' => $basketProduct->product_print, 'product_quantity' => $basketProduct->product_quantity]);
                    //TODO fill pivot tables for addons excepts and collects
                } else {
                    $currBasketProduct->increment('product_quantity', $basketProduct->product_quantity);
                }
            }
            $basket->delete();
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
                $basketProduct->vat_applied_default_price = $this->formatPrice($basketProduct->default_price + ($basketProduct->default_price * ($basketProduct->vat / 100)));

                // cenata zalojena ot admina  + quantity discaount na product v koli4kata + na4islen vat
                $basketProduct->vat_applied_price = $basketProduct->price + ($basketProduct->price * ($basketProduct->vat / 100));

                //tova e cenata zalojena ot admina + quantity discaount za producta s pribaven vat i umnojena po broikata na produkta v koli4kata
                $basketProduct->end_price = $basketProduct->product_quantity * $basketProduct->vat_applied_price;

                $basketProduct->additives_total = 0;
                foreach ($basketProduct->additives as $additive) {
                    $basketProduct->additives_total += $additive->total;
                }
                $basketProduct->additives_total  = $basketProduct->additives_total * $basketProduct->product_quantity;
                $basketProduct->collection_total = 0;
                foreach ($basketProduct->productCollection as $collectionProduct) {
                    $basketProduct->collection_total += $collectionProduct->total;
                }

                //tova e cenata zalojena ot admina za producta s pribaven vat i umnojena po broikata na produkta v koli4kata
                $basketProduct->end_default_price                   = $basketProduct->product_quantity * $basketProduct->vat_applied_default_price;
                $basketProduct->end_default_price_with_add_and_coll = $basketProduct->end_default_price + $basketProduct->additives_total + $basketProduct->collection_total;

                $this->total_default += $basketProduct->end_default_price_with_add_and_coll;

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
                $basketProduct->vat_applied_discounted_price = $this->formatPrice($basketProduct->vat_applied_price - $basketProduct->discounts_amount);
                //tova pazi gorniq red umnoven po brojkata na produkti v koli4kata
                $basketProduct->end_discounted_price                   = $basketProduct->product_quantity * $this->formatPrice($basketProduct->vat_applied_discounted_price);
                $basketProduct->end_discounted_price_with_add_and_coll = $basketProduct->end_discounted_price + $basketProduct->additives_total + $basketProduct->collection_total;

                array_push($this->calculated_basket_products, $basketProduct);
                //tova pazi totala ot vsi4ki produkti
                $this->total += $basketProduct->end_discounted_price_with_add_and_coll;
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
            if (!array_key_exists($key, $this->discounts_to_apply)) {
                return;
            }
            if (!is_array($this->discounts_to_apply[$key])) {
                $this->discounts_to_apply[$key] = [];
            }

            if (!is_array($this->discounts_to_apply[$key][$productId])) {
                $this->discounts_to_apply[$key][$productId] = [];
            }

            $this->discounts_to_apply[$key][$productId][$discount->id] = $discount;
        }
        private function formatPrice($price): float
        {
            return floatval(number_format($price, 2, '.', ''));
        }
        public function addDiscounts($key, $productId, $discounts)
        {
            if (!array_key_exists($key, $this->discounts_to_apply)) {
                return;
            }
            if (!is_array($this->discounts_to_apply[$key])) {
                $this->discounts_to_apply[$key] = [];
            }

            $this->discounts_to_apply[$key][$productId] = $discounts;
        }
        public function addGlobalDiscount($key, $discount)
        {
            if (!array_key_exists($key, $this->discounts_to_apply['global'])) {
                return;
            }

            $this->discounts_to_apply['global'][$key] = $discount;
        }
        public function setTotalDiscounted()
        {
            $this->total_discounted = $this->total;
            if (isset($this->discounts_to_apply) && isset($this->discounts_to_apply['global']) && isset($this->discounts_to_apply['global']['fixed']) && !is_null($this->discounts_to_apply['global']['fixed'])) {
                if ($this->discounts_to_apply['global']['fixed']->type_id == Discount::$FIXED_AMOUNT_TYPE_ID) {
                    $this->total_discounted = $this->total - $this->discounts_to_apply['global']['fixed']->value;
                } else {
                    $this->total_discounted = $this->total - $this->total * ($this->discounts_to_apply['global']['fixed']->value / 100);
                }
            }
        }
        public function setTotalFreeDelivery()
        {
            $this->total_free_delivery =
                isset($this->discounts_to_apply) &&
                isset($this->discounts_to_apply['global']) &&
                isset($this->discounts_to_apply['global']['delivery']) &&
                !is_null($this->discounts_to_apply['global']['delivery']);
        }

        //ako ipash kolonata pravish edin metod za parsirate
        //    public function parseGuestData()
        //    {
        //        if(is_null($this->guest_data)){
        //            return null;
        //        }
        //        $guestData = json_decode($this->quest_data);
        //        retuurn []
        //    }
        //ami v basketa advash dwe koloni guest_data i delvery_address nullable default null i shte gi polzvame samo tuka - da variant e, ok shte go pomislq oshte malko i go pravq. ti utre kak si s vremeto? Utre mi e mnogo tagav den do kym 3 izobshto nqma da imam komp s mene sled tova trqbva da gledam malkiq pone 2 chasa zashtot shte hodim pri na Yonita dqdo i tq trqbva da iz4isti apartamenta tam i eventualno àk ve4era kysen sledobed nai-dobriq sluàj ili dode malkiq spi v nakakwi takiva promejdutaci
        // ideqta mi e da vidim za plashtaniqta i za yanak, 4e v nedelq vecherata jiv-umrql trqbva da sam go kachil, Emi kofti wekend mi e na mene s putuvane... taka v posledniq moment. Sega ako iskash moga da sedq oshte - az sam tuk. To po-vajno mi e za yanak kakvo info se prashta. dai mi edin nov fail

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
        function isCurrentPromoCodeValid()
        {
            foreach ($this->discounts_to_apply as $key => $appliedDiscountsByType) {
                foreach ($appliedDiscountsByType as $key2 => $appliedDiscountByType) {
                    if (is_array($appliedDiscountByType)) {
                        foreach ($appliedDiscountByType as $key3 => $discount) {
                            if (isset($discount->promo_code) && $discount->promo_code == $this->promo_code) {
                                return true;
                            }
                        }
                    } else {
                        if (isset($appliedDiscountByType->promo_code) && $appliedDiscountByType->promo_code == $this->promo_code) {
                            return true;
                        }
                    }
                }
            }

            return false;
        }
    }
