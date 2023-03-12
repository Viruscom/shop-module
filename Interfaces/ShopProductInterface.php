<?php

namespace Modules\Shop\Interfaces;

use App\Actions\CommonControllerAction;
use Modules\Shop\Actions\ProductAction;
use Modules\Shop\Http\Requests\ProductStoreRequest;
use Modules\Shop\Http\Requests\ProductUpdateRequest;

interface ShopProductInterface
{
    public function index();
    public function create(ProductAction $action);
    public function store(ProductStoreRequest $request, CommonControllerAction $action);
    public function edit($id, ProductAction $action);
    public function update($id, ProductUpdateRequest $request, CommonControllerAction $action);
    public function active($id, $active);
    public function delete($id, CommonControllerAction $action);
    public function deleteImage($id, CommonControllerAction $action);
}
