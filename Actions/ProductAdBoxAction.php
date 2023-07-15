<?php

namespace Modules\Shop\Actions;

use App\Helpers\CacheKeysHelper;
use Modules\Shop\Entities\AdBoxProduct\AdBoxProduct;

class ProductAdBoxAction
{
    public function deleteMultiple($request, $modelClass): void
    {
        $ids = array_map('intval', explode(',', $request->ids[0]));
        foreach ($ids as $id) {
            $model = $modelClass::find($id);
            if (is_null($model)) {
                continue;
            }

            $modelsToUpdate = $modelClass::where('type', $model->type)->where('position', '>', $model->position)->get();
            $model->delete();
            foreach ($modelsToUpdate as $modelToUpdate) {
                $modelToUpdate->update(['position' => $modelToUpdate->position - 1]);
            }
        }
    }
    public function delete($modelClass, $model): void
    {
        $modelsToUpdate = $modelClass::where('type', $model->type)->where('position', '>', $model->position)->get();
        $model->delete();
        foreach ($modelsToUpdate as $modelToUpdate) {
            $modelToUpdate->update(['position' => $modelToUpdate->position - 1]);
        }
    }
    public function checkForNullCache(): void
    {
        if (is_null(cache()->get(CacheKeysHelper::$AD_BOX_PRODUCT_WAITING_ADMIN)) || is_null(cache()->get(CacheKeysHelper::$AD_BOX_PRODUCT_TYPE_1_FRONT))) {
            AdBoxProduct::cacheUpdate();
        }
    }
}
