<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'uid', 'key', 'email', 'first_name', 'last_name', 'phone', 'street', 'street_number', 'country_id', 'city_id', 'zip_code', 'invoice_required', 'company_name', 'company_eik', 'company_vat_eik', 'company_mol', 'company_address', 'payment_id', 'delivery_id', 'discounts_to_apply', 'total', 'total_discounted', 'total_free_delivery', 'paid_at'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(ShopRegisteredUser::class);
    }

    /**
     * @return BelongsTo
     */
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
