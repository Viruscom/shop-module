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
use Modules\Shop\Http\Requests\Admin\RegisteredUser\AdminRegisteredUserUpdateRequest;
use Modules\Shop\Http\Requests\AdminRegisteredUserStoreRequest;

class ShopAdminRegisteredUserCompaniesController extends Controller
{}
