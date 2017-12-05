<?php

    namespace App\Http\Controllers;

    use App\Category;
    use App\City;
    use App\Country;
    use App\State;
    use App\SubCity;
    use Illuminate\Http\Request;

    class ApiLocationController extends Controller
    {

        public function __construct()
        {
            ini_set('memory_limit', '256M');
        }

        public function location_details(Request $request)
        {
            $data = (new ApiController())->getUpdate();
            $data['countries'] = Country::withCount(['cities'])->get();

            return $data;
        }

        public function cities(Request $request)
        {
            $data = (new ApiController())->getUpdate();

            $states = State::whereIn('country_id', [1])->pluck('id');
            // $data['cities'] = City::whereIn('state_id', $states)->get();


            $requiredCities = ["jalandhar", "others"];
            $data['cities'] = City::whereIn('state_id', $states)->where(function($query) use($requiredCities) {
                $query->whereRaw("LOWER(name) = '$requiredCities[0]' OR LOWER(name) = '$requiredCities[1]'");
            })->get();

           // $data['cities'] = City::limit(2)->get();

            return $data;
        }

        public function country_details(Request $request)
        {
            $this->validate($request, [
                'id' => 'required|exists:countries,id',
            ]);
            $country = Country::find($request->id);
            $country->states->makeHidden('country');

            return $country;
        }

        public function state_details(Request $request)
        {
            $this->validate($request, [
                'id' => 'required|exists:states,id',
            ]);
            $state = State::find($request->id);
            $state->country;
            $state->cities->makeHidden('state');

            return $state;
        }

        public function city_details(Request $request)
        {
            $this->validate($request, [
                'id' => 'required|exists:cities,id',
            ]);
            $city = City::find($request->id);
            $city->subCities->makeHidden('city');
            $city->stores;

            return $city;
        }

        public function city_details_with_categories(Request $request)
        {
            $res = array();
            $this->validate($request, [
                'id' => 'required|exists:cities,id',
            ]);
            $city = City::find($request->id);
            $city->subCities->makeHidden('city');
            $city->stores;

            $res['city'] = $city;
            $res['categories'] = Category::with('subcategories')->get();

            return $res;
        }

        public function subcity_details(Request $request)
        {
            $this->validate($request, [
                'id' => 'required|exists:sub_cities,id',
            ]);
            $subcity = SubCity::find($request->id);
            $subcity->stores;

            return $subcity;
        }

        public function city(City $city)
        {
            $city->makeHidden(['usableBooklets']);
            $res = $city->toArray();
            $res['booklets'] = $city->usableBooklets->values();

            return $res;
        }
    }
