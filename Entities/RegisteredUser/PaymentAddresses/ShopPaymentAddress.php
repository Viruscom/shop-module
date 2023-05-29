<?php

namespace Modules\Shop\Entities\RegisteredUser\PaymentAddresses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;

class ShopPaymentAddress extends Model
{
    protected $table   = "shop_reg_user_payment_addresses";
    protected $fillable = ['user_id', 'zip_code', 'city_id', 'country_id', 'name', 'street', 'street_number', 'email', 'is_default', 'is_deleted'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(ShopRegisteredUser::class);
    }
}
