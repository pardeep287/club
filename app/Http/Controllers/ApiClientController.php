<?php

    namespace App\Http\Controllers;

    use App\City;
    use App\Client;
    use App\Code;
    use App\Country;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class ApiClientController extends Controller
    {

        public function __construct()
        {
            ini_set('memory_limit', '256M');
        }

        public function requestOTP(Request $request)
        {
            $this->validate($request, [
                'client_id' => "required|exists:clients,id",
            ]);
            $client = Client::find($request->client_id);

            return $client->getOTP();
        }

        public function validateOTP(Request $request)
        {
            $this->validate($request, [
                'client_id' => "required|exists:clients,id",
                'otp'       => 'required|min:4',
            ]);

            $client = Client::find($request->client_id);
            $otp = $request->otp;

            return [
                'match' => ($otp === $client->oneTimePass->otp),
            ];
        }

        public function login(Request $request)
        {
            $city = City::find($request->input('city_id'));
            $client = Client::mobile($request->input('mobile'));

            // For scenario when only Country has been selected.
            if ($request->has('country_id') && !$request->has('city_id')) {
                $country = Country::find($request->input('country_id'));
                if (!$country) {
                    $country = Country::first();
                }
                $city = $country->cities()->first();
            }

            $deviceID = $request->input('device_id');

            if (!$client) {
                // Register the user
                $referrer = Client::mobile($request->input('referral'));
                $client = Client::findOrCreate($request->input('mobile'), $deviceID, $city);

                if (!is_null($referrer) && ($referrer->id !== $client->id)) {
                    $referrer->referredTo()->save($client);
                }

                $client->newUser = 1;

//                Log::info('Register', ['request' => $request->all()]);
            } else {
                if (!is_null($deviceID)) {
                    $client->device_id = $deviceID;
                    $client->save();
                    $client->newUser = 0;
                }

//                Log::info('Login', ['request' => $request->all(), 'save device id' => [$client->device_id]]);
            }

            return $client;
        }

        public function registerDevice(Request $request)
        {
            $client = Client::where('mobile', $request->input('mobile'))->first();

            $device = $client->devices()->create(
                $request->only(['mobile', 'device_id', 'emulator', 'additional'])
            );

            return $device;
        }

        public function getClient(Request $request)
        {
            $client = Client::mobile($request->mobile);
            $client->referrals_count = $client->referredTo()->count();

            $client->makeHidden(
                [
                    'referred_to',
                    'transactions',
                    'everyReferral',
                    'indirectReferral',
                ]
            );

            return $client;
        }

        public function updateClient(Request $request)
        {
            $response = (new ClientController())->edit($request);

            return $response;
        }

        public function associate(Request $request)
        {
            $this->validate($request, [
                'id'           => 'required|exists:booklets,id',
                'mobile'       => "required|min:10",
                'code'         => "required",
                'purchased_by' => 'required|exists:clients,mobile',
            ]);

            $purchasedBy = Client::mobile($request->purchased_by);
            $code = Code::validate($request->code, $purchasedBy);

            $valid = false;

            if ($code && ($code->booklet_id == $request->id)) {
                $client = Client::findOrCreate($request->mobile, $code->city);
                $valid = $client->activate($code);
            }

            if ($valid) {
                $res = ['status' => 'success', 'code' => "valid", 'msg' => "Booklet activated successfully."];
            } else {
                $res = ['status' => 'failure', 'code' => "invalid", 'msg' => "The code is invalid."];
            }

            Log::info('Activate Booklet for Mobile', [
                'request'      => $request->all(),
                'response'     => $res,
                'code'         => $code,
                'purchased_by' => $purchasedBy,
            ]);

            return $res;
        }


    }
