<?php

namespace Modules\Shop\Emails;

use App\Models\LawPages\LawPage;
use App\Models\Settings\ShopSetting;
use App\Models\Settings\Social;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Shop\Entities\Orders\Order;

class ShipmentStatusChangedMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $shopSettings;
    public $socialLinks;
    public $lawPages;

    public function __construct(Order $order)
    {
        $this->order        = $order;
        $this->shopSettings = ShopSetting::get();
        $this->socialLinks  = Social::getSettings();
        $this->lawPages     = LawPage::getLawPages();
    }

    public function build()
    {
        return $this->view('shop::emails.orders.shipment_status_change')
            ->with([
                'order' => $this->order,
                'shopSettings' => $this->shopSettings,
                'socialLinks' => $this->socialLinks,
                'lawPages' => $this->lawPages])->subject(trans('shop::admin.email_template_shipment_status_changed.status_changed_subject') . $this->order->getReadableShipmentStatus());
    }
}
