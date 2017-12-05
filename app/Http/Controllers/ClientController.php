<?php

    namespace App\Http\Controllers;

    use App\City;
    use App\Client;
    use App\DefaultValue;
    use App\Store;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Image;

    class ClientController extends Controller
    {

        /**
         * Create a new controller instance.
         *
         */
        public function __construct()
        {
            $this->middleware('auth', ['except' => ['booklet']]);
            $this->middleware('admin', ['only' => ['add', 'edit']]);
//            $this->middleware('care', ['only' => ['sendSMS']]);
        }

        public function index()
        {
            $clients = Client::all();

            return view('admin.client.index', compact(['clients']));
        }

        public function booklet(Client $client)
        {
            $booklets = array();

            foreach ($client->codes as $code) {
                $booklets[] = $code->booklet;
            }


            return view('admin.client.booklets', compact(['booklets', 'client']));
        }

        public function add(Request $request)
        {
            $imageDimenssion = DefaultValue::getValue('client_imageDimension', '156')['clean'];
            $this->validate($request, [
                'name'    => "nullable|min:2|max:100",
                "mobile"  => "required|min:10|max:16|unique:clients,mobile",
                'email'   => "nullable|email",
                'address' => "nullable|max:150",
                'city_id' => 'exists:cities,id',
            ]);

            $name = ($request->name) ? $request->name : $request->mobile;
            $mobile = $request->mobile;
            $email = $request->email;
            $city = City::find($request->city_id);

            $address = ($request->address) ? $request->address : $city->name;

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                ini_set('memory_limit', '512M');
                Image::make($avatar)->resize($imageDimenssion, $imageDimenssion)->save(public_path(Client::$avatar_path . $filename), 100);
            } else {
                $filename = 'jbclient.png';
            }


            $client = Client::create([
                'name'    => $name,
                'mobile'  => $mobile,
                'email'   => $email,
                'address' => $address,
                'avatar'  => $filename,
                'city_id' => $city->id,
            ]);

            try {
                if (auth()->user()->is_admin() && isset($request->client_type)) {
                    $client->client_type = $request->client_type;
                }
                $client->save();
            } catch (\Exception $e) {
                Log::error("Client Creation Error", ['message' => $e->getMessage(), 'line' => $e->getLine()]);
            }


            return back()->with(
                [
                    'message' => DefaultValue::getValue('clientAdded', 'Client Added')['clean'],
                ]
            );

        }

        public function edit(Request $request)
        {
            $androidCall = strpos(route('client_profile_update'), $request->path()) !== false;

            $imageDimenssion = DefaultValue::getValue('client_imageDimension', '156')['clean'];

            $this->validate($request, [
                'id'      => 'required|exists:clients,id',
                'name'    => "required|min:2|max:100",
                "mobile"  => "required|min:10|max:16|exists:clients,mobile",
                'email'   => "required|email",
                'address' => "nullable|max:150",
                'city_id' => 'required|exists:cities,id',
            ]);

            $client = Client::find($request->id);

            if ($request->mobile === $client->mobile) {
                $name = ($request->name) ? $request->name : $request->mobile;
                // $mobile = $request->mobile;
                $email = $request->email;
                $city = City::find($request->city_id);

                $address = (isset($request->address)) ? $request->address : $city->getOriginal('name');

                if ($request->hasFile('avatar')) {
                    $avatar = $request->file('avatar');
                    $filename = time() . '.' . $avatar->getClientOriginalExtension();

                    try {
                        ini_set('memory_limit', '512M');
                        Image::make($avatar)->resize($imageDimenssion, $imageDimenssion)->save(public_path(Client::$avatar_path . $filename), 100);
                    } catch (\Exception $exception) {
                        Log::error("Image Make", [
                            $exception->getMessage(),
                        ]);
                    }

                } else {
                    $filename = $client->avatar;
                }
                $client->fill([
                    'name'    => $name,
                    'avatar'  => $filename,
                    // 'mobile' => $mobile,
                    'email'   => $email,
                    'address' => $address,
                    'city_id' => $city->id,
                ]);

                if (!$androidCall) {
                    try {
                        if (auth()->user()->is_admin() && isset($request->client_type)) {
                            $client->client_type = $request->client_type;
                        }
                    } catch (\Exception $e) {
                        Log::error("Client Updation Error", ['message' => $e->getMessage(), 'line' => $e->getLine()]);
                    }
                }

                $client->save();

                $res = [
                    'message' => DefaultValue::getValue('clientUpdated', 'Client Updated')['clean'],
                    'status'  => 'success',
                    'avatar'  => $client->avatar,
                ];

            } else {
                $res = [
                    'message' => 'Registered Mobile Number doesnot match.',
                    'status'  => 'failure',
                ];
            }

            if ($androidCall) {
                return $res;
            }

            return back()->with($res);
        }

        public function client_mobile(Request $request)
        {
            $this->validate($request, [
                'mobile' => 'required|exists:clients,mobile',
            ]);
            $client = Client::mobile($request->mobile);

            if ($client) {
                $transactions = $client->transactions;

                return view('admin.report.index', compact(['transactions', 'client']));
            } else {
                return back()->withErrors([
                    "client" => "The Client with mobile no $request->mobile not found.",
                ]);
            }
        }

        public function referrals(Request $request)
        {
            $validator = \Validator::make($request->all(), [
                'mobile' => 'required|exists:clients,mobile',
            ]);

            if ($validator->fails()) {
                return back()->withErrors([
                    'mobile' => "Could not find the client you were looking for",
                ]);
            }

            $client = Client::mobile($request->mobile);

            return view('admin.client.referrals', compact(['client']));
        }

        public function history(Request $request)
        {
            $this->validate($request, [
                'mobile' => 'required|exists:clients,mobile',
            ]);

            $client = Client::mobile($request->mobile);
            $orders = $client->orders()->orderByDesc('created_at')->paginate(25);
            if ($client == null) {
                return back()->withErrors([
                    'clientnotfound' => "The mobile number $request->mobile not found in system.",
                ]);
            }

            return view('admin.client.history', compact(['client', 'orders']));
        }

        public function avail(Request $request)
        {
            $city = home_deals($request);
            $client = Client::mobile($request->input('mobile'));
            $store = Store::find($request->input('store_id'));

            if ($store == null) {
                $store = Store::where('city_id', $city->id)->where('active', 1)->first();
            }

            return view('admin.care.deal.avail', compact(['city', 'client', 'store']));
        }

        public function sendSMS(Request $request)
        {
            $this->validate($request, [
                'mobile'  => "required|exists:clients,mobile",
                "message" => "required|min:4|max:130",
            ]);

            $client = Client::mobile($request->input('mobile'));

            $res = $client->sendMessage($request->input('message'));

            if ($res['status'] == 'success') {
                return back()->with([
                    'message' => $res['message'],
                ]);
            } else {
                return back()->withErrors([
                    'messsage' => "The message you were trying to send was not delivered",
                ]);
            }
        }

    }