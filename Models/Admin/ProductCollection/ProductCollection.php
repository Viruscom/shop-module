<?php

namespace Modules\Shop\Models\Admin\ProductCollection;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Shop\Models\Admin\Products\Product;

class ProductCollection extends Model
{
    protected $table    = "product_collections";
    protected $fillable = ['title', 'main_product_id', 'start_date', 'end_date', 'total', 'total_with_discounts', 'active'];
    public static function validateUniqueMainProduct($request, $updateCollectionId = null)
    {
        $collection = self::where('active', true)->where('main_product_id', $request->main_product_id)->first();
        if (!is_null($updateCollectionId)) {
            $collection = ProductCollection::where('active', true)->where('main_product_id', $request->main_product_id)->where('id', '!=', $updateCollectionId)->first();
        }

        return is_null($collection);
    }
    public static function getValidatedAdditionalProducts($request)
    {
        $errors       = [];
        $requestArray = $request->additionalProducts;
        foreach ($requestArray as $key => $array) {
            if ((!is_null($array['product_id']) && is_null($array['discount'])) || (is_null($array['product_id']) && !is_null($array['discount']))) {
                $errors['error'] = 'Проверете дали не сте изпуснали да изберете продукт или да въведете отстъпка.';
            }

            if (is_null($array['product_id']) && is_null($array['discount'])) {
                $toDelete[] = $key;
            }
        }

        foreach ($toDelete as $value) {
            unset($requestArray[$value]);
        }

        if (count($errors)) {
            return $errors;
        }

        return $requestArray;
    }
    public static function validateDiscounts($validatedProducts)
    {
        foreach ($validatedProducts as $productArray) {
            $product = Product::where('id', $productArray['product_id'])->first();
            $result  = $product->price - $productArray['discount'];
            if ($result <= 0) {
                return false;
            }
        }

        return true;
    }
    public static function store($request, $validatedProducts)
    {
        $data = $request->except('additionalProducts');
        if ($request->has('active')) {
            $data['active'] = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
        }
        $collection         = ProductCollection::create($data);
        $total              = 0;
        $totalWithDiscounts = 0;
        foreach ($validatedProducts as $productArray) {
            $product                         = Product::where('id', $productArray['product_id'])->first();
            $newArr['main_product_id']       = $collection->main_product_id;
            $newArr['price']                 = $product->price;
            $newArr['additional_product_id'] = $product->id;
            $newArr['discount']              = $productArray['discount'];
            $newArr['price_with_discount']   = $product->price - $productArray['discount'];

            $total              += $product->price;
            $totalWithDiscounts += $newArr['price_with_discount'];

            $collection->products()->create($newArr);
        }
        $collection->update(['total' => $total, 'total_with_discounts' => $totalWithDiscounts]);

        return true;
    }
    public function products(): HasMany
    {
        return $this->hasMany(ProductCollectionPivot::class, 'collection_id', 'id');
    }
    public function scopeActive($query, $active)
    {
        return $query->where('active', $active);
    }
    public function scopeMainProductId($query, $mainProductId)
    {
        return $query->where('main_product_id', $mainProductId);
    }
    public function status()
    {
        return $this->active;
    }
    public function updateAvtive($status)
    {
        if (!in_array($status, [0, 1])) {
            return redirect()->back()->withInput()->withErrors(['administration_messages.active_status_not_in_range']);
        }

        $this->update(['active' => $status]);

        return redirect('admin/shop/collections')->with('success-message', 'administration_messages.successful_edit');
    }
    public function mainProduct(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'main_product_id');
    }
    public function getUpdateData($request, $validatedProducts)
    {
        $data                       = $request->except('additionalProducts');
        $data['total']              = 0;
        $data['totalWithDiscounts'] = 0;

        $data['active'] = false;
        if ($request->has('active')) {
            $data['active'] = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
        }
        $this->products()->delete();
        foreach ($validatedProducts as $productArray) {
            $product                         = Product::where('id', $productArray['product_id'])->first();
            $newArr['main_product_id']       = $this->main_product_id;
            $newArr['price']                 = $product->price;
            $newArr['additional_product_id'] = $product->id;
            $newArr['discount']              = $productArray['discount'];
            $newArr['price_with_discount']   = $product->price - $productArray['discount'];

            $data['total']              += $product->price;
            $data['totalWithDiscounts'] += $newArr['price_with_discount'];

            $this->products()->create($newArr);
        }
        $this->update($data);
    }
}
