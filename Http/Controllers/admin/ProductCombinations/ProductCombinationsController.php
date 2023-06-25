<?php

namespace Modules\Shop\Http\Controllers\admin\ProductCombinations;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Models\ProductCombination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Shop\Models\Admin\ProductAttribute\ProductAttribute;
use Modules\Shop\Models\Admin\ProductAttribute\Values\ProductAttributeValue;
use Modules\Shop\Models\Admin\Products\Product;

class ProductCombinationsController extends Controller
{
    public function index()
    {
        $languages           = LanguageHelper::getActiveLanguages();
        $productAttributes   = ProductAttribute::with('translations', 'values', 'values.translations')->orderBy('position')->get();
        $products            = Product::with('defaultTranslation')->with('category')->get();
        $productCombinations = is_null(Cache::get('adminProductCombinations')) ? ProductCombination::updateCache() : Cache::get('adminProductCombinations');

        return view('admin.product_combinations.index', compact('products', 'productCombinations', 'productAttributes', 'productAttributeValues', 'defaultLanguage', 'languages'));
    }
    public function updateMultiple(Request $request)
    {
        if (is_array($request->combos)) {
            foreach ($request->combos as $key => $combo) {
                $productCombination = ProductCombination::find($combo['comboId']);
                if (!is_null($productCombination)) {
                    $quantity = str_replace(',', '.', $combo['quantity']);
                    $price    = str_replace(',', '.', $combo['price']);
                    $productCombination->update([
                                                    'quantity' => number_format((float)$quantity, 2, '.', ''),
                                                    'price'    => number_format((float)$price, 2, '.', ''),
                                                    'sku'      => $combo['sku'],
                                                ]);
                }
            }
            ProductCombination::updateCache();

            return 'Успешно обновяване!';
        }

        return 'Няма маркирани редове за обновяване!';
    }
    public function update($id, Request $request): RedirectResponse
    {
        $productCombination = ProductCombination::find($id);
        if (is_null($productCombination)) {
            return redirect()->back()->withErrors(['administration_messages.no_product_combination_found']);
        }
        $quantity = str_replace(',', '.', $request->quantity);
        $price    = str_replace(',', '.', $request->price);
        $productCombination->update([
                                        'quantity' => number_format((float)$quantity, 2, '.', ''),
                                        'price'    => number_format((float)$price, 2, '.', ''),
                                        'sku'      => $request->sku,
                                    ]);
        ProductCombination::updateCache();

        return redirect()->back()->with('success-message', 'administration_messages.successful_update');
    }
    public function deleteMultiple(Request $request): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $ids = array_map('intval', explode(',', $request->ids[0]));
            foreach ($ids as $id) {
                $productCombination = ProductCombination::find($id);
                if (!is_null($productCombination)) {
                    $productCombination->delete();
                }
            }

            ProductCombination::updateCache();

            return redirect()->back()->with('success-message', 'administration_messages.successful_delete');
        }

        return redirect()->back()->withErrors(['administration_messages.no_checked_checkboxes']);
    }
    public function delete($id): RedirectResponse
    {
        $productCombination = ProductCombination::find($id);
        if (is_null($productCombination)) {
            return redirect()->back()->withErrors(['administration_messages.no_product_combination_found']);
        }

        $productCombination->delete();
        ProductCombination::updateCache();

        return redirect()->back()->with('success-message', 'administration_messages.successful_delete');
    }
    public function getAttributesByProductCategory(Request $request)
    {
        $product = Product::where('id', $request->product_id)->with('product_category')->first();
        if (is_null($product)) {
            return 'error404';
        }

        $attributesInCategory = ProductAttributePivot::select('pattr_id')->where('product_category_id', $product->product_category->id)->get();
        if (is_null($attributesInCategory)) {
            return 'error404category';
        }

        return $attributesInCategory;
    }

    public function getProductSkuNumber(Request $request)
    {
        $productSkuNumber = Product::select('product_id_code')->where('id', $request->product_id)->first();
        if (!is_null($productSkuNumber)) {
            return $productSkuNumber;
        }

        return null;
    }

    public function generate(Request $request): RedirectResponse
    {
        if ($request->has('attribute') && is_array($request->attribute) && count($request->attribute)) {
            $mainProduct = Product::find($request->main_product_id);
            if (is_null($mainProduct)) {
                return redirect()->back()->withErrors(['administration_messages.no_product_found']);
            }

            $collection          = collect($mainProduct->id);
            $combinations        = $collection->crossJoin(...$request->attribute);
            $productCombinations = is_null(Cache::get('adminProductCombinations')) ? ProductCombination::updateCache() : Cache::get('adminProductCombinations');

            if ($productCombinations->isEmpty()) {
                foreach ($combinations as $combination) {
                    ProductCombination::create(ProductCombination::getRequestData($request, $combination));
                }
            } else {
                foreach ($combinations as $combination) {
                    $d = [];
                    foreach ($productCombinations as $productCombination) {
                        $d[] = $combination == $productCombination->combination;
                    }
                    if (!in_array(true, $d, true)) {
                        ProductCombination::create(ProductCombination::getRequestData($request, $combination));
                    }
                }
                ProductCombination::updateCache();
            }

            return redirect()->back()->with('success-message', 'administration_messages.successful_create');
        }

        return redirect()->back()->withErrors(['administration_messages.no_product_attribute_values_checked']);
    }

    public function combinationsByProductId($id)
    {
        $mainProduct = Product::find($id);
        if (is_null($mainProduct)) {
            return redirect()->back()->withErrors(['administration_messages.no_product_found']);
        }

        $defaultLanguage        = LanguageHelper::getDefaultLanguage();
        $languages              = LanguageHelper::getActiveLanguages();
        $productAttributes      = is_null(Cache::get('adminProductAttributes')) ? ProductAttribute::updateCache() : Cache::get('adminProductAttributes');
        $productAttributeValues = is_null(Cache::get('adminProductAttributeValues')) ? ProductAttributeValue::updateCache() : Cache::get('adminProductAttributeValues');
        $products               = Product::groupBy('product_category_id')->with('defaultTranslation')->with(['product_category' => function ($q) {
            $q->orderBy('position', 'asc');
        }])->get()->sortBy(['product_category', 'id']);
        $productCombinations    = is_null(Cache::get('adminProductCombinations')) ? ProductCombination::updateCache() : Cache::get('adminProductCombinations');
        $productCombinations    = $productCombinations->filter(function ($item) use ($mainProduct) {
            if ($item->product_id == $mainProduct->id) {
                return $item;
            }
        });

        return view('admin.product_combinations.index', compact('products', 'productCombinations', 'productAttributes', 'productAttributeValues', 'defaultLanguage', 'languages'));
    }

    public function generateSkuNumbersByProduct(Request $request): RedirectResponse
    {
        if (!$request->has('sku_product_id')) {
            return redirect()->back()->withErrors(['administration_messages.no_product_found']);
        }

        $product = Product::where('id', $request->sku_product_id)->with('combinations')->first();
        if (is_null($product)) {
            return redirect()->back()->withErrors(['administration_messages.no_product_found']);
        }

        if (is_null($product->combinations) || count($product->combinations) == 0) {
            return redirect()->back()->withErrors(['administration_messages.no_product_combinations']);
        }

        $int = 1;
        foreach ($product->combinations as $productCombo) {
            $productCombo->update(['sku' => $request->prefix . $int]);
            $int++;
        }

        return redirect()->back()->with('success-message', 'administration_messages.successful_edit');
    }
}
