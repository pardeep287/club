<?php

    namespace App\Http\Controllers;

    use App\City;
    use App\Country;
    use App\State;
    use App\SubCity;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Rule;


    class LocationController extends Controller
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

        public function country_index()
        {
            $countries = Country::all();

            return view('admin.location.country.index', compact(['countries']));
        }

        public function country_add(Request $request)
        {
            $this->validate($request, [
                'name'          => 'required|unique:countries,name|min:3|max:25',
                'locale'        => "required|min:2",
                'currency_code' => "required|min:2",
                'currency_name' => "required|min:2",
                'mobile_prefix' => "required|min:2",
                'short_name'    => "required|min:2|unique:countries,short_name",
            ]);
            $country = Country::create($request->only([
                'name',
                'locale',
                'currency_code',
                'currency_name',
                'mobile_prefix',
                'short_name',
            ]));

            return back()->with([
                'message' => "Country {$country->name} added.",
            ]);
        }

        public function country_edit(Request $request)
        {
            $this->validate($request, [
                'id'            => "required|exists:countries,id",
                'name'          => "required|min:3|max:25|unique:countries,name,{$request->input('id')}",
                'locale'        => "required|min:2",
                'currency_code' => "required|min:2",
                'currency_name' => "required|min:2",
                'mobile_prefix' => "required|min:2",
                'short_name'    => "required|min:2|unique:countries,short_name,{$request->input('id')}",
            ]);

            $country = Country::find($request->id);
            $c = $country->name;

            $country->update($request->only([
                'name',
                'locale',
                'currency_code',
                'currency_name',
                'mobile_prefix',
                'short_name',
            ]));

            return back()->with(
                [
                    'message' => "{$country->name} Updated",
                ]
            );
        }


        public function state_index(Country $country)
        {
            $states = $country->states;

            return view('admin.location.state.index', compact(['country', 'states']));
        }

        public function state_add(Request $request, Country $country)
        {
            $this->validate($request, [
                "name" => [
                    'required',
                    'min:3',
                    'max:25',
                    Rule::unique('states', 'name')->where('country_id', $country->id),
                ],
            ]);

            $country->states()->create(
                $request->only(['name'])
            );

            return back()->with([
                'message' => "State $request->name added",
            ]);
        }

        public function state_edit(Request $request, Country $country)
        {
            $this->validate($request, [
                "id"   => "required|exists:states,id",
                "name" => [
                    'required',
                    'min:3',
                    'max:25',
                    Rule::unique('states', 'name')->ignore($request->id)->where('country_id', $country->id),
                ],
            ]);

            $state = State::find($request->id);
            $s = $state->name;
            $state->fill($request->only(['name']));
            $state->save();

            return back()->with([
                'message' => "{$s} changed to $state->name",
            ]);
        }

        public function state_delete(Request $request, Country $country, State $state)
        {
            $state_name = $state->name;
            try {
                $state->delete();

                return back()->with([
                    'message' => "$state_name deleted.",
                ]);
            } catch (\Exception $e) {
                return back()->withErrors([
                    'state' => "Delete Cities before you delete a state.",
                ]);
            }
        }


        public function city_index(Country $country, State $state)
        {
            $cities = $state->cities;

            return view('admin.location.city.index', compact(['country', 'state', 'cities']));
        }

        public function city_add(Request $request, Country $country, State $state)
        {

            // 'required|unique:cities,name,NULL,state_id,'.$state
            $this->validate($request, [
                'name' => [
                    'required',
                    Rule::unique('cities', 'name')->where('state_id', $state->id),
                ],
            ]);
            $city = $state->cities()->create($request->only(['name']));
            $city->subCities()->create([
                'name' => "{$city->getOriginal('name')}, Main",
            ]);

            return back()->with([
                'message' => "City {$request->name} added in {$state->name}",
            ]);
        }

        public function city_edit(Request $request, Country $country, State $state)
        {
            $city = City::find($request->id);
            $this->validate($request, [
                'state_id' => 'required|exists:states,id',
                'name'     => [
                    'required',
                    Rule::unique('cities', 'name')->ignore($request->id)->where('state_id', $request->state_id),
                ],
            ]);

            $city->fill($request->only(['state_id', 'name']));

            $city->save();

            return back()->with([
                'message' => "City: {$city->name} updated.",
            ]);
        }

        public function city_delete(Request $request, Country $country, State $state, City $city)
        {
            $city_name = $city->name;
            try {
                $city->delete();

                return back()->with([
                    'message' => "$city_name deleted.",
                ]);
            } catch (\Exception $e) {
                return back()->withErrors([
                    'state' => "Delete Booklets before you delete a city.",
                ]);
            }
        }


        public function subCity_index(Country $country, State $state, City $city)
        {
            $subCities = $city->subCities;

            return view('admin.location.subcity.index', compact(['country', 'state', 'city', 'subCities']));
        }

        public function subcity_add(Request $request, Country $country, State $state, City $city)
        {
            $this->validate($request, [
                'name' => [
                    'required',
                    'min:10',
                    'max: 25',
                    Rule::unique('sub_cities', 'name')->where('city_id', $city->id),
                ],
            ]);

            $city->subCities()->create([
                'name' => $request->name,
            ]);

            return back()->with([
                'message' => "$request->name has been added to {$city->name}",
            ]);
        }

        public function subcity_edit(Request $request, Country $country, State $state, City $city)
        {
            $this->validate($request, [
                'id'   => "required|exists:sub_cities,id",
                'name' => [
                    'required',
                    'min:10',
                    'max: 25',
                    Rule::unique('sub_cities', 'name')->ignore($request->id)->where('city_id', $city->id),
                ],
            ]);

            $subcity = SubCity::find($request->id);
            $sc = array_get($subcity->getAttributes(), 'name');
            $subcity->fill(
                [
                    'name' => $request->name,
                ]
            );

            $subcity->save();

            return back()->with([
                'message' => "$sc changed to {$subcity->name}",
            ]);
        }


    }