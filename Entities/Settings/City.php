<?php

namespace Modules\Shop\Entities\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['country_id', 'state_id', 'name', 'country_code', 'state_code', 'latitude', 'longitude', 'flag', 'wikiDataId', 'created_at', 'updated_at', 'zip_codes', 'vat'];

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }


    /**
     * @return HasMany
     */
    public function vat_categories()
    {
        return $this->hasMany(CityVatCategory::class);
    }
}
