<?php

    namespace Modules\Shop\Http\Controllers\admin\Settings\ZipCodes;

    use App\Helpers\WebsiteHelper;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Modules\Shop\Entities\Settings\City;

    class CityZipCodesController extends Controller
    {
        public function index()
        {
            $cities = City::orderBy('country_id', 'asc')->with('state', 'country')->orderBy('state_id', 'asc')->orderBy('name', 'asc')->paginate(20);

            return view('shop::zip_codes.index', ['cities' => $cities]);
        }

        public function edit($id)
        {
            $city = City::find($id);
            WebsiteHelper::redirectBackIfNull($city);

            return view('shop::zip_codes.edit', ['city' => $city]);
        }

        public function update($id, Request $request)
        {
            $city = City::find($id);
            WebsiteHelper::redirectBackIfNull($city);
            
            $zipCodes = array_filter(array_map('trim', explode(",", $request->zip_codes)));
            $city->update(['zip_codes' => implode(",", $zipCodes)]);

            return redirect(route('zip_codes.index'))->with('success', __('Successful update'));
        }
    }
