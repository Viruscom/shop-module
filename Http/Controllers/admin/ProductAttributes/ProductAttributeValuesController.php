<?php

namespace Modules\Shop\Http\Controllers\admin\ProductAttributes;

use App\Actions\CommonControllerAction;
use App\Helpers\LanguageHelper;
use App\Helpers\MainHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Shop\Http\Requests\ProductCategoryStoreRequest;
use Modules\Shop\Http\Requests\ProductCategoryUpdateRequest;
use Modules\Shop\Models\Admin\ProductAttribute\ProductAttribute;
use Modules\Shop\Models\Admin\ProductAttribute\Values\ProductAttributeValue;
use Modules\Shop\Models\Admin\ProductCategory\Category;
use Modules\Shop\Models\Admin\ProductCategory\CategoryTranslation;

class ProductAttributeValuesController extends Controller
{
    public function index($id)
    {
        $productAttribute = ProductAttribute::where('id', $id)->with('values')->first();
        MainHelper::goBackIfNull($productAttribute);

        return view('shop::admin.product_attributes.values.index', ['productAttribute' => $productAttribute]);
    }
    public function store($id, ProductCategoryStoreRequest $request, CommonControllerAction $action): RedirectResponse
    {
        $productAttribute = ProductAttribute::where('id', $id)->first();
        MainHelper::goBackIfNull($productAttribute);

        $request['product_attr_id'] = $productAttribute->id;
        $value                      = $action->doSimpleCreate(ProductAttributeValue::class, $request);
        $value->storeAndAddNew($request);

        return redirect()->route('admin.product-attribute.values.index', ['id' => $productAttribute->id])->with('success-message', trans('admin.common.successful_create'));
    }
    public function create($id)
    {
        $productAttribute = ProductAttribute::where('id', $id)->with('values')->first();
        MainHelper::goBackIfNull($productAttribute);

        return view('shop::admin.product_attributes.values.create', [
            'productAttribute' => $productAttribute,
            'languages'        => LanguageHelper::getActiveLanguages()
        ]);
    }
    public function edit($id, $value_id)
    {
        $productAttribute = ProductAttribute::where('id', $id)->first();
        MainHelper::goBackIfNull($productAttribute);

        $ProductAttributeValue = ProductAttributeValue::find($value_id);
        MainHelper::goBackIfNull($ProductAttributeValue);

        return view('shop::admin.product_attributes.values.edit', [
            'productAttribute' => $productAttribute,
            'languages'        => LanguageHelper::getActiveLanguages()
        ]);
    }
    public function deleteMultiple(Request $request, CommonControllerAction $action): RedirectResponse
    {
        if (!is_null($request->ids[0])) {
            $ids = array_map('intval', explode(',', $request->ids[0]));
            foreach ($ids as $id) {
                $ProductAttributeValue = ProductAttributeValue::find($id);
                if (is_null($ProductAttributeValue)) {
                    continue;
                }

                $valuesToUpdate = ProductAttributeValue::where('product_attr_id', $ProductAttributeValue->parent->id)->where('position', '>', $ProductAttributeValue->position)->get();
                //TODO: Delete all product combinations with that attribute value
                if ($ProductAttributeValue->existsFile($ProductAttributeValue->filename)) {
                    $ProductAttributeValue->deleteFile($ProductAttributeValue->filename);
                }
                $ProductAttributeValue->delete();
                foreach ($valuesToUpdate as $ProductAttributeValueToUpdate) {
                    $ProductAttributeValueToUpdate->update(['position' => $ProductAttributeValueToUpdate->position - 1]);
                }
            }

            return redirect()->back()->with('success-message', 'admin.common.successful_delete');
        }

        return redirect()->back()->withErrors(['admin.common.no_checked_checkboxes']);
    }
    public function delete($id, $value_id, CommonControllerAction $action): RedirectResponse
    {
        $productAttribute = ProductAttribute::find($id);
        MainHelper::goBackIfNull($productAttribute);

        $ProductAttributeValue = ProductAttributeValue::find($value_id);
        MainHelper::goBackIfNull($ProductAttributeValue);

        $valuesToUpdate = ProductAttributeValue::where('product_attr_id', $productAttribute->id)->where('position', '>', $ProductAttributeValue->position)->get();
        //TODO: Delete all product combinations with that attribute value
        if ($ProductAttributeValue->existsFile($ProductAttributeValue->filename)) {
            $ProductAttributeValue->deleteFile($ProductAttributeValue->filename);
        }
        $ProductAttributeValue->delete();
        foreach ($valuesToUpdate as $ProductAttributeValueToUpdate) {
            $ProductAttributeValueToUpdate->update(['position' => $ProductAttributeValueToUpdate->position - 1]);
        }

        return redirect()->back()->with('success-message', 'admin.common.successful_delete');
    }
    public function update($id, ProductCategoryUpdateRequest $request, CommonControllerAction $action): RedirectResponse
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

    public function positionUp($id, $value_id): RedirectResponse
    {
        $productAttribute = ProductAttribute::find($id);
        MainHelper::goBackIfNull($productAttribute);

        $ProductAttributeValue = ProductAttributeValue::find($value_id);
        MainHelper::goBackIfNull($ProductAttributeValue);

        $nextValue = ProductAttributeValue::where('product_attr_id', $productAttribute->id)->where('position', $ProductAttributeValue->position - 1)->first();
        if (!is_null($nextValue)) {
            $nextValue->update(['position' => $nextValue->position + 1]);
            $ProductAttributeValue->update(['position' => $ProductAttributeValue->position - 1]);
        }

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }

    public function positionDown($id, $value_id): RedirectResponse
    {
        $productAttribute = ProductAttribute::find($id);
        MainHelper::goBackIfNull($productAttribute);

        $ProductAttributeValue = ProductAttributeValue::find($value_id);
        MainHelper::goBackIfNull($ProductAttributeValue);

        $nextValue = ProductAttributeValue::where('product_attr_id', $productAttribute->id)->where('position', $ProductAttributeValue->position + 1)->first();
        if (!is_null($nextValue)) {
            $nextValue->update(['position' => $nextValue->position - 1]);
            $ProductAttributeValue->update(['position' => $ProductAttributeValue->position + 1]);
        }

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
