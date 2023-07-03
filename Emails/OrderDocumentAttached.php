<?php

namespace Modules\Shop\Emails;

use App\Models\Settings\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Shop\Entities\Orders\OrderDocument;

class OrderDocumentAttached extends Mailable
{
    use Queueable, SerializesModels;

    public OrderDocument $document;
    public               $shopOrderEmail;

    public function __construct(OrderDocument $document)
    {
        $this->document       = $document;
        $this->shopOrderEmail = Post::getSettings()->shop_orders_email;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('shop::emails.orders.order_document_attached')
            ->from($this->shopOrderEmail, trans('messages.mail_shop_name'))
            ->subject('[ ' . trans('shop::admin.order_documents.order_email_order_number') . ' ' . $this->document->order->id . ' ] ' . trans('shop::admin.order_documents.order_email_subject_order_document'))
            ->replyTo($this->shopOrderEmail, trans('messages.mail_shop_name'))
            ->attach($this->document->fullImageFilePath());
    }
}
