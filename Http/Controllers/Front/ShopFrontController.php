<?php

    namespace Modules\Shop\Http\Controllers\Front;

    use App\Helpers\WebsiteHelper;
    use App\Http\Controllers\Controller;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Modules\Product\Models\Admin\Products\ProductTranslation;
    use Modules\Shop\Models\Admin\Brands\BrandTranslation;
    use Modules\Shop\Models\Admin\ProductCategory\Category;
    use Modules\Shop\Models\Admin\ProductCategory\CategoryTranslation;

    class ShopFrontController extends Controller
    {
        public function loadShopBrandPage($languageSlug, $slug)
        {
            $viewArray['currentModel'] = BrandTranslation::where('url', 'brand/' . $slug)->with('parent')->first();
            WebsiteHelper::abortIfNull($viewArray['currentModel']);

            WebsiteHelper::loadCollectionsForModules($viewArray['currentModel'], $viewArray['currentModel']->parent);
            $eagerLoadRelations = [];
            WebsiteHelper::loadGalleryRelations($viewArray['currentModel']->parent, $eagerLoadRelations);

            return view('shop::front.brands.show', ['viewArray' => $viewArray]);
        }

        public function loadShopCategoryPage($languageSlug, $slug)
        {
            $viewArray['currentModel'] = CategoryTranslation::where('url', 'category/' . $slug)->with('parent')->first();
            WebsiteHelper::abortIfNull($viewArray['currentModel']);

            WebsiteHelper::loadCollectionsForModules($viewArray['currentModel'], $viewArray['currentModel']->parent);
            $eagerLoadRelations = [];
            WebsiteHelper::loadGalleryRelations($viewArray['currentModel']->parent, $eagerLoadRelations);

            $categories = Category::where('active', true)
                ->whereNull('main_category')
                ->with('translations')
                ->with(['subCategories' => function ($q) {
                    return $q->where('active', true)->with(['subCategories' => function ($qq) {
                        return $qq->where('active', true)->orderBy('position');
                    }])->orderBy('position');
                }])
                ->orderBy('position')
                ->get();

            // Получаване на продуктите рекурсивно
            $products = $viewArray['currentModel']->parent->getAllProducts();

            // Параметри за странициране
            $currentPage  = LengthAwarePaginator::resolveCurrentPage();
            $perPage      = 28;
            $currentItems = $products->slice(($currentPage - 1) * $perPage, $perPage)->all();

            // Създаване на страницираните продукти с правилен път
            $paginatedProducts = new LengthAwarePaginator($currentItems, $products->count(), $perPage, $currentPage, [
                'path'     => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]);

            // Извличане на уникалните брандове и атрибути на продуктите
            $brands            = collect($paginatedProducts->items())->pluck('brand')->unique();
            $productAttributes = $viewArray['currentModel']->parent->productAttributes->unique('id');

            session()->forget([
                                  'filteredProducts',
                                  'selectedBrands',
                                  'selectedAttributes',
                                  'startPriceRange',
                                  'endPriceRange',
                                  'maxStockBar',
                              ]);

            // Връщане на изгледа с данните
            return view('shop::front.categories.show', [
                'viewArray'         => $viewArray,
                'categories'        => $categories,
                'brands'            => $brands,
                'products'          => $paginatedProducts,
                'productAttributes' => $productAttributes,
                'queryParameters'   => []
            ]);
        }

        public function loadShopProductPage($languageSlug, $slug)
        {
            $viewArray['currentModel'] = ProductTranslation::where('url', 'product/' . $slug)->with('parent')->first();
            WebsiteHelper::abortIfNull($viewArray['currentModel']);

            WebsiteHelper::loadCollectionsForModules($viewArray['currentModel'], $viewArray['currentModel']->parent);
            $eagerLoadRelations = [];
            WebsiteHelper::loadGalleryRelations($viewArray['currentModel']->parent, $eagerLoadRelations);

            return view('shop::front.products.show', ['viewArray' => $viewArray]);
        }
    }
