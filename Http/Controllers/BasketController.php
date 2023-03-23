<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Modules\Shop\Entities\Basket;
use Modules\Shop\Entities\City;
use Modules\Shop\Entities\Country;
use Modules\Shop\Entities\Delivery;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\Payment;
use Modules\Shop\Http\Requests\OrderRequest;
use Modules\Shop\Models\Admin\Products\Product;

class BasketController extends Controller
{
    public static function storeOrder(OrderRequest $request)
    {
        $basket = Basket::getCurrent();
        if ($basket->basket_products->count() < 1) {
            return redirect(route('basket.index'))->withError(__('First add products to basket.'));
        }

        $basketProducts = $basket->basket_products;
        $country        = Country::find($request->country_id);
        $city           = City::find($request->city_id);
        $basket->calculate($basketProducts, $country, $city);
        if ($basket->total != $request->total || $basket->total_discounted != $request->total_discounted || $basket->total_free_delivery != $request->total_free_delivery) {
            return redirect(route('basket.index'))->withError(__('There are changes.'));
        }

        //check quantities

        $request['discounts_to_apply'] = json_encode($basket->discounts_to_apply);
        $request['key']                = $basket->key;
        $request['user_id']            = $basket->user_id;
        $request['uid']                = uniqid(uniqid(uniqid(uniqid('', true) . "-", true) . "-", true) . "-", true);
        $request['paid_at']            = null;
        $request['delivered_at']       = null;

        $order                         = Order::create($request->all());
        foreach ($basket->calculated_basket_products as $basketProduct) {
            $order->order_products()->create([
                                                 'product_id'                   => $basketProduct->product_id,
                                                 'product_quantity'             => $basketProduct->product_quantity,
                                                 'supplier_delivery_price'      => $basketProduct->product->supplier_delivery_price,
                                                 'price'                        => $basketProduct->product->price,
                                                 'discounts_amount'             => $basketProduct->discounts_amount,
                                                 'vat'                          => $basketProduct->vat,
                                                 'vat_applied_price'            => $basketProduct->vat_applied_price,
                                                 'end_price'                    => $basketProduct->end_price,
                                                 'free_delivery'                => $basketProduct->free_delivery ? 1 : 0,
                                                 'vat_applied_discounted_price' => $basketProduct->vat_applied_discounted_price,
                                                 'end_discounted_price'         => $basketProduct->end_discounted_price
                                             ]);
        }

        //decrement quantities
        //delete current basket
        $basket->delete();
        //send mail for order created
        //execute payment method
        $payment = Payment::find($request->payment_id);
        if (!empty($payment->class) && !empty($payment->method)) {
            return call_user_func_array(array($payment->class, $payment->method), array($order));
        }

        return redirect(route('shop::basket.order.preview', ['id' => $order->id]))->with('success', __('Successful update'));
    }
    public function previewOrder($id)
    {
        $order = Order::where('id', $id)->where(function ($q) {
            if (Auth::check()) {
                return $q->where('user_id', Auth::guard('shop')->user()->id);
            } else {
                return $q->where('key', $_COOKIE['sbuuid']);
            }
        })->get()->first();

        if (is_null($order)) {
            abort(404);
        }

        return view('shop::basket.order.preview', ['order' => $order]);
    }
    public function createOrder()
    {
        //get current coutry and city once chosen
        $country = Country::find(session()->get('country_id'));
        $city    = City::find(session()->get('city_id'));

        $basket = Basket::getCurrent();
        if ($basket->basket_products->count() < 1) {
            return redirect(route('basket.index'))->withError(__('First add products to basket.'));
        }
        $basket->calculate($basket->basket_products, $country, $city);
        $countries = Country::limit(50)->get();
        $cities    = City::limit(50)->get();

        $paymentMethods  = Payment::orderBy('position', 'asc')->get();
        $deliveryMethods = Delivery::orderBy('position', 'asc')->get();

        return view('shop::basket.order.create', ['basket' => $basket, 'countries' => $countries, 'cities' => $cities, 'paymentMethods' => $paymentMethods, 'deliveryMethods' => $deliveryMethods]);
    }
    public function index()
    {
        //get countries and cities for selects
        $countries = Country::limit(50)->get();
        $cities    = City::limit(50)->get();

        //get current coutry and city once chosen
        $country = Country::find(session()->get('country_id'));
        $city    = City::find(session()->get('city_id'));

        $basket = Basket::getCurrent();
        $basket->calculate($basket->basket_products, $country, $city);

        return view('shop::basket.index', ['basket' => $basket, 'countries' => $countries, 'cities' => $cities]);
    }

    public function addProduct(Request $request)//can be used for add,increment,decrement,delete
    {
        if (!isset($request->product_id)) {
            return redirect()->back();//no message need no regular user should evere be here!
        }

        $product = Product::findOrFail($request->product_id);

        $basket = Basket::getCurrent();
        if (!isset($request->product_quantity)) {// when we want to increment with 1, product_quantity showld not be present in the request
            $request['product_quantity'] = 1;
        }

        //delete case
        if ($request->product_quantity == 0) {
            $basket->basket_products()->where('product_id', $product->id)->delete();

            return redirect()->back();
        }

        //decrement case
        if ($request->product_quantity == -1) {
            $basketProduct = $basket->basket_products()->where('product_id', $product->id)->first();
            if (is_null($basketProduct)) {
                return redirect()->back();// we do not have what to decrement
            }

            if ($basketProduct->product_quantity == 1) {
                $basket->basket_products()->where('product_id', $product->id)->delete();
            } else {
                $basketProduct->decrement('product_quantity', 1);
            }

            return redirect()->back();
        }

        //create/increment case
        $basketProduct = $basket->basket_products()->where('product_id', $product->id)->first();
        if (is_null($basketProduct)) {
            $basket->basket_products()->create(['product_id' => $product->id, 'product_quantity' => $request->product_quantity]);
        } else {
            $basketProduct->increment('product_quantity', $request->product_quantity);
        }

        return redirect()->route('basket.index');
    }
}
