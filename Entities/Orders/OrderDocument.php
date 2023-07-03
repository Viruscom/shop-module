<?php

namespace Modules\Shop\Entities\Orders;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;
use Modules\Shop\Emails\OrderDocumentAttached;

class OrderDocument extends Model
{
    protected $table    = "order_documents";
    protected $fillable = ['order_id', 'name', 'comment', 'filename'];
    private   $FILES_PATH;
    public function __construct()
    {
        $this->setFILESPATH(Order::$FILES_PATH . '/documents');
    }
    /**
     * @param mixed $FILES_PATH
     */
    public function setFILESPATH($FILES_PATH)
    {
        $this->FILES_PATH = $FILES_PATH;
    }
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function directoryPathUrl()
    {
        return url($this->directoryPath());
    }
    public function directoryPath()
    {
        return public_path($this->FILES_PATH);
    }
    public function fullImageFilePath()
    {
        $this->setFILESPATH(Order::$FILES_PATH . '/documents');

        return $this->FILES_PATH . '/' . $this->filename;
    }

    public function fullImageFilePathUrl()
    {
        return url($this->FILES_PATH . '/' . $this->filename);
    }

    public function saveFile($file, $document)
    {
        FileHelper::saveFile($this->directoryPath(), $file, $document->filename, $document->filename);
    }

    public function sendMailDocument($document)
    {
        Mail::to($this->order->email)->send(new OrderDocumentAttached($document));
    }
}
