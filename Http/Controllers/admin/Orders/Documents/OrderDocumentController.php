<?php

namespace Modules\Shop\Http\Controllers\admin\Orders\Documents;

use App\Http\Controllers\Controller;
use Modules\Shop\Entities\Orders\Order;
use Modules\Shop\Entities\Orders\OrderDocument;
use Modules\Shop\Http\Requests\OrderDocumentRequest;

class OrderDocumentController extends Controller
{
    public function store(OrderDocumentRequest $request)
    {

        $filename           = str_replace('.', '_', $request->file->getClientOriginalName());
        $document           = new OrderDocument();
        $document->name     = $request->name;
        $document->comment  = $request->comment;
        $document->order_id = $request->order_id;
        $document->filename = $filename . '.' . $request->file->getClientOriginalExtension();
        $document->save();

        $document->saveFile($request->file('file'), $document);

        $order = Order::find($document->order_id);
        if (!is_null($order)) {
            $order->history()->create(['activity_name' => 'Добавен документ с име: ' . $document->name . ', коментар: ' . $document->comment . ', име на файла: ' . $document->filename]);
        }

        if ($request->has('submitaddnew')) {
            return redirect()->back()->with('success-message', 'administration_messages.successful_create');
        }

        return redirect('admin/shop/orders/' . $document->order_id . '/show')->with('success-message', 'administration_messages.successful_create');
    }
    public function create($order_id)
    {
        $order = Order::find($order_id);
        if (is_null($order)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        return view('admin.shop.orders.documents.create', compact('order'));
    }
    public function delete($order_id, $document_id)
    {
        $document = OrderDocument::find($document_id);
        if (is_null($document)) {
            return redirect()->back()->withErrors(['administration_messages.document_not_found']);
        }
        FileHelper::deleteFile($document->fullImageFilePath());
        $document->delete();

        $order = Order::find($document->order_id);
        if (!is_null($order)) {
            $order->history()->create(['activity_name' => 'Изтрит документ с име: ' . $document->name . ', коментар: ' . $document->comment . ', име на файла: ' . $document->filename]);
        }

        return redirect()->back()->with('success-message', 'administration_messages.successful_delete');
    }

    public function send($order_id, $document_id)
    {
        $document = OrderDocument::find($document_id);
        if (is_null($document)) {
            return redirect()->back()->withErrors(['administration_messages.document_not_found']);
        }

        $document->sendMailDocument($document);

        $order = Order::find($document->order_id);
        if (!is_null($order)) {
            $order->history()->create(['activity_name' => 'Изпратен документ с име: ' . $document->name . ', коментар: ' . $document->comment . ', име на файла: ' . $document->filename]);
        }

        return redirect('admin/shop/orders/' . $document->order_id . '/show')->with('success-message', 'administration_messages.document_successfully_sent');
    }
}
