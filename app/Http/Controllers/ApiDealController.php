<?php

    namespace App\Http\Controllers;

    use App\Advertisment;
    use App\City;
    use App\Client;
    use App\Deal;
    use App\DefaultValue;
    use App\Store;
    use DB;
    use Illuminate\Http\Request;

    class ApiDealController extends Controller
    {
        public function __construct()
        {
            ini_set('memory_limit', '256M');
        }

        public function citySpecificDeals(Request $request)
        {
            $res = array();
            $this->validate($request, [
                'city_id' => 'required|exists:cities,id',
            ]);

            $city = City::find($request->city_id);
            $adverts = Advertisment::where('active', '1')->orderBy('ord')->get();

            $deals = array();

            $dealIDS = Deal::select(DB::raw('store_id, max(id) as id'))->where('active', 1)
                ->where('kind', 'loose')
                ->groupBy('store_id')
                ->orderByDesc('id')
                ->pluck('id');

//            $maxHomeDeals = DefaultValue::getValue('max_home_deals', 16)['clean'];

            $maxHomeDeals = $city->stores()->where('active', 1)->count();

            foreach ($city->deals()->whereIn('id', $dealIDS)->latest()->get() as $deal) {
                if ($deal->usable) {
                    $deal->load('store');
                    $deals[] = $deal;
                }

                if (count($deals) >= $maxHomeDeals) {
                    break;
                }
            }

            $res['max_deals_allowed'] = $maxHomeDeals;

            $res['city'] = $city;
            $res['city']['deals'] = collect($deals);
            $res['city']['deals_count'] = $res['city']['deals']->count();

            $res['advertising_delay'] = DefaultValue::getValue('advertising_delay', 7);
            $res['advertising'] = $adverts;

            return $res;
        }

        public function cityCustomerSpecificDeals(Request $request)
        {
            $this->validate($request, [
                'city_id' => 'required|exists:cities,id',
                'mobile'  => 'required|exists:clients,mobile',
            ]);

            $res['city'] = home_deals($request);

            $adverts = Advertisment::where('active', '1')->where('city_id', $request->city_id)->inRandomOrder()->get();
            $res['advertising_delay'] = DefaultValue::getValue('advertising_delay', 7);
            $res['advertising'] = $adverts;

            return $res;
        }

        public function cityCustomerSpecificDealsSQL(Request $request)
        {
            $res = array();
            $this->validate($request, [
                'city_id' => 'required|exists:cities,id',
            ]);

            $minCouponCount = DefaultValue::getValue('minCouponCount', 1000)['clean'];

            $city = City::find($request->city_id);

            $pdo = \DB::getPdo();
            $statement = $pdo->prepare("SELECT *, '-' AS master_pass FROM deals WHERE kind = 'loose' AND city_id = :city_id AND date(now()) BETWEEN `begin` AND `end` AND id IN (SELECT deal_id FROM deal_coupons WHERE status = 'created' GROUP BY deal_id HAVING count(*) > :minCoupons)");
            $statement->execute([
                ':city_id'    => $city->id,
                ':minCoupons' => $minCouponCount,
            ]);
            $city_deals = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $city->deals = $city_deals;
            $city->totalDeals = count($city_deals);
            $city->totalStores = $city->stores()->count();

            $res['city'] = $city;

            $adverts = Advertisment::where('active', '1')->inRandomOrder()->get();
            $res['advertising_delay'] = DefaultValue::getValue('advertising_delay', 7);
            $res['advertising'] = $adverts;

            return $res;
        }

        public function storeCustomerSpecificDeals(Request $request)
        {
            $this->validate($request, [
                'store_id' => 'required|exists:stores,id',
                'mobile'   => 'required|exists:clients,mobile',
            ]);

            $store = Store::find($request->store_id);
            $client = Client::mobile($request->mobile);

            $store_deals = Deal::with(['categories', 'sub_categories', 'store'])
                ->where('active', 1)
                ->where('store_id', $store->id)
                ->where('kind', "loose")
                ->get();

            $store->deals = filter_deals($store_deals, $client, count($store_deals), true);

            $store->totalDeals = $store->deals->count();

            return $store;
        }

        public function dealDetails(Request $request)
        {
            $this->validate($request, [
                'deal_id' => 'required|exists:deals,id',
                'mobile'  => 'required|exists:clients,mobile',
            ]);

            $client = Client::mobile($request->mobile);
            $deal = Deal::with(
                [
//                    'store' => function ($query) {
//                        $query->select(
//                            [
//                                'id',
//                            ]
//                        );
//                    },
                    'store',
                ]
            )
                ->find($request->deal_id);

            $dealTemp = $client->getUsage($deal);
            $deal->usage = $dealTemp;

            return $deal;
        }

    }
