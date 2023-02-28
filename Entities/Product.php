<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shop\Models\Admin\Brand;
use Modules\ShopDiscounts\Entities\Discount;

class Product extends Model
{
    protected $fillable = [];

    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function getVat($country, $city)
    {
        if (is_null($country) && is_null($city)) {
            return 0;
        }
        $defaultVat = self::getDefaultVat($country, $city);
        //select product city vat category or product state vat category or country vat category
        //of any of above is not null return it else
        //nqma kak da go napish sega zashtoto nqmam funkcionalnost za dobavqne na produkti, Kato se dobavqt productite se dobavqt i suotvetnite vat katogrii
        return $defaultVat;
    }

    private static function getDefaultVat($country, $city)
    {
        if ($city != null) {
            if (!is_null($city->vat)) {
                return $city->vat;
            }
            if (!is_null($city->state->vat)) {
                return $city->state->vat;
            }
        }

        return $country->vat;
    }
}
