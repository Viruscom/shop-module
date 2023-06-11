<?php

namespace Modules\Shop\Http\Controllers\admin\RegisteredUsers;

use App\Helpers\WebsiteHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Shop\Entities\RegisteredUser\ShipmentAddresses\ShopShipmentAddress;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
use Modules\Shop\Http\Requests\Admin\RegisteredUser\Companies\AdminRegUserCompanyStoreRequest;

class ShopAdminRegisteredUserShipmentAddressController extends Controller
{
    public function store($id, AdminRegUserCompanyStoreRequest $request)
    {
        $registeredUser = ShopRegisteredUser::where('id', $id)->with('shipmentAddresses')->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        if ($request->has('is_default') && $request->is_default === true && $registeredUser->shipmentAddresses->isNotEmpty()) {
            $registeredUser->shipmentAddresses()->update(['is_default', false]);
        }

        if ($registeredUser->shipmentAddresses->isEmpty()) {
            $request['is_default'] = true;
        }

        $registeredUser->shipmentAddresses()->create($request->all());

        return redirect()->route('admin.shop.registered-users.show', ['id' => $registeredUser->id])->with('success-message', 'admin.common.successful_create');
    }
    public function update($id, $address_id, Request $request)
    {
        $registeredUser = ShopRegisteredUser::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        $company = ShopShipmentAddress::find($address_id);
        WebsiteHelper::redirectBackIfNull($company);

        $company->update($request->all());

        return redirect()->route('admin.shop.registered-users.show', ['id' => $registeredUser->id])->with('success-message', 'admin.common.successful_edit');
    }
    public function create($id)
    {
        $registeredUser = ShopRegisteredUser::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        return view('shop::admin.registered_users.shipment_addresses.create', compact('registeredUser'));
    }
    public function edit($id, $address_id)
    {
        $registeredUser = ShopRegisteredUser::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        $company = ShopShipmentAddress::find($address_id);
        WebsiteHelper::redirectBackIfNull($company);

        return view('shop::admin.registered_users.firms.edit', compact('registeredUser', 'company'));
    }
    public function setAsDefault($id, $address_id)
    {
        $company = ShopShipmentAddress::find($address_id);
        WebsiteHelper::redirectBackIfNull($company);

        $registeredUser = ShopRegisteredUser::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        $registeredUser->companies()->update(['is_default' => false]);
        $company->update(['is_default' => true]);

        return back()->with('success-message', 'admin.common.successful_edit');
    }
    public function delete($id, $address_id)
    {
        $registeredUser = ShopRegisteredUser::find($id);
        WebsiteHelper::redirectBackIfNull($registeredUser);

        $company = ShopShipmentAddress::find($address_id);
        WebsiteHelper::redirectBackIfNull($company);

        $nextDefaultCompany = $registeredUser->companies()->where('id', '!=', $company->id)->first();
        if ($company->isDefault(true) && !is_null($nextDefaultCompany)) {
            $nextDefaultCompany->update(['is_default' => true]);
        }

        $company->delete();

        return back()->with('success-message', 'admin.common.successful_edit');
    }
}
