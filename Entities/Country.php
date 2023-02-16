<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name', 'iso3', 'numeric_code', 'iso2', 'phonecode', 'capital', 'currency', 'currency_name', 'currency_symbol', 'tld', 'native', 'region', 'subregion', 'timezones', 'translations', 'latitude', 'longitude', 'emoji', 'emojiU', 'flag', 'wikiDataId', 'created_at', 'updated_at', 'vat'];

    /**
     * @return HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * @return HasMany
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }


    /**
     * @return HasMany
     */
    public function vat_categories()
    {
        return $this->hasMany(VatCategory::class);
    }
}
