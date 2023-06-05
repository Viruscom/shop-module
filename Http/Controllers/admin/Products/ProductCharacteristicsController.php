<?php

namespace Modules\Shop\Http\Controllers\admin\Products;

use App\Actions\CommonControllerAction;
use App\Helpers\CacheKeysHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\MainHelper;
use App\Helpers\ModuleHelper;
use App\Helpers\WebsiteHelper;
use App\Http\Controllers\Controller;
use App\Interfaces\PositionInterface;
use App\Models\Files\File;
use App\Models\Language;
use Cache;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Shop\Actions\ProductAction;
use Modules\Shop\Http\Requests\ProductStoreRequest;
use Modules\Shop\Http\Requests\ProductUpdateRequest;
use Modules\Shop\Interfaces\ShopProductInterface;
use Modules\Shop\Models\Admin\ProductCategory\Category;
use Modules\Shop\Models\Admin\Products\Product;
use Modules\Shop\Models\Admin\Products\ProductCharacteristic;
use Modules\Shop\Models\Admin\Products\ProductCharacteristicPivot;
use Modules\Shop\Models\Admin\Products\ProductCharacteristicValue;
use Modules\Shop\Models\Admin\Products\ProductTranslation;

class ProductCharacteristicsController extends Controller implements PositionInterface
{
    public function index()
    {
        if (is_null(Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CHARACTERISTICS))) {
            ProductCharacteristic::cacheUpdate();
        }

        return view('shop::admin.products.characteristics.index', ['characteristics' => Cache::get(CacheKeysHelper::$SHOP_PRODUCT_CHARACTERISTICS)]);
    }


    public function positionUp($id, CommonControllerAction $action)
    {
        // TODO: Implement positionUp() method.
    }
    public function positionDown($id, CommonControllerAction $action)
    {
        // TODO: Implement positionDown() method.
    }

    public function characteristicsByProductId($id)
    {
        $mainProduct = Product::find($id);
        WebsiteHelper::redirectBackIfNull($mainProduct);

        $characteristics = ProductCharacteristicPivot::where('product_category_id', $mainProduct->product_category_id)
            ->with('characteristic', 'characteristic.defaultTranslation')
            ->get();
        $characteristics->map(function ($item) use ($mainProduct) {
            $item['value'] = ProductCharacteristicValue::select('value')->where('product_id', $mainProduct->id)->where('characteristic_id', $item->product_characteristic_id)->first();

            return $item;
        });

        return view('shop::admin.products.characteristics.editPerProduct', compact('characteristics', 'mainProduct'));
    }

    public function characteristicsByProductIdUpdate($id, Request $request)
    {
        $mainProduct = Product::find($id);
        WebsiteHelper::redirectBackIfNull($mainProduct);

        foreach ($request->characteristicValue as $characteristicId => $value) {
            ProductCharacteristicValue::updateOrCreate(
                ['product_id' => $mainProduct->id, 'characteristic_id' => $characteristicId],
                ['value' => $value]
            );
        }
        $characteristics = ProductCharacteristicPivot::where('product_category_id', $mainProduct->product_category_id)
            ->with('characteristic', 'characteristic.defaultTranslation')
            ->get();
        $characteristics->map(function ($item) use ($mainProduct) {
            $item['value'] = ProductCharacteristicValue::select('value')->where('product_id', $mainProduct->id)->where('characteristic_id', $item->product_characteristic_id)->first();

            return $item;
        });

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
}
