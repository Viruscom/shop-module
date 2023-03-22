<?php

namespace Modules\Shop\Http\Controllers\admin;

use App\Actions\CommonControllerAction;
use App\Helpers\CacheKeysHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\MainHelper;
use App\Http\Controllers\Controller;
use App\Interfaces\PositionInterface;
use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Shop\Actions\BrandAction;
use Modules\Shop\Http\Requests\BrandStoreRequest;
use Modules\Shop\Http\Requests\BrandUpdateRequest;
use Modules\Shop\Interfaces\ShopBrandInterface;
use Modules\Shop\Models\Admin\Brand;
use Modules\Shop\Models\Admin\BrandTranslation;

class BrandController extends Controller implements ShopBrandInterface, PositionInterface
{
    public function index()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_BRAND_ADMIN))) {
            Brand::cacheUpdate();
        }

        return view('shop::admin.brands.index', ['brands' => Cache::get(CacheKeysHelper::$SHOP_BRAND_ADMIN)]);
    }
    public function store(BrandStoreRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $brand = $action->doSimpleCreate(Brand::class, $request);
        $action->updateUrlCache($brand, BrandTranslation::class);

        if ($request->has('logo_image')) {
            $brand->saveFile($request->logo_image);
        }

        Brand::cacheUpdate();

        $brand->storeAndAddNew($request);

        return redirect()->route('admin.brands.index')->with('success-message', trans('admin.common.successful_create'));
    }
    public function create()
    {
        return view('shop::admin.brands.create', [
            'languages'     => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo' => Brand::getUserInfoMessage(),
            'brands'        => Cache::get(CacheKeysHelper::$SHOP_BRAND_ADMIN)
        ]);
    }
    public function edit($id)
    {
        $brand = Brand::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($brand);

        return view('shop::admin.brands.edit', [
            'brand'         => $brand,
            'brands'        => Cache::get(CacheKeysHelper::$SHOP_BRAND_ADMIN),
            'languages'     => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo' => Brand::getUserInfoMessage()
        ]);
    }
    public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $action->deleteMultiple($request, Brand::class);

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
    }
    public function delete($id, CommonControllerAction $action): RedirectResponse
    {
        $brand = Brand::find($id);
        MainHelper::goBackIfNull($brand);

        $action->delete(Brand::class, $brand);

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function activeMultiple($active, Request $request, CommonControllerAction $action): RedirectResponse
    {
        $action->activeMultiple(Brand::class, $request, $active);
        Brand::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function active($id, $active): RedirectResponse
    {
        $brand = Brand::find($id);
        MainHelper::goBackIfNull($brand);

        $brand->update(['active' => $active]);
        Brand::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function update($id, BrandUpdateRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $brand = Brand::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($brand);

        $action->doSimpleUpdate(Brand::class, BrandTranslation::class, $brand, $request);
        $action->updateUrlCache($brand, BrandTranslation::class);

        if ($request->has('image')) {
            $request->validate(['image' => Brand::getFileRules()], [Brand::getUserInfoMessage()]);
            $brand->saveFile($request->image);
        }

        if ($request->has('logo_image')) {
            $request->validate(['logo_image' => Brand::getFileRules()], [Brand::getUserInfoMessage()]);
            $brand->saveFile($request->logo_image);
        }

        Brand::cacheUpdate();

        return redirect()->route('admin.brands.index')->with('success-message', 'admin.common.successful_edit');
    }
    public function positionUp($id, CommonControllerAction $action): RedirectResponse
    {
        $brand = Brand::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($brand);

        $action->positionUp(Brand::class, $brand);
        Brand::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }

    public function positionDown($id, CommonControllerAction $action): RedirectResponse
    {
        $brand = Brand::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($brand);

        $action->positionDown(Brand::class, $brand);
        Brand::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }

    public function deleteImage($id, CommonControllerAction $action): RedirectResponse
    {
        $brand = Brand::find($id);
        MainHelper::goBackIfNull($brand);

        if ($action->imageDelete($brand, Brand::class)) {
            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.image_not_found']);
    }

    public function deleteLogo($id, CommonControllerAction $action, BrandAction $brandAction): RedirectResponse
    {
        $brand = Brand::find($id);
        MainHelper::goBackIfNull($brand);

        if ($brandAction->logoDelete($brand, Brand::class)) {
            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.image_not_found']);
    }
}
