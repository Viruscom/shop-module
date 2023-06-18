<?php

namespace Modules\Shop\Http\Controllers\admin\ProductAttributes;

use App\Actions\CommonControllerAction;
use App\Helpers\CacheKeysHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\MainHelper;
use App\Http\Controllers\Controller;
use App\Interfaces\PositionInterface;
use App\Models\ProductCategory;
use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Shop\Http\Requests\ProductAttributeStoreRequest;
use Modules\Shop\Http\Requests\ProductAttributeUpdateRequest;
use Modules\Shop\Interfaces\ShopProductAttributeInterface;
use Modules\Shop\Models\Admin\ProductAttribute\ProductAttribute;
use Modules\Shop\Models\Admin\ProductAttribute\ProductAttributePivot;
use Modules\Shop\Models\Admin\ProductCategory\Category;
use Modules\Shop\Models\Admin\ProductCategory\CategoryTranslation;

class ProductAttributesController extends Controller implements ShopProductAttributeInterface, PositionInterface
{
    public function index()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ATTRIBUTES_ADMIN))) {
            ProductAttribute::cacheUpdate();
        }

        return view('shop::admin.product_attributes.index', ['productAttributes' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ATTRIBUTES_ADMIN)]);
    }
    public function store(ProductAttributeStoreRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $productAttribute = $action->doSimpleCreate(ProductAttribute::class, $request);

        if ($request->has('productCategories')) {
            foreach ($request->productCategories as $key => $productCategoryId) {
                ProductAttributePivot::create([
                                                  'pattr_id'            => $productAttribute->id,
                                                  'product_category_id' => $productCategoryId
                                              ]);
            }
        }

        ProductAttribute::cacheUpdate();

        $productAttribute->storeAndAddNew($request);

        return redirect()->route('admin.product-attributes.index')->with('success-message', trans('admin.common.successful_create'));
    }
    public function create()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ATTRIBUTES_ADMIN))) {
            ProductAttribute::cacheUpdate();
        }
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN))) {
            Category::cacheUpdate();
        }

        return view('shop::admin.product_attributes.create', [
            'languages'         => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo'     => Category::getUserInfoMessage(),
            'productCategories' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN),
            'characteristics'   => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ATTRIBUTES_ADMIN)
        ]);
    }
    public function edit($id)
    {
        $productCategory = ProductAttribute::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($productCategory);

        return view('shop::admin.product_categories.edit', [
            'category'      => $productCategory,
            'categories'    => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN),
            'languages'     => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo' => Category::getUserInfoMessage()
        ]);
    }
    public function positionUp($id, CommonControllerAction $action): RedirectResponse
    {
        $productCharacteristic = ProductAttribute::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($productCharacteristic);

        $action->positionUp(ProductAttribute::class, $productCharacteristic);
        ProductAttribute::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function positionDown($id, CommonControllerAction $action): RedirectResponse
    {
        $productCharacteristic = ProductAttribute::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($productCharacteristic);

        $action->positionDown(ProductAttribute::class, $productCharacteristic);
        ProductAttribute::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $action->deleteMultiple($request, ProductAttribute::class);

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
    }
    public function delete($id, CommonControllerAction $action): RedirectResponse
    {
        $productCharacteristic = ProductAttribute::where('id', $id)->first();
        MainHelper::goBackIfNull($productCharacteristic);

        $action->delete(ProductAttribute::class, $productCharacteristic);

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function activeMultiple($active, Request $request, CommonControllerAction $action): RedirectResponse
    {
        $action->activeMultiple(ProductAttribute::class, $request, $active);
        ProductAttribute::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function active($id, $active): RedirectResponse
    {
        $productCharacteristic = ProductAttribute::find($id);
        MainHelper::goBackIfNull($productCharacteristic);

        $productCharacteristic->update(['active' => $active]);
        ProductAttribute::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function update($id, ProductAttributeUpdateRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $productCategory = Category::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($productCategory);

        $request['main_category'] = $productCategory->main_category;
        $action->doSimpleUpdate(Category::class, CategoryTranslation::class, $productCategory, $request);
        $action->updateUrlCache($productCategory, CategoryTranslation::class);
        $action->updateSeo($request, $productCategory, 'Category');

        if ($request->has('image')) {
            $request->validate(['image' => Category::getFileRules()], [Category::getUserInfoMessage()]);
            $productCategory->saveFile($request->image);
        }

        Category::cacheUpdate();

        if (!is_null($productCategory->main_category)) {
            return redirect()->route('admin.product-categories.sub-categories.index', ['id' => $productCategory->main_category])->with('success-message', trans('admin.common.successful_create'));
        }

        return redirect()->route('admin.product-categories.index')->with('success-message', 'admin.common.successful_edit');
    }
    public function subCategoriesIndex($id)
    {
        $productCategory = Category::find($id);
        MainHelper::goBackIfNull($productCategory);

        $categories = Category::where('main_category', $productCategory->id)->with('translations')->orderBy('position')->get();

        return view('shop::admin.product_categories.index', ['categories' => $categories, 'mainCategory' => $productCategory]);
    }

    public function subCategoriesCreate($id)
    {
        $productCategory = Category::find($id);
        MainHelper::goBackIfNull($productCategory);

        return view('shop::admin.product_categories.create', [
            'languages'     => LanguageHelper::getActiveLanguages(),
            'fileRulesInfo' => Category::getUserInfoMessage(),
            'categories'    => Category::where('main_category', $productCategory->id)->with('translations')->orderBy('position')->get(),
            'mainCategory'  => $productCategory
        ]);
    }
}
