<?php

namespace Modules\Shop\Entities\Settings\InternalIntegrations;

use Illuminate\Database\Eloquent\Model;

class InternalIntegration extends Model
{
    protected $table    = 'internal_integrations_settings';
    protected $fillable = ['key', 'data', 'active'];
    protected $casts    = [
        'data'   => 'array',
        'active' => 'boolean'
    ];
}
