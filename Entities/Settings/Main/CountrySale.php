<?php

namespace Modules\Shop\Entities\Settings\Main;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shop\Entities\Settings\Country;

class CountrySale extends Model
{
    protected $table    = 'shop_country_sales';
    protected $fillable = ['country_id'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
