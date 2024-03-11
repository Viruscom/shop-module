<?php

namespace Modules\Shop\Entities\RegisteredUser\ShipmentAddresses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
use Modules\Shop\Entities\Settings\City;
use Modules\Shop\Entities\Settings\Country;

class ShopShipmentAddress extends Model
{
    protected $table    = "shop_reg_user_shipment_addresses";
    protected $fillable = ['user_id', 'zip_code', 'city_id', 'country_id', 'name', 'street', 'street_number', 'is_default', 'is_deleted'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(ShopRegisteredUser::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
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
