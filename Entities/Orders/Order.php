<?php

namespace Modules\Shop\Entities\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
use Modules\Shop\Entities\Settings\City;
use Modules\Shop\Entities\Settings\Country;
use Modules\Shop\Entities\Settings\Delivery;
use Modules\Shop\Entities\Settings\Payment;

class Order extends Model
{
    //    Payment statuses
    const PAYMENT_PAID                 = 1;
    const PAYMENT_PENDING              = 2;
    const PAYMENT_CANCELED             = 3;
    const PAYMENT_REFUND               = 4;
    const PAYMENT_PARTIAL_COMPENSATION = 5;

    //    Shipment statuses
    const SHIPMENT_WAITING    = 1;
    const SHIPMENT_PROCESSING = 2;
    const SHIPMENT_SENT       = 3;
    const SHIPMENT_DELIVERED  = 4;
    const SHIPMENT_CANCELED   = 5;
    const SHIPMENT_RETURNED   = 6;

    protected $fillable = ['user_id', 'uid', 'key', 'email', 'first_name', 'last_name', 'phone', 'street', 'street_number', 'country_id', 'city_id', 'zip_code', 'invoice_required', 'company_name', 'company_eik', 'company_vat_eik', 'company_mol', 'company_address', 'payment_id', 'delivery_id', 'discounts_to_apply', 'total', 'total_discounted', 'total_free_delivery', 'paid_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(ShopRegisteredUser::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }


    /**
     * @return BelongsTo
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return HasMany
     */
    public function order_products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
}
