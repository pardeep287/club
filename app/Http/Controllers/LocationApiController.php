<?php

    namespace App\Http\Controllers;

    use App\City;
    use App\Country;
    use App\State;
    use App\SubCity;
    use Illuminate\Http\Request;


    class LocationApiController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth', ['except' => []]);
            $this->middleware('admin', ['only' => [
                'country_add',
                'country_edit',
                'country_delete',

                'state_add',
                'state_edit',
                'state_delete',

                'city_add',
                'city_edit',
                'city_delete',
            ]]);
        }

        public function state(Request $request)
        {
            $states = State::all();

            return view('admin.location.state.all', compact(['states']));
        }

        public function state_add(Request $request)
        {
            $this->validate($request, [
                'country_id' => "required|exists:countries,id",
            ]);
            $country = Country::find($request->country_id);

            return (new LocationController())->state_add($request, $country);
        }

        public function city(Request $request)
        {
            $cities = City::all();

            return view('admin.location.city.all', compact(['cities']));
        }

        public function city_add(Request $request)
        {
            $this->validate($request, [
                'country_id' => "required|exists:countries,id",
                'state_id'   => "required|exists:states,id",
            ]);
            $country = Country::find($request->country_id);
            $state = State::find($request->state_id);

            return (new LocationController())->city_add($request, $country, $state);
        }

        public function subcity(Request $request)
        {
            $subCities = SubCity::all();

            return view('admin.location.subcity.all', compact(['subCities']));
        }

        public function subcity_add(Request $request)
        {
            $this->validate($request, [
                'country_id' => "required|exists:countries,id",
                'state_id'   => "required|exists:states,id",
                'city_id'    => "required|exists:cities,id",
            ]);
            $country = Country::find($request->country_id);
            $state = State::find($request->state_id);
            $city = City::find($request->city_id);

            return (new LocationController())->subcity_add($request, $country, $state, $city);
        }

    }
