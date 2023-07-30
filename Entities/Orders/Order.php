<?php

namespace Modules\Shop\Entities\Orders;

use App\Models\Settings\Post;
use App\Models\Settings\ShopSetting;
use Barryvdh\Snappy\Facades\SnappyPdf;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Mail;
use Modules\Shop\Emails\OrderPlacedToAdminMailable;
use Modules\Shop\Emails\OrderPlacedToClientMailable;
use Modules\Shop\Emails\PaymentStatusChangedMailable;
use Modules\Shop\Emails\ShipmentStatusChangedMailable;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
use Modules\Shop\Entities\Settings\City;
use Modules\Shop\Entities\Settings\Country;
use Modules\Shop\Entities\Settings\Delivery;
use Modules\Shop\Entities\Settings\Payment;
use Modules\Shop\Services\CurrencyService;

class Order extends Model
{
    const PAYMENT_PAID = 1;
    //    Payment statuses
    const PAYMENT_PENDING              = 2;
    const PAYMENT_CANCELED             = 3;
    const PAYMENT_REFUND               = 4;
    const PAYMENT_PARTIAL_COMPENSATION = 5;
    const SHIPMENT_WAITING             = 1;

    //    Shipment statuses
    const SHIPMENT_PROCESSING = 2;
    const SHIPMENT_SENT       = 3;
    const SHIPMENT_DELIVERED  = 4;
    const SHIPMENT_CANCELED   = 5;
    const SHIPMENT_RETURNED   = 6;
    public static string $FILES_PATH = 'shop/orders';
    protected            $fillable   = ['user_id', 'uid', 'key', 'email', 'first_name', 'last_name', 'phone', 'street', 'street_number', 'country_id', 'city_id', 'zip_code', 'invoice_required', 'company_name', 'company_eik', 'company_vat_eik', 'company_mol', 'company_address', 'payment_id', 'delivery_id', 'discounts_to_apply', 'total', 'total_discounted', 'total_free_delivery', 'paid_at', 'shipment_status', 'payment_status', 'payment_address', 'returned_amount', 'date_of_return', 'type_of_return', 'return_comment', 'vr_number', 'vr_trans_number', 'vr_date', 'total_default', 'promo_code'];

    public function getReadableShipmentStatus()
    {
        return trans('shop::admin.order_shipment_statuses.' . $this->shipment_status);
    }
    public function getReadablePaymentStatus()
    {
        return trans('shop::admin.order_payment_statuses.' . $this->payment_status);
    }
    public function getReadablePaymentMethod()
    {
        return trans('shop::admin.payment_systems.' . $this->payment->type);
    }
    public function getReadableShipmentMethod()
    {
        return trans('shop::admin.delivery_systems.' . $this->delivery->type);
    }
    public function getShipmentStatusClass($status): string
    {
        $classArray = [
            self::SHIPMENT_WAITING    => '#c376be',
            self::SHIPMENT_PROCESSING => '#f53333',
            self::SHIPMENT_SENT       => '#f7d100',
            self::SHIPMENT_DELIVERED  => '#ff9a24',
            self::SHIPMENT_CANCELED   => '#ff68a1',
            self::SHIPMENT_RETURNED   => '#01bec0',
        ];
        if (!array_key_exists($status, $classArray)) {
            return '#000000;';
        }

        return $classArray[$status];
    }

    public function getPaymentStatusClass($status): string
    {
        $classArray = [
            self::PAYMENT_PAID                 => '#c376be',
            self::PAYMENT_PENDING              => '#f53333',
            self::PAYMENT_CANCELED             => '#f7d100',
            self::PAYMENT_REFUND               => '#ff9a24',
            self::PAYMENT_PARTIAL_COMPENSATION => '#ff68a1',
        ];
        if (!array_key_exists($status, $classArray)) {
            return '#000000;';
        }

        return $classArray[$status];
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(ShopRegisteredUser::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }


    /**
     * @return BelongsTo
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return HasMany
     */
    public function order_products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function totalVatProducts()
    {
        $totalVat = 0;
        foreach ($this->order_products as $orderProduct) {
            $totalVat += $orderProduct->vat;
        }

        return CurrencyService::formatPrice($totalVat);
    }
    public function totalEndPriceProducts()
    {
        $totalEndPrice = 0;

        foreach ($this->order_products as $orderProduct) {
            $totalEndPrice += $orderProduct->end_price;
        }

        return CurrencyService::formatPrice($totalEndPrice);
    }

    public function totalDiscountsAmount()
    {
        $totalDiscountsAmount = 0;

        foreach ($this->order_products as $orderProduct) {
            $totalDiscountsAmount += $orderProduct->discounts_amount;
        }

        return CurrencyService::formatPrice($totalDiscountsAmount);
    }
    public function grandTotalWithDiscountsVatAndDelivery()
    {
        $deliveryPrice = 3;
        $totalEndPrice = 0;

        foreach ($this->order_products as $orderProduct) {
            $totalEndPrice += $orderProduct->end_price;
        }

        $grandTotal = $totalEndPrice + (float)$deliveryPrice;

        return CurrencyService::formatPrice($grandTotal);
    }
    public function totalEndDiscountedPrice()
    {
        $totalEndDiscountedPrice = 0;

        foreach ($this->order_products as $orderProduct) {
            $totalEndDiscountedPrice += $orderProduct->end_discounted_price;
        }

        return CurrencyService::formatPrice($totalEndDiscountedPrice);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(OrderDocument::class)->orderByDesc('created_at');
    }
    public function history(): HasMany
    {
        return $this->hasMany(OrderHistory::class)->orderByDesc('created_at');
    }
    public function returns(): ?HasMany
    {
        //        if ($this->status_id != self::$STATUS_COMPLETED) {
        //            return null;
        //        }

        return $this->hasMany(OrderReturn::class);
    }

    public function strPadOrderId(): string
    {
        return str_pad($this->id, 10, '0', STR_PAD_LEFT);
    }

    public function sendMailPaymentStatusChanged()
    {
        $email = new PaymentStatusChangedMailable($this);
        Mail::to($this->email)->send($email);
    }

    public function sendMailShipmentStatusChanged()
    {
        $email = new ShipmentStatusChangedMailable($this);
        Mail::to($this->email)->send($email);
    }

    public function sendMailOrderPlacedToClient()
    {
        $email = new OrderPlacedToClientMailable($this);
        Mail::to($this->email)->send($email);
    }

    public function sendMailOrderPlacedToAdmin()
    {
        $postSetting = Post::first();
        if (!is_null($postSetting) && !empty($postSetting->shop_orders_email)) {
            $email = new OrderPlacedToAdminMailable($this);
            Mail::to($postSetting->shop_orders_email)->send($email);
        }
    }


    public function generateVirtualReceipt($filename, $vrNumber): void
    {
        if (is_null($vrNumber)) {
            $vrNumber = ShopSetting::where('key', 'virtual_receipt_number')->first();
        }

        if (File::exists(public_path('shop/orders/documents/' . $filename))) {
            File::delete(public_path('shop/orders/documents/' . $filename));
        }

        $pdf = SnappyPdf::loadView('shop::emails.orders.virtual_receipt', ['order' => $this, 'virtualReceiptNumber' => $vrNumber->value]);
        $pdf->save(public_path('shop/orders/documents/' . $filename));

        $vrNumber->update(['value' => $vrNumber->value + 1]);
    }
}
