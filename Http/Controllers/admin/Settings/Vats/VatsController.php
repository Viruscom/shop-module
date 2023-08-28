<?php

    namespace Modules\Shop\Http\Controllers\admin\Settings\Vats;

    use App\Helpers\WebsiteHelper;
    use App\Http\Controllers\Controller;
    use Modules\Shop\Entities\Settings\City;
    use Modules\Shop\Entities\Settings\CityVatCategory;
    use Modules\Shop\Entities\Settings\Country;
    use Modules\Shop\Entities\Settings\State;
    use Modules\Shop\Entities\Settings\StateVatCategory;
    use Modules\Shop\Entities\Settings\VatCategory;
    use Modules\Shop\Http\Requests\CityVatCategoryStoreRequest;
    use Modules\Shop\Http\Requests\CityVatCategoryUpdateRequest;
    use Modules\Shop\Http\Requests\StateVatCategoryStoreRequest;
    use Modules\Shop\Http\Requests\StateVatCategoryUpdateRequest;
    use Modules\Shop\Http\Requests\VatCategoryStoreRequest;
    use Modules\Shop\Http\Requests\VatCategoryUpdateRequest;
    use Modules\Shop\Http\Requests\VatRequest;

    class VatsController extends Controller
    {
        //----countries defualt vats
        public function index()
        {
            $countries = Country::orderBy('name', 'asc')->paginate(20);

            return view('shop::vats.index', ['countries' => $countries]);
        }

        public function edit($id)
        {
            $country = Country::find($id);
            WebsiteHelper::redirectBackIfNull($country);

            return view('shop::vats.edit', ['country' => $country]);
        }
        public function states($id)
        {
            $country = Country::find($id);
            WebsiteHelper::redirectBackIfNull($country);

            return view('shop::vats.states.index', ['country' => $country]);
        }

        //----states defualt vats
        public function statesEdit($id)
        {
            $state = State::find($id);
            WebsiteHelper::redirectBackIfNull($state);

            return view('shop::vats.states.edit', ['state' => $state]);
        }
        public function statesUpdate($id, VatRequest $request)
        {
            $state = State::find($id);
            WebsiteHelper::redirectBackIfNull($state);

            $state->update(['vat' => $request->vat]);

            return redirect(route('vats.countries.states.index', ['id' => $state->country->id]))->with('success', __('admin.common.successful_edit'));
        }
        public function update($id, VatRequest $request)
        {
            $country = Country::find($id);
            WebsiteHelper::redirectBackIfNull($country);

            if (is_null($request->vat)) {
                $request->vat = 0;
            }
            $country->update(['vat' => $request->vat]);

            return redirect(route('vats.countries.index'))->with('success', __('admin.common.successful_edit'));
        }
        //----cities defualt vats
        public function cities($id)
        {
            $state = State::find($id);
            WebsiteHelper::redirectBackIfNull($state);

            return view('shop::vats.states.cities.index', ['state' => $state]);
        }

        public function citiesEdit($id)
        {
            $city = City::find($id);
            WebsiteHelper::redirectBackIfNull($city);

            return view('shop::vats.states.cities.edit', ['city' => $city]);
        }

        public function citiesUpdate($id, VatRequest $request)
        {
            $city = City::find($id);
            WebsiteHelper::redirectBackIfNull($city);

            $city->update(['vat' => $request->vat]);

            return redirect(route('vats.countries.states.cities.index', ['id' => $city->state->id]))->with('success', __('admin.common.successful_edit'));
        }
        //----countries categories
        public function categories($id)
        {
            $country = Country::find($id);
            WebsiteHelper::redirectBackIfNull($country);

            return view('shop::vats.categories.index', ['country' => $country]);
        }

        public function categoriesCreate($id)
        {
            $country = Country::find($id);
            WebsiteHelper::redirectBackIfNull($country);

            return view('shop::vats.categories.create', ['country' => $country]);
        }


        public function categoriesStore($id, VatCategoryStoreRequest $request)
        {
            $country = Country::find($id);
            WebsiteHelper::redirectBackIfNull($country);

            $category = $country->vat_categories()->create(['name' => $request->name, 'vat' => $request->vat]);

            return redirect(route('vats.countries.categories.index', ['id' => $country->id]))->with('success', __('admin.common.successful_create'));
        }

        public function categoriesEdit($id)
        {
            $category = VatCategory::find($id);
            WebsiteHelper::redirectBackIfNull($category);

            return view('shop::vats.categories.edit', ['category' => $category]);
        }

        public function categoriesUpdate($id, VatCategoryUpdateRequest $request)
        {
            $category = VatCategory::find($id);
            WebsiteHelper::redirectBackIfNull($category);

            $category->update(['name' => $request->name, 'vat' => $request->vat]);

            return redirect(route('vats.countries.categories.index', ['id' => $category->country->id]))->with('success', __('admin.common.successful_edit'));
        }

        public function categoriesDestroy($id)
        {
            $category = VatCategory::find($id);
            WebsiteHelper::redirectBackIfNull($category);

            $category->delete();

            return redirect()->back()->with('success', __('admin.common.successful_edit'));
        }
        //----states categories
        public function statesCategories($id)
        {
            $state = State::find($id);
            WebsiteHelper::redirectBackIfNull($state);

            return view('shop::vats.states.categories.index', ['state' => $state]);
        }

        public function statesCategoriesCreate($id)
        {
            $state = State::find($id);
            WebsiteHelper::redirectBackIfNull($state);

            return view('shop::vats.states.categories.create', ['state' => $state]);
        }


        public function statesCategoriesStore($id, StateVatCategoryStoreRequest $request)
        {
            $state = State::find($id);
            WebsiteHelper::redirectBackIfNull($state);

            $category = $state->vat_categories()->create(['vat_category_id' => $request->vat_category_id, 'vat' => $request->vat]);

            return redirect(route('vats.countries.states.categories.index', ['id' => $state->id]))->with('success', __('admin.common.successful_create'));
        }

        public function statesCategoriesEdit($id)
        {
            $category = StateVatCategory::find($id);
            WebsiteHelper::redirectBackIfNull($category);

            return view('shop::vats.states.categories.edit', ['category' => $category]);
        }

        public function statesCategoriesUpdate($id, StateVatCategoryUpdateRequest $request)
        {
            $category = StateVatCategory::find($id);
            WebsiteHelper::redirectBackIfNull($category);

            $category->update(['vat' => $request->vat]);

            return redirect(route('vats.countries.states.categories.index', ['id' => $category->state->id]))->with('success', __('admin.common.successful_edit'));
        }

        public function statesCategoriesDestroy($id)
        {
            $category = StateVatCategory::find($id);
            WebsiteHelper::redirectBackIfNull($category);

            $category->delete();

            return redirect()->back()->with('success', __('admin.common.successful_edit'));
        }
        //----cities categories
        public function citiesCategories($id)
        {
            $city = City::find($id);
            WebsiteHelper::redirectBackIfNull($city);

            return view('shop::vats.states.cities.categories.index', ['city' => $city]);
        }

        public function citiesCategoriesCreate($id)
        {
            $city = City::findOrFail($id);

            return view('shop::vats.states.cities.categories.create', ['city' => $city]);
        }


        public function citiesCategoriesStore($id, CityVatCategoryStoreRequest $request)
        {
            $city = City::find($id);
            WebsiteHelper::redirectBackIfNull($city);

            $category = $city->vat_categories()->create(['vat_category_id' => $request->vat_category_id, 'vat' => $request->vat]);

            return redirect(route('vats.countries.states.cities.categories.index', ['id' => $city->id]))->with('success', __('admin.common.successful_create'));
        }

        public function citiesCategoriesEdit($id)
        {
            $category = CityVatCategory::find($id);
            WebsiteHelper::redirectBackIfNull($category);

            return view('shop::vats.states.cities.categories.edit', ['category' => $category]);
        }

        public function citiesCategoriesUpdate($id, CityVatCategoryUpdateRequest $request)
        {
            $category = CityVatCategory::find($id);
            WebsiteHelper::redirectBackIfNull($category);

            $category->update(['vat' => $request->vat]);

            return redirect(route('vats.countries.states.cities.categories.index', ['id' => $category->city->id]))->with('success', __('admin.common.successful_edit'));
        }

        public function citiesCategoriesDestroy($id)
        {
            $category = CityVatCategory::find($id);
            WebsiteHelper::redirectBackIfNull($category);

            $category->delete();

            return redirect()->back()->with('success', __('admin.common.successful_edit'));
        }
    }
