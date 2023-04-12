<?php

namespace Modules\Shop\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Modules\Shop\Entities\ShopRegisteredUser;

class ShopAdminRegisteredUsersController extends Controller
{
    public function index()
    {
        return view('shop::admin.registered_users.index', ['registeredUsers' => ShopRegisteredUser::all()]);
    }
}
