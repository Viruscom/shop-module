<?php

namespace Modules\Shop\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ShopRegisteredUser extends Authenticatable
{
    use Notifiable;

    public static int $DEFAULT_CLIENT_GROUP_ID = 1;

    protected $table    = 'shop_registered_users';
    protected $fillable = ['group_id', 'first_name', 'last_name', 'phone', 'birthday', 'email', 'email_verified_at', 'password'];

    public static function getClientGroups()
    {
        return [1, 2, 3, 4, 5, 6];
    }


    //    public function orders()
    //    {
    //        return $this->hasMany(ShopOrder::class);
    //    }
    //
    //    public function favoriteProducts()
    //    {
    //        return $this->belongsToMany(ShopProduct::class, 'shop_favorite_products', 'user_id', 'product_id');
    //    }
    //
    //    public function wantedProducts()
    //    {
    //        return $this->belongsToMany(ShopProduct::class, 'shop_wanted_products', 'user_id', 'product_id');
    //    }
    //
    //    public function companyAddresses()
    //    {
    //        return $this->hasMany(ShopCompanyAddress::class);
    //    }
    //
    //    public function deliveryAddresses()
    //    {
    //        return $this->hasMany(ShopDeliveryAddress::class);
    //    }
}
