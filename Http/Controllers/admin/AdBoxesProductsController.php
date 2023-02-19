<?php

namespace Modules\Shop\Http\Controllers\admin;

use App\Classes\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdBoxProductRequest;
use App\Models\AdBoxProductTranslation;
use App\Models\Language;
use App\Models\OtherSetting;
use Illuminate\Http\Request;
use Modules\Shop\Entities\AdBoxProduct;

class AdBoxesProductsController extends Controller
{
    public function index()
    {
        $adBoxesWaitingAction = AdBoxProduct::waitingAction()->orderByPosition('asc')->with('translations')->get();
        $adBoxesFirstType     = AdBoxProduct::firstType()->orderByPosition('asc')->with('translations')->get();

        $defaultLanguage = LanguageHelper::getDefaultLanguage();
        $languages       = Language::active(true)->get();

        return view('admin.adboxes_products.index', compact('adBoxesWaitingAction', 'adBoxesFirstType', 'defaultLanguage', 'languages'));
    }
    public function active($id, $active)
    {
        $adBox = AdBoxProduct::find($id);
        if (is_null($adBox)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $adBox->update(['active' => $active]);

        return redirect('admin/product_adboxes')->with('success-message', 'administration_messages.successful_edit');
    }
    public function update($id, AdBoxProductRequest $request)
    {
        $adBox = AdBoxProduct::find($id);
        if (is_null($adBox)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $languages           = LanguageHelper::getActiveLanguages();
        $adBoxType           = ($adBox->type == 0) ? $request->type : $adBox->type;
        $request['position'] = $adBox->updatedPosition($request, $adBox, $adBoxType);
        $adBox->update($adBox->getUpdateData($request));
        foreach ($languages as $language) {
            $adBoxTranslation = $adBox->translations->where('language_id', $language->id)->first();
            if (is_null($adBoxTranslation)) {
                $adBox->translations()->create(AdBoxProductTranslation::getCreateData($language, $request));
            } else {
                $adBoxTranslation->update($adBoxTranslation->getUpdateData($language, $request));
            }
        }

        return redirect('admin/product_adboxes')->with('success-message', 'administration_messages.successful_edit');
    }
    public function edit($id)
    {
        $adBox = AdBoxProduct::find($id);
        if (is_null($adBox)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $languages       = Language::where('active', true)->get();
        $defaultLanguage = Language::where('code', env('DEF_LANG_CODE'))->first();
        $adBoxes         = AdBoxProduct::where('type', $adBox->type)->with('translations')->orderBy('position', 'asc')->get();
        $otherSettings   = OtherSetting::first();

        return view('admin.adboxes_products.edit', compact('adBox', 'languages', 'defaultLanguage', 'adBoxes', 'otherSettings'));
    }
    public function deleteMultiple(Request $request)
    {
        if (!is_null($request->ids[0])) {
            $ids = array_map('intval', explode(',', $request->ids[0]));
            foreach ($ids as $id) {
                $adBox = AdBoxProduct::find($id);
                if (is_null($adBox)) {
                    continue;
                }

                $adBoxesToUpdate = AdBoxProduct::where('type', $adBox->type)->where('position', '>', $adBox->position)->get();
                $adBox->delete();
                foreach ($adBoxesToUpdate as $adBoxToUpdate) {
                    $adBoxToUpdate->update(['position' => $adBoxToUpdate->position - 1]);
                }
            }

            return redirect()->back()->with('success-message', 'administration_messages.successful_delete');
        }

        return redirect()->back()->withErrors(['administration_messages.no_checked_checkboxes']);
    }
    public function delete($id)
    {
        $adBox = AdBoxProduct::find($id);
        if (is_null($adBox)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $adBoxesToUpdate = AdBoxProduct::where('type', $adBox->type)->where('position', '>', $adBox->position)->get();
        $adBox->delete();
        foreach ($adBoxesToUpdate as $adBoxToUpdate) {
            $adBoxToUpdate->update(['position' => $adBoxToUpdate->position - 1]);
        }

        return redirect()->back()->with('success-message', 'administration_messages.successful_delete');
    }
    public function activeMultiple($active, Request $request)
    {
        if (!is_null($request->ids[0])) {
            $ids = array_map('intval', explode(',', $request->ids[0]));
            AdBoxProduct::whereIn('id', $ids)->update(['active' => $active]);
        }

        return redirect('admin/product_adboxes')->with('success-message', 'administration_messages.successful_edit');
    }

    public function positionDown($id)
    {
        $adBox = AdBoxProduct::find($id);
        if (is_null($adBox)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $nextAdbox = AdBoxProduct::where('type', $adBox->type)->where('position', $adBox->position + 1)->first();
        if (!is_null($nextAdbox)) {
            $nextAdbox->update(['position' => $nextAdbox->position - 1]);
            $adBox->update(['position' => $adBox->position + 1]);
        }

        return redirect('admin/product_adboxes')->with('success-message', 'administration_messages.successful_edit');
    }

    public function positionUp($id)
    {
        $adBox = AdBoxProduct::find($id);
        if (is_null($adBox)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $prevAdbox = AdBoxProduct::where('type', $adBox->type)->where('position', $adBox->position - 1)->first();
        if (!is_null($prevAdbox)) {
            $prevAdbox->update(['position' => $prevAdbox->position + 1]);
            $adBox->update(['position' => $adBox->position - 1]);
        }

        return redirect('admin/product_adboxes')->with('success-message', 'administration_messages.successful_edit');
    }

    public function ajaxUpdatePositions($id, $position)
    {
        $adBox = AdBoxProduct::find($id);
        if (is_null($adBox)) {
            return 0;
        }

        $request['position'] = $position;
        $adBox->updatedPosition($request);

        return 1;
    }

    public function returnToWaiting($id)
    {
        $adBox = AdBoxProduct::find($id);
        if (is_null($adBox)) {
            return back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $adBox->update(['type' => 0]);

        return redirect('admin/product_adboxes')->with('success-message', 'administration_messages.successful_edit');
    }
}
