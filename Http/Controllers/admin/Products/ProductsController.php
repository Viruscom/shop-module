<?php

namespace Modules\Shop\Http\Controllers\admin\Products;

use App\Actions\CommonControllerAction;
use App\Helpers\CacheKeysHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\MainHelper;
use App\Helpers\ModuleHelper;
use App\Http\Controllers\Controller;
use App\Interfaces\PositionInterface;
use App\Models\Files\File;
use Cache;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Shop\Actions\ProductAction;
use Modules\Shop\Http\Requests\ProductStoreRequest;
use Modules\Shop\Http\Requests\ProductUpdateRequest;
use Modules\Shop\Interfaces\ShopProductInterface;
use Modules\Shop\Models\Admin\Products\Product;
use Modules\Shop\Models\Admin\Products\ProductTranslation;

class ProductsController extends Controller implements ShopProductInterface, PositionInterface
{
    public function index()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADMIN))) {
            Product::cacheUpdate();
        }

        return view('shop::admin.products.index', ['products' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADMIN)]);
    }
    public function store(ProductStoreRequest $request, CommonControllerAction $action, ProductAction $productAction): RedirectResponse
    {
        $product = $action->doSimpleCreate(Product::class, $request);
        $action->updateUrlCache($product, ProductTranslation::class);
        $action->storeSeo($request, $product, 'Product');
        $productAction->createOrUpdateAdditionalFields($request, $product);

        Product::cacheUpdate();

        $product->storeAndAddNew($request);

        return redirect()->route('admin.products.index')->with('success-message', trans('admin.common.successful_create'));
    }
    public function create(ProductAction $action): Renderable
    {
        $action->checkForFilesCache();
        $action->checkForBrandsCache();
        $action->checkForProductCategoriesAdminCache();

        $data = [
            'languages'         => LanguageHelper::getActiveLanguages(),
            'files'             => Cache::get(CacheKeysHelper::$FILES),
            'filesPathUrl'      => File::getFilesPathUrl(),
            'fileRulesInfo'     => Product::getUserInfoMessage(),
            'products'          => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADMIN),
            'productCategories' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN),
            'brands'            => Cache::get(CacheKeysHelper::$SHOP_BRAND_ADMIN)
        ];

        $activeModules = ModuleHelper::getActiveModules();
        if (array_key_exists('Catalogs', $activeModules)) {
            if (is_null(CacheKeysHelper::$CATALOGS_MAIN_FRONT)) {
                \Modules\Catalogs\Models\MainCatalog::cacheUpdate();
            }
            $data['mainCatalogs'] = cache()->get(CacheKeysHelper::$CATALOGS_MAIN_FRONT);
        }

        return view('shop::admin.products.create', $data);
    }
    public function edit($id, ProductAction $action)
    {
        $action->checkForFilesCache();
        $action->checkForBrandsCache();
        $action->checkForProductCategoriesAdminCache();

        $product = Product::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($product);

        $data = [
            'product'           => $product,
            'products'          => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_ADMIN),
            'languages'         => LanguageHelper::getActiveLanguages(),
            'files'             => Cache::get(CacheKeysHelper::$FILES),
            'filesPathUrl'      => File::getFilesPathUrl(),
            'fileRulesInfo'     => Product::getUserInfoMessage(),
            'productCategories' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN),
            'brands'            => Cache::get(CacheKeysHelper::$SHOP_BRAND_ADMIN)
        ];

        $activeModules = ModuleHelper::getActiveModules();
        if (array_key_exists('Catalogs', $activeModules)) {
            if (is_null(CacheKeysHelper::$CATALOGS_MAIN_FRONT)) {
                \Modules\Catalogs\Models\MainCatalog::cacheUpdate();
            }
            $data['mainCatalogs'] = cache()->get(CacheKeysHelper::$CATALOGS_MAIN_FRONT);
        }

        return view('shop::admin.products.edit', $data);
    }
    public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $action->deleteMultiple($request, Product::class);

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
    }
    public function delete($id, CommonControllerAction $action): RedirectResponse
    {
        $product = Product::find($id);
        MainHelper::goBackIfNull($product);

        $action->deleteFromUrlCache($product);
        $action->delete(Product::class, $product);

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function activeMultiple($active, Request $request, CommonControllerAction $action): RedirectResponse
    {
        $action->activeMultiple(Product::class, $request, $active);
        Product::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function active($id, $active): RedirectResponse
    {
        $product = Product::find($id);
        MainHelper::goBackIfNull($product);

        $product->update(['active' => $active]);
        Product::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function update($id, ProductUpdateRequest $request, CommonControllerAction $action, ProductAction $productAction): RedirectResponse
    {
        $product = Product::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($product);

        $action->doSimpleUpdate(Product::class, ProductTranslation::class, $product, $request);
        $action->updateUrlCache($product, ProductTranslation::class);
        $action->updateSeo($request, $product, 'Product');
        $productAction->createOrUpdateAdditionalFields($request, $product);

        if ($request->has('image')) {
            $request->validate(['image' => Product::getFileRules()], [Product::getUserInfoMessage()]);
            $product->saveFile($request->image);
        }

        Product::cacheUpdate();

        return redirect()->route('admin.products.index')->with('success-message', 'admin.common.successful_edit');
    }
    public function positionUp($id, CommonControllerAction $action): RedirectResponse
    {
        $product = Product::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($product);

        $action->positionUp(Product::class, $product);
        Product::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }

    public function positionDown($id, CommonControllerAction $action): RedirectResponse
    {
        $product = Product::whereId($id)->with('translations')->first();
        MainHelper::goBackIfNull($product);

        $action->positionDown(Product::class, $product);
        Product::cacheUpdate();

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }

    public function deleteImage($id, CommonControllerAction $action): RedirectResponse
    {
        $product = Product::find($id);
        MainHelper::goBackIfNull($product);

        if ($action->imageDelete($product, Product::class)) {
            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.image_not_found']);
    }

    public function makeProductAdBox($id, ProductAction $action)
    {
        $product = Product::find($id);
        MainHelper::goBackIfNull($product);

        if ($action->isProductAdBoxExists($product->id)) {
            return redirect()->back()->withErrors(['shop::admin.product_adboxes.product_ad_box_already_exists']);
        }

        $action->sendToProductAdbox($product->id);

        return redirect()->route('admin.products.index')->with('success-message', trans('admin.common.successful_create'));
    }

    public function makeAdBox($id, ProductAction $action)
    {
        $product = Product::find($id);
        MainHelper::goBackIfNull($product);

        $action->sendToAdBox($product);

        return redirect()->route('admin.products.index')->with('success-message', trans('admin.common.successful_create'));
    }
}
