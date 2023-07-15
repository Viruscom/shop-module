<?php

namespace Modules\Shop\Interfaces;

use Illuminate\Http\Request;
use Modules\Shop\Actions\ProductAdBoxAction;

interface ShopProductAdBoxInterface
{
    public function index(ProductAdBoxAction $action);
    public function edit($id);
    public function update($id, ProductAdBoxAction $action, Request $request);
    public function active($id, $active);
    public function delete($id, ProductAdBoxAction $action);
}
