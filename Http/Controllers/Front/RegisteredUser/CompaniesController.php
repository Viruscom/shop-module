<?php

    namespace Modules\Shop\Http\Controllers\Front\RegisteredUser;

    use App\Helpers\LanguageHelper;
    use App\Helpers\SeoHelper;
    use App\Helpers\WebsiteHelper;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Modules\Shop\Entities\RegisteredUser\Firms\Company;
    use Modules\Shop\Entities\Settings\Main\CountrySale;

    class CompaniesController extends Controller
    {
        public function index()
        {
            $currentLanguage = LanguageHelper::getCurrentLanguage();
            SeoHelper::setTitle('Фирми | ' . $currentLanguage->seo_title);
            $registeredUser = Auth::guard('shop')->user();

            return view('shop::front.registered_users.profile.companies.index', [
                'registeredUser' => $registeredUser,
                'defaultCompany' => Company::where('user_id', $registeredUser->id)->isDefault(true)->isDeleted(false)->first(),
                'otherCompanies' => Company::where('user_id', $registeredUser->id)->isDefault(false)->isDeleted(false)->get(),
            ]);
        }
        public function store(Request $request)
        {
            $registeredUser = Auth::guard('shop')->user();
            WebsiteHelper::redirectBackIfNull($registeredUser);

            if ($registeredUser->companies->isEmpty()) {
                $request['is_default'] = true;
            }
            $request['email']           = $registeredUser->email;
            $request['company_address'] = $request->street . ' ' . $request->street_number;

            $company = $registeredUser->companies()->create($request->all());

            if ($request->has('is_default') && $registeredUser->companies->isNotEmpty()) {
                $registeredUser->companies()->update(['is_default' => false]);
                $company->update(['is_default' => true]);
            }

            return redirect()->route('shop.registered_user.account.companies', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code])->with('success', trans('admin.common.successful_create'));
        }
        public function create()
        {
            return view('shop::front.registered_users.profile.companies.create', [
                'registeredUser' => Auth::guard('shop')->user(),
                'countriesSale'  => CountrySale::with('country', 'country.cities')->get()
            ]);
        }
        public function update($languageSlug, $id, Request $request)
        {
            $registeredUser = Auth::guard('shop')->user();
            WebsiteHelper::redirectBackIfNull($registeredUser);

            $company = Company::find($id);
            WebsiteHelper::redirectBackIfNull($company);

            if ($request->has('is_default') && $registeredUser->companies->isNotEmpty()) {
                $registeredUser->companies()->update(['is_default' => false]);
                $company->update(['is_default' => true]);
            }

            $company->update($request->except(['is_default']));

            return redirect()->route('shop.registered_user.account.companies', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code])->with('success', trans('admin.common.successful_edit'));
        }
        public function edit($languageSlug, $id)
        {
            $registeredUser = Auth::guard('shop')->user();
            WebsiteHelper::redirectBackIfNull($registeredUser);

            $company = Company::find($id);
            WebsiteHelper::redirectBackIfNull($company);

            return view('shop::front.registered_users.profile.companies.edit', [
                'registeredUser' => $registeredUser,
                'company'        => $company,
                'countriesSale'  => CountrySale::with('country', 'country.cities')->get()
            ]);
        }
        public function delete($languageSlug, $id)
        {
            $registeredUser = Auth::guard('shop')->user();
            WebsiteHelper::redirectBackIfNull($registeredUser);

            $company = Company::find($id);
            WebsiteHelper::redirectBackIfNull($company);

            $nextDefaultCompany = $registeredUser->companies()->where('id', '!=', $company->id)->first();
            if ($company->isDefault(true) && !is_null($nextDefaultCompany)) {
                $nextDefaultCompany->update(['is_default' => true]);
            }

            $company->update(['is_deleted' => true]);

            return redirect()->route('shop.registered_user.account.companies', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code])->with('success', trans('admin.common.successful_delete'));
        }
        public function setAsDefault($languageSlug, $id)
        {
            $registeredUser = Auth::guard('shop')->user();
            WebsiteHelper::redirectBackIfNull($registeredUser);

            $company = Company::find($id);
            WebsiteHelper::redirectBackIfNull($company);

            $registeredUser->companies()->update(['is_default' => false]);
            $company->update(['is_default' => true]);

            return back()->with('success-message', 'admin.common.successful_edit');
        }
    }
