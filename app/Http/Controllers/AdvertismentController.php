<?php

    namespace App\Http\Controllers;

    use App\Advertisment;
    use Illuminate\Http\Request;
    use Image;

    class AdvertismentController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth', ['except' => ['edit']]);
            $this->middleware('admin', ['only' => ['add']]);
            $this->middleware('care', ['only' => 'index']);
        }

        public function index()
        {
            $advertisments = Advertisment::all();

            return view('admin.advertisment.index', compact(['advertisments']));
        }

        public function add(Request $request)
        {
            $this->validate($request, [
                'avatar'  => 'required|image',
                'order'   => 'required',
                'city_id' => 'required|exists:cities,id',
            ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(768, 195)->save(public_path(Advertisment::$avatar_path . $filename), 100);
            } else {
                $filename = "jbadvert.png";
            }
            $advertisment = Advertisment::create([
                'avatar'  => $filename,
                'ord'     => $request->order,
                'city_id' => $request->city_id,
            ]);

            return back()->with([
                'message' => "Advertisment Added",
            ]);
        }

        public function edit(Request $request)
        {
            $this->validate($request, [
                'id'     => 'required|exists:advertisments',
                'active' => 'required',
            ]);

            $advertisment = Advertisment::find($request->id);
            $ac = 0;
            if ($request->active !== 'false') {
                $ac = 1;
            }
            $advertisment->active = $ac;
            $advertisment->save();

            return ['status' => 'ok', 'active' => $advertisment->active];
        }
    }
