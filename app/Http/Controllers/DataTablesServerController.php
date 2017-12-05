<?php

    namespace App\Http\Controllers;

    use App\BonusDeal;
    use App\Booklet;
    use App\BookletPurchase;
    use App\CCTransaction;
    use App\Client;
    use App\Deal;
    use App\DealCoupon;
    use App\DefaultValue;
    use App\Order;
    use App\Store;
    use Datatables;
    use Illuminate\Http\Request;
    use Log;

    class DataTablesServerController extends Controller
    {

        public function __construct()
        {
            ini_set('memory_limit', '256M');
        }

        public function getIndex()
        {
            return view('admin.report.transaction.payment', ['datatableHandled' => true]);
        }

        public function ccData()
        {
            $transactions = CCTransaction::with([
                'client',
                'client.city',
            ]);

            $d = DataTables::eloquent($transactions)
                ->make(true);

            return $d;
        }

        public function clientData()
        {
            $clients = Client::with('city');

            return DataTables::eloquent($clients)
                ->addColumn('total_referrals', function (Client $client) {
                    return $client->everyReferral;
                })
                ->addColumn('referred_by', function (Client $client) {
                    return $client->referredBy->makeHidden(['booklets', 'transactions'])->toArray();
                })
                ->addColumn('created_at', function (Client $client) {
                    return $client->created_at;
                })
                ->make(true);
        }

        public function clientBookletPurchaseData(Client $client)
        {
            $purchases = $client->bookletPurchases()->with(['client', 'user']);

            return DataTables::eloquent($purchases)
                ->make(true);
        }

        public function clientReferralData(Client $client)
        {
            $referrals = $client->referredTo();

            return DataTables::eloquent($referrals)
                ->addColumn('city', function (Client $client) {
                    return $client->city->toArray();
                })
                ->addColumn('total_referrals', function (Client $client) {
                    return $client->everyReferral;
                })
                ->addColumn('created_at', function (Client $client) {
                    return $client->created_at;
                })
                ->make(true);
        }

        public function storeData()
        {
            $stores = Store::with(['city', 'categories']);

            return DataTables::eloquent($stores)->make(true);
        }

        public function bookletCodeData(Booklet $booklet)
        {
            $codes = $booklet->codes();

            return DataTables::eloquent($codes)->make(true);
        }

        public function dealCouponData(Deal $deal)
        {
            $coupons = $deal->coupons();

            return DataTables::eloquent($coupons)
                ->addColumn('client', function (DealCoupon $dealCoupon) {
                    return $dealCoupon->client->toArray();
                })
                ->make(true);
        }

        public function bookletPurchaseData()
        {
            $bookletPurchases = BookletPurchase::with(['client', 'user']);

            return DataTables::eloquent($bookletPurchases)
                ->make(true);
        }

        public function dealData(Request $request)
        {
            if ($request->input('store_id')) {
                $store = Store::find($request->store_id);
                if ($store) {
                    $deals = $store->deals()->with('store');
                } else {
                    $deals = Deal::with(['store']);
                }
            } else {
                $deals = Deal::with(['store']);
            }

            return DataTables::eloquent($deals)
                ->addColumn('city', function (Deal $deal) {
                    return $deal->store->city->name;
                })
                ->make(true);
        }

        public function dealEndangered()
        {

//            $minCouponCount = DefaultValue::getValue('minCouponCount', 1000)['clean'];

//            $deals = Deal::with(['store'])
//                ->withCount([
//                    'coupons AS fresh_coupons' => function ($query) {
//                        $query->where('status', 'created');
//                    },
//                ])
//                ->orderByDesc('fresh_coupons_count')
//                ->having('fresh_coupons_count', "<=", $minCouponCount);

            $deals = Deal::with(['store'])->couponCount(null, '<=');

            return DataTables::eloquent($deals)
                ->addColumn('city', function (Deal $deal) {
                    return $deal->store->city->name;
                })
                ->make(true);
        }

        public function storeReportData(Store $store)
        {
            $orders = Order::with(['client', 'deal'])->whereIn('deal_id', $store->deals->pluck('id'));

            return $this->orderData($orders);
        }

        public function orderData($orders)
        {
            return DataTables::eloquent($orders)
                ->addColumn('deal_id', function (Order $order) {
                    return $order->deal->id;
                })
                ->addColumn('deal_code', function (Order $order) {
                    if ($order->status === 'success') {
                        $cpn = $order->dealCoupon->code;
                    } else {
                        $cpn = "-";
                    }

                    return $cpn;
                })
                ->addColumn('deal_title', function (Order $order) {
                    return $order->deal->title;
                })
                ->addColumn('client_name', function (Order $order) {
                    return $order->client->name;
                })
                ->addColumn('client_mobile', function (Order $order) {
                    return $order->client->mobile;
                })
                ->make(true);
        }

        public function dealReportData(Deal $deal)
        {
            $orders = Order::with(['client', 'deal'])->where('deal_id', $deal->id);

            return $this->orderData($orders);
        }

        public function bonusDealCouponsData(Request $request, BonusDeal $bonusDeal)
        {
            $coupons = $bonusDeal->bonusDealCodes()->with(['bonusDeal', 'usedBy']);

            return DataTables::eloquent($coupons)
                ->make(true);
        }
    }
