<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
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
        'class',
        'execute_payment_method',
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
        $maxPosition = Payment::getMaxPosition();
        if (is_null($position) || $position < 0 || $position > $maxPosition) {
            return;
        }

        $currentPosition = $this->position;
        if ($currentPosition == $position) {
            return;
        }

        $payments = Payment::where('id', '!=', $this->id);
        if ($currentPosition > $position) {
            $fromPosition = $position;
            $toPosition   = $currentPosition;
            $payments->where('position', '>=', $fromPosition)->where('position', '<=', $toPosition)->increment('position', 1);
        } else {
            $fromPosition = $currentPosition;
            $toPosition   = $position;
            $payments->where('position', '>=', $fromPosition)->where('position', '<=', $toPosition)->decrement('position', 1);
        }

        $this->update(['position' => $position]);
    }
    public static function getMaxPosition()
    {
        $maxPosition = Payment::where('id', '>', 0)->max('position');
        $maxPosition = is_null($maxPosition) ? 0 : $maxPosition + 1;

        return $maxPosition;
    }
    public function hasEditView()
    {
        return view()->exists($this->edit_view_path);
    }

    public function hasClass()
    {
        return class_exists($this->class);
    }


    public function hasExecutePaymentMethod()
    {
        return method_exists($this->class, $this->execute_payment_method);
    }
}
