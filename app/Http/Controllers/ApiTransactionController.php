<?php

    namespace App\Http\Controllers;

    use App\Booklet;
    use App\Client;
    use App\ClientCode;
    use App\Deal;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class ApiTransactionController extends Controller
    {

        public function __construct()
        {
            ini_set('memory_limit', '256M');
        }

        public function cityBooklets(Request $request)
        {
            $booklets = Booklet::where('city_id', $request->city_id)
                ->get();

            return $booklets;
        }

        public function booklets()
        {
            $booklets = Booklet::all();
            foreach ($booklets as $booklet) {
                $booklet->load('deals');
            }

            return $booklets;
        }

        public function booklet(Booklet $booklet)
        {
            $booklet->deals = $booklet->deals->where('usable', true)->sortByDesc('updated_at')->load('store');

            return $booklet->makeVisible('deals');
        }

        public function bookletDeals(Request $request)
        {
            $this->validate($request, [
                'mobile'      => 'required|exists:clients,mobile',
//                'device_id'   => 'required|exists:clients,device_id',
                'client_code' => 'required|exists:client_codes,id',
            ]);

            $client = Client::mobile($request->mobile);
            $client->makeHidden(['city', 'transactions', 'referred_to', 'booklets', 'everyReferral', 'indirectReferral', 'imageDimension', 'referral']);
            $clientCode = ClientCode::find($request->client_code);

            $res['client'] = $client;

            $clientUsable = $client->clientCodes->contains($clientCode);

            $deals = array();
            $today = Carbon::today();
            $activationDate = $clientCode->created_at->copy()->startOfDay();

//            if ($clientUsable && $client->device_id === $request->device_id) {
            if ($clientUsable) {
                $booklet = $clientCode->booklet;
                $res['client_code'] = $clientCode;

                foreach ($booklet->deals()->with('store')->orderByDesc('updated_at')->get() as $deal) {
                    $dealTemp = $client->getUsage($deal, $clientCode);
                    $deal->usage = $dealTemp;
                    if (($dealTemp['today'] < $deal->max_daily_limit) && ($dealTemp['life_time'] < $deal->max_quantity) && $deal->usable) {
                        if ($deal->type == 'explicit') {
                            $deal->end = $activationDate->copy()->addDays($deal->days)->startOfDay();
                        } else {
                            $deal->end = ($booklet->expires_on->gt($deal->end)) ? $deal->end : $booklet->expires_on;
                        }

                        $deal->dealEndsIn = $today->diffInDays($deal->end, false);
                        $deal->daysLeftHuman = $deal->end->diffForHumans($today);
                        $deals[] = $deal;
                    }
                }

                $deals = collect($deals);
//                $deals = Deal::with('store')->find([1,23,32]);

                $res['deals_count'] = $deals->count();
                $res['deals'] = $deals;
            }

            return $res;
        }

        public function getPrice(Request $request)
        {
            $this->validate($request, [
                'type' => "required",
                'id'   => 'required',
            ]);

            $id = $request->id;
            switch ($request->type) {
                case 'booklet':
                    $res = Booklet::find($id);
                    break;
                case 'deal':
                    $res = Deal::find($id);
                    break;
                default:
                    return false;
            }

            return $res;
        }

        public function purchaseBooklet(Request $request, Booklet $booklet)
        {
            return ['message' => "Use Customer care to purchase"];
        }

    }
