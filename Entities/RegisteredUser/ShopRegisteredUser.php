<?php

    namespace Modules\Shop\Entities\RegisteredUser;

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
        protected $fillable = ['client_group_id', 'first_name', 'last_name', 'phone', 'birthday', 'email', 'email_verified_at', 'password', 'active', 'newsletter_subscribed'];

        public static function getClientGroups(): array
        {
            return [1, 2, 3, 4, 5, 6];
        }

        public function orders(): HasMany
        {
            return $this->hasMany(Order::class, 'user_id', 'id')->whereNull('parent_order_id')->orderBy('created_at', 'desc');
        }

        public function countOrders(): int
        {
            return $this->orders->count();
        }
        public function favoriteProducts(): HasMany
        {
            return $this->hasMany(ProductFavorite::class, 'user_id');
        }
        public function countFavoriteProducts(): int
        {
            return $this->favoriteProducts->count();
        }
        public function paymentAddresses(): HasMany
        {
            return $this->hasMany(ShopPaymentAddress::class, 'user_id', 'id');
        }

        public function shipmentAddresses(): HasMany
        {
            return $this->hasMany(ShopShipmentAddress::class, 'user_id', 'id');
        }

        public function companies(): HasMany
        {
            return $this->hasMany(Company::class, 'user_id', 'id');
        }

        public function abandonedBaskets()
        {
            //TODO: Add relation
        }

        public function getUpdateData($request)
        {
            $data = $request->all();

            $data['password'] = bcrypt($request->password);

            $data['active'] = false;
            if ($request->has('active')) {
                $data['active'] = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
            }

            $data['newsletter_allowed'] = false;
            if ($request->has('newsletter_allowed')) {
                $data['newsletter_allowed'] = filter_var($request->newsletter_allowed, FILTER_VALIDATE_BOOLEAN);
            }

            return $data;
        }
    }
