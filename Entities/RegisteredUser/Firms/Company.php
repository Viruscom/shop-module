<?php

namespace Modules\Shop\Entities\RegisteredUser\Firms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shop\Entities\Orders\OrderProduct;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
use Modules\Shop\Entities\Settings\City;
use Modules\Shop\Entities\Settings\Country;
use Modules\Shop\Entities\Settings\Delivery;
use Modules\Shop\Entities\Settings\Payment;

class Company extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'email', 'phone', 'street', 'street_number', 'country_id', 'city_id', 'zip_code', 'company_name', 'company_eik', 'company_vat_eik', 'company_mol', 'company_address', 'is_default', 'is_deleted'];

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

    public function scopeIsDefault($query, $bool)
    {
        return $query->where('is_default', $bool);
    }

    public function scopeIsDeleted($query, $bool)
    {
        return $query->where('is_deleted', $bool);
    }
}
