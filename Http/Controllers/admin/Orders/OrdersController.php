<?php

namespace Modules\Shop\Http\Controllers\admin\Orders;

use App\Helpers\WebsiteHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Shop\Entities\Orders\Order;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
use Modules\Shop\Entities\Settings\Main\CountrySale;
use Modules\Shop\Models\Admin\Products\Product;

class OrdersController extends Controller
{
    public function index()
    {
        return view('shop::admin.orders.index', [
            'orders' => Order::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('shop::admin.orders.create', [
            'orderNumber'   => Order::max('id') + 1,
            'products'      => Product::with('translations', 'combinations')->get(),
            'clients'       => ShopRegisteredUser::where('active', true)->with('paymentAddresses', 'shipmentAddresses', 'companies')->get(),
            'saleCountries' => CountrySale::with('country', 'country.cities')->get()
        ]);
    }

    public function store($request)
    {
        $orderNumber = Order::max('id') + 1;
    }
    public function show($id)
    {
        $order = Order::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($order);

        return view('shop::admin.orders.show', compact('order'));
    }

    public function getProductByIdForOrder(Request $request)
    {
        $clientLevel = null;

        if ($request->has('client_id')) {
            $client      = ShopRegisteredUser::where('id', $request->client_id)->first();
            $clientLevel = is_null($client) ? 1 : $client->client_group_id;
        }

        if ($request->isProductCollection !== 'false') {
            //Get product collection here
            $collection = '66666666';

            return '999999';
        }

        $product = Product::where('id', $request->productID)->active(true)->isInStock()->with('translations')->first();
        if (is_null($product)) {
            return 'error';
        }

        return [
            'product'            => $product->toJson(),
            'productQuantity'    => $request->productQuantity,
            'productTranslation' => $product,
            'image'              => $product->getFileUrl(),
            'discounts'          => 0, //TODO: $product->getCalculatedDiscounts(),
            'priceWithDiscounts' => 0, //TODO: $product->getPriceWithDiscounts($clientLevel)
        ];
    }
}
