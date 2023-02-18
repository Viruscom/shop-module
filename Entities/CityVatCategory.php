<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CityVatCategory extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['city_id', 'vat_category_id', 'vat'];

    /**
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }


    /**
     * @return BelongsTo
     */
    public function vat_category()
    {
        return $this->belongsTo(VatCategory::class);
    }

}
