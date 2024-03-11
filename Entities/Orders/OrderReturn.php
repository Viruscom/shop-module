<?php

namespace Modules\Shop\Entities\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderReturn extends Model
{
    public const WAITING_ACTION_STATUS             = 1;
    public const AWAITING_SHIPMENT_STATUS          = 2;
    public const SHIPMENT_HAS_BEEN_RECEIVED_STATUS = 3;
    public const RETURN_REFUSED_STATUS             = 4;
    public const RETURN_COMPLETED_STATUS           = 5;
    protected $table   = 'order_returns';
    protected $guarded = ['id'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(OrderReturnProduct::class);
    }

    public function statusHumanReadable()
    {
        return trans('administration_messages.order_return_status_' . $this->status_id);
    }
}
