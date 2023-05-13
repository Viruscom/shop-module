<?php

namespace Modules\Shop\Http\Controllers\admin\RegisteredUsers;

use App\Helpers\WebsiteHelper;
use App\Http\Controllers\Controller;
use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;

class ShopAdminRegisteredUsersController extends Controller
{
    public function index()
    {
        return view('shop::admin.registered_users.index', ['registeredUsers' => ShopRegisteredUser::all()]);
    }

    public function show($id)
    {
        $registeredUser = ShopRegisteredUser::where('id', $id)->first();
        WebsiteHelper::redirectBackIfNull($registeredUser);

        return view('shop::admin.registered_users.show', ['registeredUser' => $registeredUser]);
    }
}
