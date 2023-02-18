<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'data',
        'active',
        'position',
        'validation_rules',
        'validation_messages',
        'validation_attributes',
        'edit_view_path'
    ];

    public function generateData($requestData)
    {
        $data = [];
        foreach ($requestData as $field => $value) {
            if (!in_array($field, $this->fillable)) {
                $data[$field] = $value;
            }
        }

        return $data;
    }

    public function updatePosition($position)
    {
        $maxPosition = Delivery::getMaxPosition();
        if (is_null($position) || $position < 0 || $position > $maxPosition) {
            return;
        }

        $currentPosition = $this->position;
        if ($currentPosition == $position) {
            return;
        }

        $deliveries = Delivery::where('id', '!=', $this->id);
        if ($currentPosition > $position) {
            $fromPosition = $position;
            $toPosition   = $currentPosition;
            $deliveries->where('position', '>=', $fromPosition)->where('position', '<=', $toPosition)->increment('position', 1);
        } else {
            $fromPosition = $currentPosition;
            $toPosition   = $position;
            $deliveries->where('position', '>=', $fromPosition)->where('position', '<=', $toPosition)->decrement('position', 1);
        }

        $this->update(['position' => $position]);
    }

    public static function getMaxPosition()
    {
        $maxPosition = Delivery::where('id', '>', 0)->max('position');
        $maxPosition = is_null($maxPosition) ? 0 : $maxPosition + 1;

        return $maxPosition;
    }

    public function hasEditView()
    {
        return view()->exists($this->edit_view_path);
    }

}
