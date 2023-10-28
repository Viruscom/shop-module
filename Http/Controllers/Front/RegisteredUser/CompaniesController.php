<?php

    namespace Modules\Shop\Http\Controllers\Front\RegisteredUser;

    use App\Helpers\LanguageHelper;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Modules\Shop\Entities\RegisteredUser\Firms\Company;

    class CompaniesController extends Controller
    {
        public function index()
        {
            return view('shop::front.registered_users.profile.companies.index', [
                'registeredUser' => Auth::guard('shop')->user()->load(['companies' => function ($query) {
                    $query->where('is_default', false);
                }])->first(),
                'defaultCompany' => Company::where('is_default', true)->first()
            ]);
        }

        public function create()
        {
            return view('shop::front.registered_users.profile.companies.create', ['registeredUser' => Auth::guard('shop')->user()]);
        }

        public function store(Request $request)
        {
            return redirect()->route('shop.registered_user.account.companies', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code])->with('success', trans('admin.common.successful_create'));
        }
        public function edit($id)
        {
            return view('shop::front.registered_users.profile.companies.edit', ['registeredUser' => Auth::guard('shop')->user()]);
        }

        public function update($id, Request $request)
        {

            return redirect()->route('shop.registered_user.account.companies', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code])->with('success', trans('admin.common.successful_edit'));
        }

        public function delete($id, Request $request)
        {
            return redirect()->route('shop.registered_user.account.companies', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code])->with('success', trans('admin.common.successful_delete'));
        }
    }
