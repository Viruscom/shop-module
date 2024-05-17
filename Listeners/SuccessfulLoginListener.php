<?php

    namespace Modules\Shop\Listeners;

    use App\Helpers\ModuleHelper;
    use Auth;
    use Modules\Shop\Entities\Basket\Basket;

    class SuccessfulLoginListener
    {
        /**
         * Create the event listener.
         *
         * @return void
         */
        public function __construct()
        {
            //
        }

        /**
         * Handle the event.
         *
         * @param object $event
         *
         * @return void
         */
        public function handle($event)
        {
            $user          = Auth::guard('shop')->user();
            $activeModules = ModuleHelper::getActiveModules();

            if (!$user || !array_key_exists('Shop', $activeModules)) {
                return;
            }

            $basket = Basket::where('key', $_COOKIE['sbuuid'])->first();
            if (is_null($basket)) {
                return;
            }

            $currentBasket = Basket::where('user_id', $user->id)->first();
            if (is_null($currentBasket)) {
                $currentBasket = Basket::create(['user_id' => $user->id, 'key' => null]);
            }

            $currentBasket->merge($basket);
        }
    }
