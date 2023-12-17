<?php

    namespace Modules\Shop\Http\Controllers\Front\RegisteredUser;

    use App\Helpers\LanguageHelper;
    use App\Helpers\SeoHelper;
    use App\Helpers\WebsiteHelper;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Modules\Shop\Entities\RegisteredUser\ShipmentAddresses\ShopShipmentAddress;
    use Modules\Shop\Entities\Settings\Main\CountrySale;
    use Modules\Shop\Http\Requests\Front\RegisteredUser\ShipmentAddressStoreRequest;
    use Modules\Shop\Http\Requests\Front\RegisteredUser\ShipmentAddressUpdateRequest;

    class ShipmentAddressesController extends Controller
    {
        public function index()
        {
            $currentLanguage = LanguageHelper::getCurrentLanguage();
            SeoHelper::setTitle('Адреси | ' . $currentLanguage->seo_title);

            $registeredUser = Auth::guard('shop')->user();

            return view('shop::front.registered_users.profile.addresses.shipment.index', [
                'registeredUser' => $registeredUser,
                'defaultAddress' => $registeredUser->shipmentAddresses()->isDefault(true)->isDeleted(false)->first(),
                'otherAddresses' => $registeredUser->shipmentAddresses()->isDefault(false)->isDeleted(false)->get(),
            ]);
        }
        public function store($languageSlug, ShipmentAddressStoreRequest $request)
        {
            $registeredUser = Auth::guard('shop')->user();
            WebsiteHelper::redirectBackIfNull($registeredUser);

            if ($request->has('is_default') && $request->is_default === 1 && $registeredUser->shipmentAddresses->isNotEmpty()) {
                $registeredUser->shipmentAddresses()->update(['is_default' => false]);
            }

            if ($registeredUser->shipmentAddresses->isEmpty()) {
                $request['is_default'] = true;
            }

            $registeredUser->shipmentAddresses()->create($request->all());

            return redirect()->route('shop.registered_user.account.addresses', ['languageSlug' => $languageSlug, 'id' => $registeredUser->id])->with('success-message', 'admin.common.successful_create');
        }
        public function update($id, $address_id, ShipmentAddressUpdateRequest $request)
        {
            $registeredUser = Auth::guard('shop')->user();
            WebsiteHelper::redirectBackIfNull($registeredUser);

            $address = ShopShipmentAddress::find($address_id);
            WebsiteHelper::redirectBackIfNull($address);

            if ($request->has('is_default') && $registeredUser->shipmentAddresses->isNotEmpty()) {
                $registeredUser->shipmentAddresses()->update(['is_default' => false]);
                $address->update(['is_default' => true]);
            }

            $address->update($request->except(['is_default']));

            return redirect()->route('shop.registered_user.account.addresses', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code])->with('success', trans('admin.common.successful_edit'));
        }
        public function create($id)
        {
            $registeredUser = Auth::guard('shop')->user();
            WebsiteHelper::redirectBackIfNull($registeredUser);

            $saleCountries = CountrySale::with('country')->get();

            return view('shop::front.registered_users.profile.addresses.shipment.create', compact('registeredUser', 'saleCountries'));
        }
        public function edit($languageSlug, $id)
        {
            $registeredUser = Auth::guard('shop')->user();
            WebsiteHelper::redirectBackIfNull($registeredUser);

            $address = ShopShipmentAddress::find($id);
            if (is_null($address)) {
                return redirect()->back()->withInput()->withErrors(['admin.common.record_not_found']);
            }

            $saleCountries = CountrySale::with('country')->get();

            return view('shop::front.registered_users.profile.addresses.shipment.edit', compact('registeredUser', 'address', 'saleCountries'));
        }
        public function setAsDefault($languageSlug, $id)
        {
            $registeredUser = Auth::guard('shop')->user();
            if (is_null($registeredUser)) {
                return response()->json(['error' => 'Нещо се обърка, моля опитайте отново!']);
            }

            $address = ShopShipmentAddress::find($id);
            if (is_null($address)) {
                return response()->json(['error' => 'Адресът не е намерен, моля опитайте отново!']);
            }

            $registeredUser->shipmentAddresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);

            return back()->with('success-message', 'admin.common.successful_edit');
        }
        public function delete($languageSlug, $id)
        {
            $registeredUser = Auth::guard('shop')->user();
            WebsiteHelper::redirectBackIfNull($registeredUser);

            $address = ShopShipmentAddress::find($id);
            if (is_null($address)) {
                return redirect()->back()->withInput()->withErrors(['admin.common.record_not_found']);
            }

            $nextDefaultAddress = $registeredUser->shipmentAddresses()->where('id', '!=', $address->id)->first();
            if ($address->isDefault(true) && !is_null($nextDefaultAddress)) {
                $nextDefaultAddress->update(['is_default' => true]);
            }

            $address->delete();

            return back()->with('success-message', 'admin.common.successful_edit');
        }
    }
