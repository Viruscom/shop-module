<?php

namespace Modules\Shop\Http\Controllers\admin\RegisteredUsers;

use App\Helpers\WebsiteHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Modules\Shop\Entities\RegisteredUser\Firms\Company;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
use Modules\Shop\Http\Requests\Admin\RegisteredUser\Companies\AdminRegUserCompanyStoreRequest;

class ShopAdminRegisteredUserCompaniesController extends Controller
{
    public function store($id, AdminRegUserCompanyStoreRequest $request)
    {
        $registeredUser = ShopRegisteredUser::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        if ($request->has('is_default') && $request->is_default === true) {
            $registeredUser->companies()->update(['is_default', false]);
        }

        $registeredUser->companies()->create($request->all());

        return redirect()->route('admin.shop.registered-users.show', ['id' => $registeredUser->id])->with('success-message', 'admin.common.successful_create');
    }
    public function update($id, Request $request)
    {
        $company = Company::find($id);
        WebsiteHelper::redirectBackIfNull($company);

        $company->update($request->all());

        return back()->with('success-message', 'admin.common.successful_edit');
    }
    public function create($id)
    {
        $registeredUser = ShopRegisteredUser::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        return view('shop::admin.registered_users.firms.create', compact('registeredUser'));
    }
    public function setAsDefault($id, $company_id)
    {
        $company = Company::find($company_id);
        WebsiteHelper::redirectBackIfNull($company);

        $registeredUser = ShopRegisteredUser::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        $registeredUser->companies()->update(['is_default' => false]);
        $company->update(['is_default' => true]);

        return back()->with('success-message', 'admin.common.successful_edit');
    }
    public function delete($id)
    {
        $company = Company::find($id);
        WebsiteHelper::redirectBackIfNull($company);

        $company->delete();

        return back()->with('success-message', 'admin.common.successful_edit');
    }
}
