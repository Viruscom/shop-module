<?php

    namespace Modules\Shop\Http\Controllers\Front\RegisteredUser;

    use App\Helpers\WebsiteHelper;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Modules\Shop\Entities\Orders\Order;
    use Modules\Shop\Http\Requests\Front\RegisteredUser\PersonalDataUpdateRequest;
    use Modules\Shop\Models\Admin\Products\Product;

    class RegisteredUserAccountController extends Controller
    {
        public function dashboard()
        {
            $registeredUser = Auth::guard('shop')->user();

            return view('shop::front.registered_users.profile.dashboard', [
                'registeredUser'         => $registeredUser,
                'orders'                 => $registeredUser->orders()->limit(5)->get(),
                'defaultShipmentAddress' => $registeredUser->shipmentAddresses()->isDeleted(false)->isDefault(true)->first(),
                'defaultPaymentAddress'  => $registeredUser->paymentAddresses()->isDeleted(false)->isDefault(true)->first(),
            ]);
        }

        public function personalData()
        {
            return view('shop::front.registered_users.profile.personal_data', ['registeredUser' => Auth::guard('shop')->user()]);
        }

        public function update($languageSlug, $id, PersonalDataUpdateRequest $request)
        {
            if (Auth::guard('shop')->user()->id != decrypt($id)) {
                return back()->withErrors(['shop::front.registered_user_profile.user_not_the_same']);
            }
            Auth::guard('shop')->user()->update($request->all());

            return back()->withInput()->with('success-message', 'admin.common.successful_edit');
        }

        public function getFavoriteProducts()
        {
            $registeredUser = Auth::guard('shop')->user();

            return view('shop::front.registered_users.profile.favorite_products', ['registeredUser' => $registeredUser, 'favoriteProducts' => $registeredUser->favoriteProducts()->with('product', 'product.translations', 'product.measureUnit')->get()]);
        }
        public function favoriteProductStore($languageslug, $id, Request $request)
        {
            $product = Product::where('id', $id)->where('active', true)->first();
            WebsiteHelper::redirectBackIfNull($product);

            $registeredUser = Auth::guard('shop')->user();
            $registeredUser->favoriteProducts()->create(['user_id' => $registeredUser->id, 'product_id' => $product->id]);

            return redirect()->back()->with('success', trans('admin.common.successful_create'));
        }

        public function favoriteProductDelete($languageslug, $id, Request $request)
        {
            $product = Product::where('id', $id)->first();
            WebsiteHelper::redirectBackIfNull($product);

            $registeredUser = Auth::guard('shop')->user();
            $favProduct     = $registeredUser->favoriteProducts()->where('user_id', $registeredUser->id)->where('product_id', $product->id)->first();
            WebsiteHelper::redirectBackIfNull($favProduct);

            $favProduct->delete();

            return redirect()->back()->with('success', trans('admin.common.successful_delete'));
        }

        public function getOrders()
        {
            $registeredUser = Auth::guard('shop')->user()->with('orders');

            return view('shop::front.registered_users.profile.orders.index', compact('registeredUser'));
        }
        public function showOrderDetails($languageSlug, $order_hash)
        {
            $order = Order::where('id', decrypt($order_hash))->with('order_products', 'payment', 'delivery', 'documents', 'city', 'zip_code')->first();
            WebsiteHelper::redirectBackIfNull($order);

            return view('shop::front.registered_users.profile.orders.show', compact('order'));
        }
    }
