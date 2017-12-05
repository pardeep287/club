<?php

    namespace App\Http\Controllers;

    use App\City;
    use App\Store;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Rule;
    use Image;

    class StoreController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('care');
            $this->middleware('admin', ['only' => ['add', 'edit']]);
        }


        public function index()
        {
            $stores = Store::all();

            return view('admin.store.index', compact(['stores']));
        }

        public function add(Request $request)
        {
            $this->validate($request, [
                'city_id'   => 'required|exists:cities,id',
                'name'      =>
                    [
                        'required',
                        'max:185',
                        Rule::unique('stores', 'name')->where('city_id', $request->city_id),
                    ],
                'address_1' => 'required|min:10|max:150',
                'address_2' => 'nullable|min:5|max:150',
                'address_3' => 'nullable|min:5|max:150',
                'pincode'   => 'required|max:25|min:6',
                'longitude' => 'required',
                'latitude'  => 'required',
                'terms'     => 'required|min:10',
                'mobile'    => 'required|min:10',
            ]);


            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(720, 400)->save(public_path(Store::$avatar_path . $filename), 100);
            } else {
                $filename = "jbstore.png";
            }

            $city = City::find($request->city_id);

            // $request->address = ($request->address) ? $request->address : "{$city->name}, {$city->state->name} in {$city->state->country->name}";

            $address = $request->address_1 . '\n'
                . $request->address_2 . '\n'
                . $request->address_3;

            $request->active = (isset($request->active)) ? $request->active : false;

            $store = Store::create([
                'name'        => $request->name,
                'avatar'      => $filename,
                'address'     => $address,
                'city_id'     => $request->city_id,
                'sub_city_id' => $request->sub_city_id,
                'address_1'  => $request->address_1,
                'address_2'  => $request->address_2,
                'address_3'  => $request->address_3,
                'pincode'    => $request->pincode,
                'latitude'   => $request->latitude,
                'longitude'  => $request->longitude,
                'active'     => $request->has('active'),
                'terms'      => $request->terms,
                'mobile'     => $request->mobile,
                'top_pick'   => $request->has('top_pick'),
                'trusted'    => $request->has('trusted'),
                'preferred'  => $request->has('preferred'),
                'membership' => $request->input('membership'),
            ]);

            $store->categories()->sync($request->categories);
            $store->save();

            return back()->with(['message' => 'Store Created Successfully.']);
        }

        public function edit(Request $request)
        {
            $store = Store::find($request->id);
            if ($store == null) {
                return back()->withErrors(['id' => 'Store not found']);
            }


            $this->validate($request, [
                'city_id'    => 'required|exists:cities,id',
                'name'       =>
                    [
                        'required',
                        'max:185',
                    ],
                'address_1'  => 'required|min:10|max:150',
                'address_2'  => 'nullable|min:5|max:150',
                'address_3'  => 'nullable|min:5|max:150',
                'pincode'    => 'required|max:25|min:6',
                'longitude'  => 'required',
                'latitude'   => 'required',
                'terms'      => 'required|min:10',
                'categories' => 'required',
                'mobile'     => 'required|min:10',
            ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(720, 400)->save(public_path(Store::$avatar_path . $filename), 100);
            } else {
                $filename = $store->avatar;
            }

            $city = City::find($request->city_id);

            $request->address = ($request->address) ? $request->address : "{$city->name}, {$city->state->name} in {$city->state->country->name}";

            $address = $request->address_1 . '\n'
                . $request->address_2 . '\n'
                . $request->address_3;

            $request->active = (isset($request->active)) ? $request->active : false;

            $store->fill([
                'name'        => $request->name,
                'avatar'      => $filename,
                'address'     => $request->address,
                'city_id'     => $request->city_id,
                'sub_city_id' => $request->sub_city_id,
                'address_1'  => $request->address_1,
                'address_2'  => $request->address_2,
                'address_3'  => $request->address_3,
                'pincode'    => $request->pincode,
                'latitude'   => $request->latitude,
                'longitude'  => $request->longitude,
                'active'     => $request->has('active'),
                'terms'      => $request->terms,
                'mobile'     => $request->mobile,
                'top_pick'   => $request->has('top_pick'),
                'trusted'    => $request->has('trusted'),
                'preferred'  => $request->has('preferred'),
                'membership' => $request->input('membership'),
            ]);

            $store->categories()->sync($request->categories);
            $store->save();

            return back()->with([
                'message' => "Edited store",
            ]);
        }

        public function report(Request $request)
        {
            $this->validate($request, [
                'id' => 'exists:stores,id',
            ]);
            $store = Store::find($request->id);

            return view('admin.store.report', compact(['store']));
        }

        //
    }