<?php

    namespace App\Http\Controllers;

    use App\Advertisment;
    use App\City;
    use App\Client;
    use App\DefaultValue;
    use Illuminate\Http\Request;
    use PDO;

    class ApiTestRoutesController extends Controller
    {
        public function cityClientDeals(Request $request)
        {
            $res = array();
            $this->validate($request, [
                'city_id' => 'required|exists:cities,id',
                'mobile'  => 'required|exists:clients,mobile',
            ]);

            $city = City::find($request->city_id);
            $adverts = Advertisment::where('active', '1')->orderBy('ord')->get();
//            $adverts2 = Advertisment::where('active', '1')->orderBy('ord')->paginate(DefaultValue::getValue('advertsCount', 5)['clean']);

            $client = Client::mobile($request->mobile);

            $deals = array();

            $dealsID = Deal::select(DB::raw('store_id, max(id) as id'))
                ->where('active', 1)
                ->where('kind', 'loose')
                ->groupBy('store_id')
                ->orderByDesc('id');

            $dealIDS = $dealsID
                ->pluck('id');

            $maxHomeDeals = DefaultValue::getValue('max_home_deals', 16)['clean'];

            $city_deals = $city->deals()->whereIn('id', $dealIDS)->latest()->get();

//            $res['dealIDAllowed'] = $dealsID->get();

            $deals = filter_deals($city_deals, $client, $maxHomeDeals);

            $city->deals = $deals;
            $city->totalDeals = $city->deals->count();

            $res['max_deals_allowed'] = $maxHomeDeals;

            $res['city'] = $city;
            $res['advertising_delay'] = DefaultValue::getValue('advertising_delay', 7);

            $res['advertising'] = $adverts;

//            $res['advertising2'] = $adverts2;

            return $res;
        }

        public function customHomeOptimised(Request $request)
        {
            $res = array();
            $this->validate($request, [
                'city_id' => 'required|exists:cities,id',
                'mobile'  => 'required|exists:clients,mobile',
            ]);

            $city = City::find($request->city_id);
            $client = Client::mobile($request->mobile);

            $maxHomeDeals = DefaultValue::getValue('max_home_deals', 16)['clean'];
            $minCouponCount = DefaultValue::getValue('minCouponCount', 1000)['clean'];

            $pdo = \DB::getPdo();
            $statement = $pdo->prepare(
                "SELECT * FROM deal_information"
                . " WHERE"
                . " active = :active"
                . " AND"
                . " city_id = :city"
                . " AND"
                . " kind = :kind"
                . " AND"
                . " couponsLeft >= :couponsLeft"
            );

            $statement->bindValue(':active', "true", PDO::PARAM_STR);
            $statement->bindValue(':city', $city->id, PDO::PARAM_INT);
            $statement->bindValue(':kind', "loose", PDO::PARAM_STR);
            $statement->bindValue(':couponsLeft', $minCouponCount, PDO::PARAM_INT);

            $statement->execute();

//            $city_deals = $statement->fetchAll(PDO::FETCH_CLASS, Deal::class);
            $city_deals = $statement->fetchAll(PDO::FETCH_ASSOC);

            $city->deals = $city_deals;

//            $city->deals = filter_deals($city_deals, $client, $maxHomeDeals);


//            $city->totalDeals = $city->deals->count();
            $city->totalDeals = count($city_deals);

            $city->totalStores = $city->stores()->count();

            $res['city'] = $city;

            $adverts = Advertisment::where('active', '1')->orderBy('ord')->get();
            $res['advertising_delay'] = DefaultValue::getValue('advertising_delay', 7);
            $res['advertising'] = $adverts;

            return $res;
        }

        public function cityDealsPDO(Request $request)
        {
            $res = array();
            $this->validate($request, [
                'city_id' => 'required|exists:cities,id',
                'mobile'  => 'required|exists:clients,mobile',
            ]);

            $city = City::find($request->city_id);
            $client = Client::mobile($request->mobile);

            $maxHomeDeals = DefaultValue::getValue('max_home_deals', 16)['clean'];
            $minCouponCount = DefaultValue::getValue('minCouponCount', 1000)['clean'];

            $pdo = \DB::getPdo();
            $statement = $pdo->prepare("SELECT *, '-' AS master_pass FROM deals WHERE id IN (SELECT deal_id FROM deal_coupons WHERE status = 'created' GROUP BY deal_id HAVING count(*) > :minCoupons) AND city_id = :city_id AND kind = :kind AND active = 1 ORDER BY updated_at LIMIT :maxDeals");

            $statement->bindValue(':minCoupons', $minCouponCount);
            $statement->bindValue(':kind', 'loose');
            $statement->bindValue(':city_id', $city->id);
            $statement->bindValue(':maxDeals', $maxHomeDeals);

            $statement->execute();

            $deals = $statement->fetchAll(PDO::FETCH_ASSOC);
//            $deals = $statement->fetchAll(PDO::FETCH_CLASS, Deal::class);

            $city->deals = collect($deals);
//            $city->deals = Deal::hydrate($deals);

            $city->totalDeals = $city->deals->count();

            $res['city'] = $city;

            $adverts = Advertisment::where('active', '1')->orderBy('ord')->get();
            $res['advertising_delay'] = DefaultValue::getValue('advertising_delay', 7);
            $res['advertising'] = $adverts;

            return $res;
        }
    }
