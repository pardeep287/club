<?php

    namespace App\Http\Controllers;

    use App\Booklet;
    use App\City;
    use App\Country;
    use App\Deal;
    use App\State;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Rule;
    use Image;

    class BookletController extends Controller
    {

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('admin', ['except' => ['index', 'city_booklets', 'show']]);
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $booklets = Booklet::all();

            return view('admin.booklet.index', compact('booklets'));
            //
        }

        public function city_booklets(Country $country, State $state, City $city)
        {
            $booklets = $city->booklets;

            return view('admin.booklet.index', compact(['booklets', 'country', 'state', 'city']));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function add(Request $request)
        {
            $this->validate($request, [
                "name"     => [
                    'required',
                    Rule::unique('booklets', 'name')->where('city_id', $request->city_id),
                ],
                'city_id'  => "required|exists:cities,id",
                "price"    => "required|integer|min:0",
                "validity" => "required",
            ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(720, 400)->save(public_path(Booklet::$avatar_path . $filename), 100);
            } else {
                $filename = 'jbbooklet.png';
            }

            $booklet = Booklet::create([
                'name'     => $request->name,
                'city_id'  => $request->city_id,
                'price'    => $request->price,
                'validity' => $request->validity,
                'avatar'   => $filename,
            ]);

            return redirect()->route('booklet_deals', $booklet)->with(['message' => "Booklet $request->name added successfully"]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function edit(Request $request)
        {
            $booklet = Booklet::find($request->id);

            $this->validate($request, [
                'city_id'  => "required|exists:cities,id",
                "name"     => [
                    'required',
                    Rule::unique('booklets', 'name')->where('city_id', $request->city_id)->ignore($booklet->id),
                ],
                "price"    => "required|integer|min:0",
                "validity" => "required",
            ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(720, 400)->save(public_path(Booklet::$avatar_path . $filename), 100);
            } else {
                $filename = $booklet->avatar;
            }

            $booklet->name = $request->name;
            $booklet->price = $request->price;
            $booklet->validity = $request->validity;
            $booklet->avatar = $filename;

            $booklet->save();

            return back()->with(['message' => "Booklet $request->name edited successfully"]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function delete(Request $request, Booklet $booklet)
        {
            $booklet_name = $booklet->name;
            try {
                // $booklet->deals()->detach();
                // $booklet->codes()->delete();
                $booklet->delete();

                return back()->with([
                    'message' => "$booklet_name deleted.",
                ]);
            } catch (\Exception $e) {
                return back()->withErrors([
                    'state' => "Booklets once sold can not be deleted.",
                ]);
            }
        }

        /**
         * Display the specified resource.
         *
         * @param  int $booklet
         * @return \Illuminate\Http\Response
         */
        public function show(Booklet $booklet)
        {
            $stores = $booklet->city->stores;

            return view('admin.booklet.associate', compact(['booklet', 'stores']));
        }

        public function associate(Request $request, Booklet $booklet)
        {
            $sync = array();

            $booklet->deals()->detach();

            if (empty($request->deal)) {
                return back()->with([
                    'message' => "NO Deals in booklet now",
                ]);
            }

            foreach ($request->deal as $deal) {
                $deal = Deal::find($deal);
                $qty = $request->input("details.{$deal->id}.quantity");
                if ($qty <= 0) {
                    $qty = 1;
                }
                if ($qty > $deal->max_quantity) {
                    $qty = $deal->max_quantity;
                }

                $dlt = $request->input("details.{$deal->id}.daily_limit");
                if ($dlt <= 0) {
                    $dlt = 1;
                }
                if ($dlt > $deal->max_daily_limit) {
                    $dlt = $deal->max_daily_limit;
                }


                $sync[ $deal->id ] = [
                    'quantity'    => $qty,
                    'daily_limit' => $dlt,
                ];
            }

            $booklet->deals()->attach($sync);

            return back()->with([
                'message' => "Booklet Updated with {$booklet->deals->count()} deals.",
            ]);
        }

    }