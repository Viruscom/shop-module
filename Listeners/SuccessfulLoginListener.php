<?php

namespace App\Listeners;

use Auth;
use App\Models\Basket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $basket = Basket::where('key',  $_COOKIE['sbuuid'])->first();
        if(is_null($basket)){
           return;
        }

        $currentBasket = Basket::where('user_id', Auth::user()->id)->first();
        if(is_null($currentBasket)){
            $currentBasket = Basket::create(['user_id' => Auth::user()->id, 'key' => null]);
        }

        $currentBasket->merge($basket);
    }
}
