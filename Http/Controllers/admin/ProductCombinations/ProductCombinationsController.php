<?php

namespace Modules\Shop\Http\Controllers\admin\ProductCombinations;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Shop\Models\Admin\ProductAttribute\ProductAttribute;
use Modules\Shop\Models\Admin\ProductAttribute\ProductAttributePivot;
use Modules\Shop\Models\Admin\ProductAttribute\Values\ProductAttributeValue;
// use Modules\Shop\Models\Admin\ProductCombination\ProductCombination;
use Modules\Shop\Models\Admin\Products\Product;
use Carbon\Carbon;

class ProductCombinationsController extends Controller
{
    public function index()
    {
        return view('shop::admin.product_combinations.index', [
            'products'               => Product::with('translations')->with(['category' => function ($q) {
                $q->orderBy('position', 'asc');
            }])->whereDoesntHave('mainProduct')->get()->sortBy(['category', 'id']),
            'productCombinations'    => Product::whereHas('mainProduct')->get(),
            'productAttributes'      => ProductAttribute::with('translations', 'values', 'values.translations')->orderBy('position')->get(),
            'productAttributeValues' => ProductAttributeValue::with('translations')->get(),
            'languages'              => LanguageHelper::getActiveLanguages()
        ]); 
    }
    public function updateMultiple(Request $request)
    {
        if (is_array($request->combos)) {
            foreach ($request->combos as $key => $combo) {
                $productCombination = Product::where('id',$combo['comboId'])->whereHas('mainProduct')->first();
                if (!is_null($productCombination)) {
                    $price = str_replace(',', '.', $combo['price']);
                    $productCombination->update([
                        'price' => number_format((float)$price, 2, '.', ''),
                        'sku'   => $combo['sku'],
                    ]);
                }
            }

            return 'Успешно обновяване!';
        }

        return 'Няма маркирани редове за обновяване!';
    }
    public function update($id, Request $request): RedirectResponse
    {
        $productCombination = Product::where('id',$id)->whereHas('mainProduct')->first();
        if (is_null($productCombination)) {
            return redirect()->back()->withErrors(['administration_messages.no_product_combination_found']);
        }
        $price = str_replace(',', '.', $request->price);
        $productCombination->update([
            'price' => number_format((float)$price, 2, '.', ''),
            'sku'   => $request->sku,
        ]);

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function deleteMultiple(Request $request): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $ids = array_map('intval', explode(',', $request->ids[0]));
            foreach ($ids as $id) {
                $productCombination = Product::where('id', $id)->whereHas('mainProduct')->first();
                $mainProductId = $productCombination->main_product_id;
                $deletedPosition = $productCombination->position;
                if (!is_null($productCombination)) {
                    $productCombination->delete();
                }

                $combinations = Product::find($mainProductId)->combinations()->where('position', '>', $deletedPosition)->get();
                foreach ($combinations as $combination) {
                    $combination->update(['position' => $combination->position - 1]);
                }
            }

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['administration_messages.no_checked_checkboxes']);
    }
    public function delete($id): RedirectResponse
    {   
        $productCombination = Product::where('id', $id)->whereHas('mainProduct')->first();
        if (is_null($productCombination)) {
            return redirect()->back()->withErrors(['administration_messages.no_product_combination_found']);
        }
        $mainProductId = $productCombination->main_product_id;
        $deletedPosition = $productCombination->position;

        $productCombination->delete();
        $combinations = Product::find($mainProductId)->combinations()->where('position', '>', $deletedPosition)->get();
        foreach ($combinations as $combination) {
            $combination->update(['position' => $combination->position - 1]);
        }

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function getAttributesByProductCategory(Request $request)
    {
        $product = Product::where('id', $request->product_id)->with('category')->first();

        if (is_null($product)) {
            return 'error404';
        }

        $attributesInCategory = ProductAttributePivot::select('pattr_id')->where('product_category_id', $product->category->id)->get();

        if (is_null($attributesInCategory)) {
            return 'error404category';
        }

        return $attributesInCategory;
    }

    public function getProductSkuNumber(Request $request)
    {
        $productSkuNumber = Product::select('sku')->where('id', $request->product_id)->first();
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
            foreach ($combinations as $combination) {
                $productCombination = Product::createCombination($request, $mainProduct, $combination);
            }

            return redirect()->back()->with('success-message', 'admin.common.successful_create');
        }

        return redirect()->back()->withErrors(['administration_messages.no_product_attribute_values_checked']);
    }

    public function combinationsByProductId($id)
    {
        $mainProduct = Product::find($id);
        if (is_null($mainProduct)) {
            return redirect()->back()->withErrors(['administration_messages.no_product_found']);
        }

        return view('shop::admin.product_combinations.index', [
            'products'               => Product::with('translations')->with(['category' => function ($q) {
                $q->orderBy('position', 'asc');
            }])->whereDoesntHave('mainProduct')->get()->sortBy(['category', 'id']),
            'productCombinations'    => $mainProduct->combinations,
            'productAttributes'      => ProductAttribute::with('translations', 'values', 'values.translations')->orderBy('position')->get(),
            'productAttributeValues' => ProductAttributeValue::with('translations')->get(),
            'languages'              => LanguageHelper::getActiveLanguages()
        ]);
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

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
}
