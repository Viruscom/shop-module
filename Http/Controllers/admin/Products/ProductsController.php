<?php

    namespace Modules\Shop\Http\Controllers\admin\Products;

    use App\Actions\CommonControllerAction;
    use App\Helpers\CacheKeysHelper;
    use App\Helpers\LanguageHelper;
    use App\Helpers\MainHelper;
    use App\Helpers\ModuleHelper;
    use App\Http\Controllers\Controller;
    use App\Models\Files\File;
    use Cache;
    use Illuminate\Contracts\Support\Renderable;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Modules\Catalogs\Models\MainCatalog;
    use Modules\RetailObjectsRestourant\Models\ProductAdditive;
    use Modules\RetailObjectsRestourant\Models\ProductAdditivePivot;
    use Modules\Shop\Actions\ProductAction;
    use Modules\Shop\Entities\Settings\Main\CountrySale;
    use Modules\Shop\Http\Requests\ProductStoreRequest;
    use Modules\Shop\Http\Requests\ProductUpdateRequest;
    use Modules\Shop\Interfaces\ShopProductInterface;
    use Modules\Shop\Models\Admin\ProductCategory\Category;
    use Modules\Shop\Models\Admin\Products\Product;
    use Modules\Shop\Models\Admin\Products\ProductTranslation;
    use Modules\YanakSoftApi\Entities\YanakProduct;

    class ProductsController extends Controller implements ShopProductInterface
    {
        public function index()
        {
            if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN))) {
                Category::cacheUpdate();
            }

            return view('shop::admin.products.categories', ['categories' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN)]);
        }

        public function store(ProductStoreRequest $request, CommonControllerAction $action, ProductAction $productAction): RedirectResponse
        {
            $action->validateImage($request, 'Shop', 3);
            $product = $action->doSimpleCreate(Product::class, $request);
            $action->updateUrlCache($product, ProductTranslation::class);
            $action->storeSeo($request, $product, 'Product');
            $productAction->createOrUpdateAdditionalFields($request, $product);

            $activeModules = ModuleHelper::getActiveModules();
            if (array_key_exists('RetailObjectsRestourant', $activeModules)) {
                $selectedAdditives            = explode(',', $request->selectedAdditives[0]);
                $selectedAdditivesWithoutList = explode(',', $request->selectedAdditivesWithoutList[0]);

                ProductAdditivePivot::where('product_id', $product->id)->delete();
                ProductAdditivePivot::updateAdditives($product, $selectedAdditives, $selectedAdditivesWithoutList);
            }

            $productAction->storeVatCategoriesByCountry($product, $request->saleCountries);
            Product::cacheUpdate();

            if ($request->has('submitaddnew')) {
                return redirect()->back()->with('success-message', 'admin.common.successful_create');
            }

            return redirect()->route('admin.products.index_by_category', ['category_id' => $product->category->id])->with('success-message', trans('admin.common.successful_create'));
        }

        public function delete($id, CommonControllerAction $action): RedirectResponse
        {
            $product = Product::find($id);
            MainHelper::goBackIfNull($product);

            $action->deleteFromUrlCache($product);
            $action->delete(Product::class, $product);

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        public function edit($id, ProductAction $action)
        {
            $action->checkForFilesCache();
            $action->checkForBrandsCache();
            $action->checkForProductCategoriesAdminCache();
            $action->checkForMeasureUnitsCache();

            $product = Product::whereId($id)->with('translations', 'category', 'category.products')->first();
            MainHelper::goBackIfNull($product);

            $activeModules = ModuleHelper::getActiveModules();
            $data          = [
                'product'           => $product,
                'products'          => $product->category->products,
                'languages'         => LanguageHelper::getActiveLanguages(),
                'files'             => Cache::get(CacheKeysHelper::$FILES),
                'filesPathUrl'      => File::getFilesPathUrl(),
                'fileRulesInfo'     => Product::getUserInfoMessage(),
                'productCategoryId' => $product->category->id,
                'productCategories' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN),
                'brands'            => Cache::get(CacheKeysHelper::$SHOP_BRAND_ADMIN),
                'measureUnits'      => Cache::get(CacheKeysHelper::$SHOP_MEASURE_UNITS_ADMIN),
                'activeModules'     => $activeModules,
                'saleCountries'     => CountrySale::with('country')->get(),
            ];

            if (array_key_exists('Catalogs', $activeModules)) {
                if (is_null(CacheKeysHelper::$CATALOGS_MAIN_FRONT)) {
                    MainCatalog::cacheUpdate();
                }
                $data['mainCatalogs'] = cache()->get(CacheKeysHelper::$CATALOGS_MAIN_FRONT);
            }
            if (array_key_exists('RetailObjectsRestourant', $activeModules)) {
                if (is_null(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES)) {
                    ProductAdditive::cacheUpdate();
                }
                $data['productAdditives']                 = cache()->get(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES);
                $data['selectedProductsAdditives']        = $product->additives(false)->get();
                $data['selectedWithoutProductsAdditives'] = $product->additives(true)->get();
            }
            if (array_key_exists('YanakSoftApi', $activeModules)) {
                if (is_null(CacheKeysHelper::$YANAK_API_PRODUCTS_ADMIN)) {
                    YanakProduct::cacheUpdate();
                }
                $data['yanakProducts'] = cache()->get(CacheKeysHelper::$YANAK_API_PRODUCTS_ADMIN);
            }

            return view('shop::admin.products.edit', $data);
        }

        public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
        {
            if (!is_null($request->ids[0])) {
                $ids = array_map('intval', explode(',', $request->ids[0]));
                foreach ($ids as $id) {
                    $model = Product::find($id);
                    if (is_null($model)) {
                        continue;
                    }

                    if ($model->existsFile($model->filename)) {
                        $model->deleteFile($model->filename);
                    }

                    $modelsToUpdate = Product::where('category_id', $model->category_id)->where('position', '>', $model->position)->get();
                    if (method_exists(get_class($model), 'seoFields')) {
                        $model->seoFields()->delete();
                    }

                    $model->delete();
                    foreach ($modelsToUpdate as $modelToUpdate) {
                        $modelToUpdate->update(['position' => $modelToUpdate->position - 1]);
                    }
                }

                Product::cacheUpdate();

                return redirect()->back()->with('success-message', 'admin.common.successful_delete');
            }

            return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
        }

        public function update($id, ProductUpdateRequest $request, CommonControllerAction $action, ProductAction $productAction): RedirectResponse
        {
            $product = Product::whereId($id)->with('translations')->first();
            MainHelper::goBackIfNull($product);

            $action->validateImage($request, 'Shop', 3);
            $action->doSimpleUpdate(Product::class, ProductTranslation::class, $product, $request);
            $action->updateUrlCache($product, ProductTranslation::class);
            $action->updateSeo($request, $product, 'Product');
            $productAction->createOrUpdateAdditionalFields($request, $product);

            if ($request->has('image')) {
                $request->validate(['image' => Product::getFileRules()], [Product::getUserInfoMessage()]);
                $product->saveFile($request->image);
            }

            $activeModules = ModuleHelper::getActiveModules();
            if (array_key_exists('RetailObjectsRestourant', $activeModules)) {
                $selectedAdditives            = explode(',', $request->selectedAdditives[0]);
                $selectedAdditivesWithoutList = explode(',', $request->selectedAdditivesWithoutList[0]);

                ProductAdditivePivot::where('product_id', $product->id)->delete();
                ProductAdditivePivot::updateAdditives($product, $selectedAdditives, $selectedAdditivesWithoutList);
            }
            $productAction->updateVatCategoriesByCountry($product, $request->saleCountries);
            Product::cacheUpdate();

            return redirect()->route('admin.products.index_by_category', ['category_id' => $product->category->id])->with('success-message', 'admin.common.successful_edit');
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

        public function create($category_id, ProductAction $action): Renderable
        {
            $productCategory = Category::where('id', $category_id)->with(['products' => function ($query) {
                $query->with('translations')->orderBy('position');
            }])->first();
            MainHelper::goBackIfNull($productCategory);

            $action->checkForFilesCache();
            $action->checkForBrandsCache();
            $action->checkForProductCategoriesAdminCache();
            $action->checkForMeasureUnitsCache();

            $activeModules = ModuleHelper::getActiveModules();
            $data          = [
                'languages'         => LanguageHelper::getActiveLanguages(),
                'files'             => Cache::get(CacheKeysHelper::$FILES),
                'filesPathUrl'      => File::getFilesPathUrl(),
                'fileRulesInfo'     => Product::getUserInfoMessage(),
                'productCategoryId' => $productCategory->id,
                'products'          => $productCategory->products,
                'productCategories' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CATEGORY_ADMIN),
                'brands'            => Cache::get(CacheKeysHelper::$SHOP_BRAND_ADMIN),
                'measureUnits'      => Cache::get(CacheKeysHelper::$SHOP_MEASURE_UNITS_ADMIN),
                'activeModules'     => $activeModules,
                'saleCountries'     => CountrySale::with('country')->get()
            ];

            if (array_key_exists('Catalogs', $activeModules)) {
                if (is_null(CacheKeysHelper::$CATALOGS_MAIN_FRONT)) {
                    MainCatalog::cacheUpdate();
                }
                $data['mainCatalogs'] = cache()->get(CacheKeysHelper::$CATALOGS_MAIN_FRONT);
            }

            if (array_key_exists('RetailObjectsRestourant', $activeModules)) {
                if (is_null(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES)) {
                    ProductAdditive::cacheUpdate();
                }
                $data['productAdditives'] = cache()->get(CacheKeysHelper::$SHOP_PRODUCT_ADDITIVES);
            }
            if (array_key_exists('YanakSoftApi', $activeModules)) {
                if (is_null(CacheKeysHelper::$YANAK_API_PRODUCTS_ADMIN)) {
                    YanakProduct::cacheUpdate();
                }
                $data['yanakProducts'] = cache()->get(CacheKeysHelper::$YANAK_API_PRODUCTS_ADMIN);
            }

            return view('shop::admin.products.create', $data);
        }

        public function positionUp($id, ProductAction $productAction): RedirectResponse
        {
            $product = Product::whereId($id)->with('translations')->first();
            MainHelper::goBackIfNull($product);

            $productAction->positionUp(Product::class, $product);
            Product::cacheUpdate();

            return redirect()->back()->with('success-message', 'admin.common.successful_edit');
        }

        public function positionDown($id, ProductAction $productAction): RedirectResponse
        {
            $product = Product::whereId($id)->with('translations')->first();
            MainHelper::goBackIfNull($product);

            $productAction->positionDown(Product::class, $product);
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

            return redirect()->back()->with('success-message', trans('admin.common.successful_create'));
        }

        public function makeAdBox($id, ProductAction $action)
        {
            $product = Product::find($id);
            MainHelper::goBackIfNull($product);

            $action->sendToAdBox($product);

            return redirect()->back()->with('success-message', trans('admin.common.successful_create'));
        }

        public function getCategoryProducts($category_id)
        {
            $productCategory = Category::where('id', $category_id)->with(['products' => function ($query) {
                $query->with('translations')->orderBy('position');
            }])->first();
            MainHelper::goBackIfNull($productCategory);

            return view('shop::admin.products.index', [
                'productCategory' => $productCategory,
                'products'        => $productCategory->products
            ]);
        }
    }
