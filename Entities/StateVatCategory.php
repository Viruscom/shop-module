<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StateVatCategory extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['state_id', 'vat_category_id', 'vat'];

    /**
     * @return BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }


    /**
     * @return BelongsTo
     */
    public function vat_category(): BelongsTo
    {
        return $this->belongsTo(VatCategory::class);
    }

}
