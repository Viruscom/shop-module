<?php

namespace Modules\Shop\Entities\RegisteredUser;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Shop\Entities\Orders\Order;
use Modules\Shop\Entities\RegisteredUser\Firms\Company;
use Modules\Shop\Entities\RegisteredUser\PaymentAddresses\ShopPaymentAddress;
use Modules\Shop\Entities\RegisteredUser\ShipmentAddresses\ShopShipmentAddress;
use Modules\Shop\Models\Admin\Products\ProductFavorite;

class ShopRegisteredUser extends Authenticatable
{
    use Notifiable;

    public static int $DEFAULT_CLIENT_GROUP_ID = 1;

    protected $table    = 'shop_registered_users';
    protected $fillable = ['group_id', 'first_name', 'last_name', 'phone', 'birthday', 'email', 'email_verified_at', 'password'];

    public static function getClientGroups(): array
    {
        return [1, 2, 3, 4, 5, 6];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function countOrders(): int
    {
        return $this->hasMany(Order::class, 'user_id', 'id')->count();
    }
    public function favoriteProducts(): BelongsToMany
    {
        return $this->belongsToMany(ProductFavorite::class, 'product_favorites', 'user_id', 'product_id');
    }
    public function paymentAddresses(): HasMany
    {
        return $this->hasMany(ShopPaymentAddress::class);
    }

    public function shipmentAddresses(): HasMany
    {
        return $this->hasMany(ShopShipmentAddress::class);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
