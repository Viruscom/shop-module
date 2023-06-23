<?php

namespace Modules\Shop\Http\Controllers\admin\Settings\MeasuringUnits;

use App\Actions\CommonControllerAction;
use App\Helpers\CacheKeysHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\MainHelper;
use App\Helpers\WebsiteHelper;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Shop\Entities\Settings\MeasureUnit;
use Modules\Shop\Entities\Settings\MeasureUnitTranslation;
use Modules\Shop\Http\Requests\ProductAttributeStoreRequest;
use Modules\Shop\Http\Requests\ProductAttributeUpdateRequest;

class MeasuringUnitsController extends Controller
{
    public function index()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_MEASURE_UNITS_ADMIN))) {
            MeasureUnit::cacheUpdate();
        }

        return view('shop::admin.settings.measure_units.index', ['units' => Cache::get(CacheKeysHelper::$SHOP_MEASURE_UNITS_ADMIN)]);
    }
    public function store(ProductAttributeStoreRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $measureUnit = $action->doSimpleCreate(MeasureUnit::class, $request);

        MeasureUnit::cacheUpdate();

        $measureUnit->storeAndAddNew($request);

        return redirect()->route('admin.measuring-units.index')->with('success-message', trans('admin.common.successful_create'));
    }
    public function edit($id)
    {
        $measureUnit = MeasureUnit::where('id', $id)->with('translations')->first();
        WebsiteHelper::redirectBackIfNull($measureUnit);

        if (is_null(Cache::get(CacheKeysHelper::$SHOP_MEASURE_UNITS_ADMIN))) {
            MeasureUnit::cacheUpdate();
        }

        return view('shop::admin.settings.measure_units.edit', [
            'unit'      => $measureUnit,
            'languages' => LanguageHelper::getActiveLanguages(),
        ]);
    }

    public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $action->deleteMultiple($request, MeasureUnit::class);

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
    }

    public function update($id, ProductAttributeUpdateRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $measureUnit = MeasureUnit::find($id);
        if (is_null($measureUnit)) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.page_not_found']);
        }

        $action->doSimpleUpdate(MeasureUnit::class, MeasureUnitTranslation::class, $measureUnit, $request);

        MeasureUnit::cacheUpdate();

        return redirect()->route('admin.measuring-units.index')->with('success-message', 'admin.common.successful_edit');
    }
    public function delete($id, CommonControllerAction $action): RedirectResponse
    {
        $measureUnit = MeasureUnit::where('id', $id)->first();
        MainHelper::goBackIfNull($measureUnit);

        $action->delete(MeasureUnit::class, $measureUnit);

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function create()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_MEASURE_UNITS_ADMIN))) {
            MeasureUnit::cacheUpdate();
        }

        return view('shop::admin.settings.measure_units.create', [
            'languages' => LanguageHelper::getActiveLanguages(),
        ]);
    }
}
