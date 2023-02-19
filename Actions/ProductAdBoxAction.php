<?php

namespace Modules\Shop\Actions;

class ProductAdBoxAction
{
    public function deleteMultiple($request, $modelClass)
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
}
