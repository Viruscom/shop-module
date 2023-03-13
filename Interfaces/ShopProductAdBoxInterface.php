<?php

namespace Modules\Shop\Interfaces;

use Modules\Shop\Actions\ProductAdBoxAction;

interface ShopProductAdBoxInterface
{
    public function index(ProductAdBoxAction $action);
    public function active($id, $active);
    public function delete($id, ProductAdBoxAction $action);

    public function activateAdBox($id);
}
