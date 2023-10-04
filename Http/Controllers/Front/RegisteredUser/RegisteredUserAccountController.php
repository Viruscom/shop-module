<?php

    namespace Modules\Shop\Http\Controllers\Front\RegisteredUser;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Modules\Shop\Http\Requests\Front\RegisteredUser\PersonalDataUpdateRequest;

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
            if (Auth::guard('shop')->user()->id != $id) {
                return back()->withErrors(['shop::front.registered_user_profile.user_not_the_same']);
            }
            Auth::guard('shop')->user()->update($request->all());

            return back()->withInput()->with('success-message', 'admin.common.successful_edit');
        }

        public function getFavoriteProducts()
        {
            $registeredUser = Auth::guard('shop')->user();

            return view('shop::front.registered_users.profile.favorite_products', ['registeredUser' => $registeredUser, 'favoriteProducts' => $registeredUser->favoriteProducts()->get()]);
        }
        public function favoriteProductStore()
        {
            return Auth::guard('shop')->user()->favoriteProducts()->get();
        }
        public function favoriteProductDelete()
        {
            return view('shop::front.registered_users.profile.dashboard', ['registeredUser' => Auth::guard('shop')->user()]);

            return Auth::guard('shop')->user()->favoriteProducts()->get();
        }
    }
