<?php

namespace Modules\Shop\Http\Controllers\admin;

use App\Actions\CommonControllerAction;
use App\Helpers\CacheKeysHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\MainHelper;
use App\Http\Controllers\Controller;
use App\Interfaces\PositionInterface;
use App\Models\CategoryPage\CategoryPage;
use App\Models\CategoryPage\CategoryPageTranslation;
use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Shop\Http\Requests\BrandStoreRequest;
use Modules\Shop\Http\Requests\BrandUpdateRequest;
use Modules\Shop\Interfaces\ShopBrandInterface;

class BrandController extends Controller implements ShopBrandInterface, PositionInterface
{
    public function index()
    {
        if (is_null(Cache::get(CacheKeysHelper::$CATEGORY_PAGE_ADMIN))) {
            CategoryPage::cacheUpdate();
        }

        return view('admin.category_pages.index', ['categoryPages' => Cache::get(CacheKeysHelper::$CATEGORY_PAGE_ADMIN)]);
    }
    public function store(BrandStoreRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $categoryPage = $action->doSimpleCreate(CategoryPage::class, $request);
        $action->updateUrlCache($categoryPage, CategoryPageTranslation::class);
        CategoryPage::cacheUpdate();

        $categoryPage->storeAndAddNew($request);

        return redirect()->route('admin.category-page.index')->with('success-message', trans('admin.common.successful_create'));
    }
    public function create()
    {
        return view('admin.category_pages.create', [
            'languages'     => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo' => CategoryPage::getUserInfoMessage()
        ]);
    }
    public function edit($id)
    {
        $categoryPage = CategoryPage::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($categoryPage);

        return view('admin.category_pages.edit', [
            'categoryPage'  => $categoryPage,
            'languages'     => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo' => CategoryPage::getUserInfoMessage()
        ]);
    }
    public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $action->deleteMultiple($request, CategoryPage::class);

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
    }
    public function delete($id, CommonControllerAction $action): RedirectResponse
    {
        $categoryPage = CategoryPage::find($id);
        MainHelper::goBackIfNull($categoryPage);

        $action->delete(CategoryPage::class, $categoryPage);

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function activeMultiple($active, Request $request, CommonControllerAction $action): RedirectResponse
    {
        $action->activeMultiple(CategoryPage::class, $request, $active);
        CategoryPage::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function active($id, $active): RedirectResponse
    {
        $categoryPage = CategoryPage::find($id);
        MainHelper::goBackIfNull($categoryPage);

        $categoryPage->update(['active' => $active]);
        CategoryPage::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function update($id, BrandUpdateRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $categoryPage = CategoryPage::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($categoryPage);

        $action->doSimpleUpdate(CategoryPage::class, CategoryPageTranslation::class, $categoryPage, $request);
        $action->updateUrlCache($categoryPage, CategoryPageTranslation::class);

        if ($request->has('image')) {
            $request->validate(['image' => CategoryPage::getFileRules()], [CategoryPage::getUserInfoMessage()]);
            $categoryPage->saveFile($request->image);
        }

        CategoryPage::cacheUpdate();

        return redirect()->route('admin.category-page.index')->with('success-message', 'admin.common.successful_edit');
    }
    public function positionUp($id, CommonControllerAction $action): RedirectResponse
    {
        $categoryPage = CategoryPage::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($categoryPage);

        $action->positionUp(CategoryPage::class, $categoryPage);
        CategoryPage::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }

    public function positionDown($id, CommonControllerAction $action): RedirectResponse
    {
        $categoryPage = CategoryPage::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($categoryPage);

        $action->positionDown(CategoryPage::class, $categoryPage);
        CategoryPage::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }

    public function deleteImage($id, CommonControllerAction $action): RedirectResponse
    {
        $categoryPage = CategoryPage::find($id);
        MainHelper::goBackIfNull($categoryPage);

        if ($action->imageDelete($categoryPage, CategoryPage::class)) {
            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.image_not_found']);
    }
}
