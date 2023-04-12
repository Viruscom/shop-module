<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VatCategory extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['country_id', 'name', 'vat'];

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
