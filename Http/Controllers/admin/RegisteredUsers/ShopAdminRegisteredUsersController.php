<?php

namespace Modules\Shop\Http\Controllers\admin\RegisteredUsers;

use App\Actions\CommonControllerAction;
use App\Helpers\LanguageHelper;
use App\Helpers\MainHelper;
use App\Helpers\WebsiteHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\ClientRequest;
use App\Models\CategoryPage\CategoryPage;
use App\Models\Shop_Models\Clients\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
use Modules\Shop\Http\Requests\AdminRegisteredUserStoreRequest;

class ShopAdminRegisteredUsersController extends Controller
{
    public function index()
    {
        return view('shop::admin.registered_users.index', ['registeredUsers' => ShopRegisteredUser::with('orders')->get()]);
    }

    public function create()
    {
        return view('shop::admin.registered_users.create');
    }
    public function store(AdminRegisteredUserStoreRequest $request)
    {
        $data             = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['active']   = false;
        if ($request->has('active')) {
            $data['active'] = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
        }
        ShopRegisteredUser::create($data);

        return redirect()->route('admin.shop.registered-users.index')->with('success-message', 'admin.common.successful_create');
    }

    public function edit($id)
    {
        $registeredUser = ShopRegisteredUser::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        return view('shop::admin.registered_users.edit', ['registeredUser' => $registeredUser]);
    }

    public function update($id, ClientRequest $request)
    {
        $client = Client::find($id);
        \App\Classes\WebsiteHelper::redirectBackIfNull($client);
        $client->update($client->getUpdateData($request));

        return redirect('admin/shop/clients')->with('success-message', 'Успешно редактиране');
    }

    public function show($id)
    {
        $registeredUser = ShopRegisteredUser::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        return view('shop::admin.registered_users.show', ['registeredUser' => $registeredUser]);
    }

    public function activeMultiple($active, Request $request, CommonControllerAction $action): RedirectResponse
    {
        $action->activeMultiple(ShopRegisteredUser::class, $request, $active);

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
    public function active($id, $active): RedirectResponse
    {
        $registeredUser = ShopRegisteredUser::find($id);
        MainHelper::goBackIfNull($registeredUser);

        $registeredUser->update(['active' => $active]);

        return redirect()->back()->with('success-message', 'admin.common.successful_edit');
    }
}
