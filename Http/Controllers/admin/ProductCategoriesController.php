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
use Modules\Shop\Http\Requests\ProductCategoryStoreRequest;
use Modules\Shop\Http\Requests\ProductCategoryUpdateRequest;
use Modules\Shop\Interfaces\ShopProductCategoryInterface;
use Modules\Shop\Models\Admin\ProductCategory\Category;
use Modules\Shop\Models\Admin\ProductCategory\CategoryTranslation;

class ProductCategoriesController extends Controller implements ShopProductCategoryInterface, PositionInterface
{
    public function index()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN))) {
            Category::cacheUpdate();
        }

        return view('shop::admin.product_categories.index', ['categories' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN)]);
    }
    public function store(ProductCategoryStoreRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $productCategory = $action->doSimpleCreate(Category::class, $request);
        $action->updateUrlCache($productCategory, CategoryTranslation::class);
        $action->storeSeo($request, $productCategory, 'Category');
        Category::cacheUpdate();

        $productCategory->storeAndAddNew($request);

        return redirect()->route('admin.product-categories.index')->with('success-message', trans('admin.common.successful_create'));
    }
    public function create()
    {
        return view('shop::admin.product_categories.create', [
            'languages'     => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo' => Category::getUserInfoMessage(),
            'categories'    => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN)
        ]);
    }
    public function edit($id)
    {
        $productCategory = Category::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($productCategory);

        return view('shop::admin.product_categories.edit', [
            'category'      => $productCategory,
            'categories'    => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN),
            'languages'     => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo' => Category::getUserInfoMessage()
        ]);
    }
    public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $action->deleteMultiple($request, Category::class);

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
    }
    public function delete($id, CommonControllerAction $action): RedirectResponse
    {
        $productCategory = Category::find($id);
        MainHelper::goBackIfNull($productCategory);

        $action->deleteFromUrlCache($productCategory);
        $action->delete(Category::class, $productCategory);

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function activeMultiple($active, Request $request, CommonControllerAction $action): RedirectResponse
    {
        $action->activeMultiple(Category::class, $request, $active);
        Category::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function active($id, $active): RedirectResponse
    {
        $productCategory = Category::find($id);
        MainHelper::goBackIfNull($productCategory);

        $productCategory->update(['active' => $active]);
        Category::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function update($id, ProductCategoryUpdateRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $productCategory = Category::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($productCategory);

        $action->doSimpleUpdate(Category::class, CategoryTranslation::class, $productCategory, $request);
        $action->updateUrlCache($productCategory, CategoryTranslation::class);
        $action->updateSeo($request, $productCategory, 'Category');

        if ($request->has('image')) {
            $request->validate(['image' => Category::getFileRules()], [Category::getUserInfoMessage()]);
            $productCategory->saveFile($request->image);
        }

        Category::cacheUpdate();

        return redirect()->route('admin.product-categories.index')->with('success-message', 'admin.common.successful_edit');
    }
    public function positionUp($id, CommonControllerAction $action): RedirectResponse
    {
        $productCategory = Category::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($productCategory);

        $action->positionUp(Category::class, $productCategory);
        Category::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }

    public function positionDown($id, CommonControllerAction $action): RedirectResponse
    {
        $productCategory = Category::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($productCategory);

        $action->positionDown(Category::class, $productCategory);
        Category::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }

    public function deleteImage($id, CommonControllerAction $action): RedirectResponse
    {
        $productCategory = Category::find($id);
        MainHelper::goBackIfNull($productCategory);

        if ($action->imageDelete($productCategory, Category::class)) {
            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.image_not_found']);
    }
}
