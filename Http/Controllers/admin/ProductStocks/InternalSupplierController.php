<?php

namespace Modules\Shop\Http\Controllers\admin\ProductStocks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\Stocks\InternalSupplierStoreRequest;
use App\Http\Requests\Products\Stocks\InternalSupplierUpdateRequest;
use App\Models\Products\InternalSupplier;
use App\Models\Products\InternalSupplierTranslation;
use App\Models\Shop_Models\Suppliers\SupplierTranslation;

class InternalSupplierController extends Controller
{
    public function index()
    {
        $suppliers = InternalSupplier::archived(false)->get();

        return view('admin.products.stocks.internal_suppliers.index', compact('suppliers'));
    }

    public function archived()
    {
        $suppliers = InternalSupplier::archived(true)->get();

        return view('admin.products.stocks.internal_suppliers.archived', compact('suppliers'));
    }
    public function store(InternalSupplierStoreRequest $request)
    {
        $languages           = LanguageHelper::getActiveLanguages();
        $request['position'] = InternalSupplier::generatePosition($request);
        $internalSupplier    = InternalSupplier::create(InternalSupplier::getRequestData($request));
        foreach ($languages as $language) {
            $internalSupplier->translations()->create(InternalSupplierTranslation::getCreateData($language, $request));
        }

        if ($request->has('submitaddnew')) {
            return redirect()->back()->with('success-message', 'administration_messages.successful_create');
        }

        return redirect()->route('products.stocks.internal_suppliers.index')->with('success-message', 'administration_messages.successful_create');
    }
    public function create()
    {
        $languages       = LanguageHelper::getActiveLanguages();
        $defaultLanguage = LanguageHelper::getDefaultLanguage();
        $suppliers       = InternalSupplier::with('translations')->orderBy('position')->get();

        return view('admin.products.stocks.internal_suppliers.create', compact('languages', 'defaultLanguage', 'suppliers'));
    }
    public function edit($id)
    {
        $supplier = InternalSupplier::find($id);
        if (is_null($supplier)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $languages       = LanguageHelper::getActiveLanguages();
        $defaultLanguage = LanguageHelper::getDefaultLanguage();
        $suppliers       = InternalSupplier::with('translations')->orderBy('position')->get();

        return view('admin.products.stocks.internal_suppliers.edit', compact('supplier', 'languages', 'defaultLanguage', 'suppliers'));
    }
    public function active($id, $active): RedirectResponse
    {
        $supplier = InternalSupplier::find($id);
        if (is_null($supplier)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $supplier->update(['active' => $active]);

        return redirect()->route('products.stocks.internal_suppliers.index')->with('success-message', 'administration_messages.successful_edit');
    }
    public function update($id, InternalSupplierUpdateRequest $request)
    {
        $supplier = InternalSupplier::find($id);
        if (is_null($supplier)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $languages           = LanguageHelper::getActiveLanguages();
        $request['position'] = $supplier->updatedPosition($request);
        $supplier->update($supplier->getRequestData($request));
        foreach ($languages as $language) {
            $supplierTranslation = $supplier->translations->where('language_id', $language->id)->first();
            if (is_null($supplierTranslation)) {
                $supplier->translations()->create(SupplierTranslation::getCreateDataArray($language, $request));
            } else {
                $supplierTranslation->update($supplierTranslation->getDataArray($language, $request));
            }
        }

        return redirect()->route('products.stocks.internal_suppliers.index')->with('success-message', 'administration_messages.successful_edit');
    }
    public function positionDown($id): RedirectResponse
    {
        $supplier = InternalSupplier::find($id);
        if (is_null($supplier)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $nextSupplier = InternalSupplier::where('position', $supplier->position + 1)->first();
        if (!is_null($nextSupplier)) {
            $nextSupplier->update(['position' => $nextSupplier->position - 1]);
            $supplier->update(['position' => $supplier->position + 1]);
        }

        return redirect()->route('products.stocks.internal_suppliers.index')->with('success-message', 'administration_messages.successful_edit');
    }

    public function positionUp($id): RedirectResponse
    {
        $supplier = InternalSupplier::find($id);
        if (is_null($supplier)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $prevSupplier = InternalSupplier::where('position', $supplier->position - 1)->first();
        if (!is_null($prevSupplier)) {
            $prevSupplier->update(['position' => $prevSupplier->position + 1]);
            $supplier->update(['position' => $supplier->position - 1]);
        }

        return redirect()->route('products.stocks.internal_suppliers.index')->with('success-message', 'administration_messages.successful_edit');
    }

    public function archive($id, $archived): RedirectResponse
    {
        $supplier = InternalSupplier::find($id);
        if (is_null($supplier)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $supplier->update(['archived' => $archived]);

        return redirect()->back()->with('success-message', 'administration_messages.successful_edit');
    }
}
