<?php

namespace Modules\Shop\Entities\Settings;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'base_currency',
        'target_currency',
        'rate',
        'last_update',
        'next_update'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_update',
        'next_update',
    ];
}
