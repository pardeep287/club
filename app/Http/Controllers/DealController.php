<?php

    namespace App\Http\Controllers;

    use App\Deal;
    use App\DealCoupon;
    use App\DefaultValue;
    use App\Http\Requests\DealRequest;
    use App\Store;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Image;

    class DealController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('admin', ['only' => ['create', 'edit_deal', 'add', 'edit']]);
            $this->middleware('care', ['only' => ['report', 'redeem']]);
        }

        public function index()
        {
            $deals = Deal::all();
            $stores = Store::all();
            $selected_store = 0;

            return view('admin.deal.index', compact(['deals', 'stores', 'selected_store']));
        }

        public function valid($date = null)
        {
            $stores = Store::all();
            $selected_store = 0;
            $deals = Deal::deals($date);

            return view('admin.deal.index', compact(['deals', 'stores', 'selected_store']));
        }

        public function query_store(Request $request)
        {
            $this->validate($request, [
                'id' => 'exists:stores,id',
            ]);
            $store = Store::find($request->id);

            return $this->for_store($store);
        }

        public function for_store(Store $store)
        {
            $stores = Store::all();
            $deals = $store->deals;
            $selected_store = $store->id;

            return view('admin.deal.index', compact(['deals', 'stores', 'selected_store', 'store']));
        }

        public function create(Request $request)
        {
            $deal = null;

            if ($request->has('copy')) {
                $deal = Deal::find($request->input('copy'));
                if ($deal) {
                    $store = $deal->store;
                    $deal->id = null;
                }
            }

            if (!$deal) {
                $deal = new Deal();
                $store = Store::find(1);

                $deal->fill([
                    'call_to'              => DefaultValue::getValue("jbcare")['clean'],
                    'handling_fee'         => 0,
                    'price'                => 0,
                    'discount_type'        => 'direct',
                    'discount_value'       => 0,
                    'kind'                 => 'loose',
                    'call_to_message'      => DefaultValue::getValue('deal_call_to_message', "Call or Visit store to redeem.")['value'],
                    'description'          => DefaultValue::getValue('dealTerms', 'Deal Terms')['value'],
                    'coin_get'             => 10,
                    'coin_use'             => 10,
                    'max_quantity'         => 1,
                    'days'                 => 0,
                    'max_daily_limit'      => 1,
                    'club_terms'           => DefaultValue::getValue('jbTerms', 'Club JB Terms')['value'],
                    'person_limit'         => 2,
                    'master_pass_required' => "0",
                    'master_pass'          => str_random(8),
                    'meta_title'           => DefaultValue::getValue('deal_meta_title', 'Club JB Deal')['clean'],
                    'meta_description'     => DefaultValue::getValue('deal_meta_description', 'Club JB offers the best deals in town')['value'],
                    'begin'                => Carbon::today(),
                    'end'                  => Carbon::today()->addMonth(3),
                    'price_type'           => 'coupon_price',
                    'reach'                => 'city',
                ]);
            }
            $form_type = 'post';
            $form_route = 'deal_add';

            return view('admin.deal.form', compact(['deal', 'form_type', 'form_route', 'store']));
        }

        public function view(Request $request)
        {
            $this->validate($request, [
                'deal' => "required|exists:deals,id",
            ]);
            $deal = Deal::find($request->deal);

            return view('admin.deal.view', compact(['deal']));
        }

        public function edit_deal(Request $request)
        {
            $this->validate($request, [
                'id' => 'required|exists:deals',
            ]);
            $deal = Deal::find($request->id);
            $store = $deal->store;
            $form_type = 'patch';
            $form_route = 'deal_edit';

            return view('admin.deal.form', compact(['deal', 'form_type', 'form_route', 'store']));
        }

        public function add(DealRequest $request)
        {
            if (auth()->user()) {
                $user = auth()->user()->toArray();
            } else {
                $user = [
                    'unauthenticated user',
                ];
            }
            Log::alert("Add Deal", [
                'request' => $request->all(),
                'user'    => $user,
            ]);
            $store = Store::find($request->store_id);
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(720, 400)->save(public_path(Deal::$avatar_path . $filename), 100);
                Image::make($avatar)->resize(360, 200)->save(public_path(Deal::$avatar_path . 'thumb/' . $filename), 20);
            } else {
                $filename = "jbdeal.png";
            }

            $filled = ($request->only(Deal::fillable_fields()));
            $deal = $store->deals()->create($filled);

            $deal->avatar = $filename;
            $deal->save();
            $deal->categories()->sync($request->categories);
            $deal->sub_categories()->sync($request->subcategories);

            return back()->with([
                'message' => "Deal Created Successfully.",
            ]);
        }

        public function edit(DealRequest $request)
        {
            if (auth()->user()) {
                $user = auth()->user()->toArray();
            } else {
                $user = [
                    'unauthenticated user',
                ];
            }
            Log::alert("Edit Deal", [
                'request' => $request->all(),
                'user'    => $user,
            ]);

            $deal = Deal::find($request->id);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(720, 400)->save(public_path(Deal::$avatar_path . $filename), 100);
                Image::make($avatar)->resize(360, 200)->save(public_path(Deal::$avatar_path . 'thumb/' . $filename), 20);

            } else {
                $filename = $deal->avatar;
            }

            $filled = ($request->only(Deal::fillable_fields()));

            $deal->fill($filled);
            $deal->avatar = $filename;

            $deal->save();

            $deal->categories()->sync($request->categories);
            $deal->sub_categories()->sync($request->subcategories);

            return back()->with([
                'message' => "Deal edited.",
            ]);
        }

        public function report(Request $request)
        {
            $this->validate($request, [
                'id' => 'exists:deals,id',
            ]);
            $deal = Deal::find($request->id);

            return view('admin.deal.report', compact(['deal']));
        }

        public function redeem(Request $request)
        {

            if ($request->has('dealCouponID') && strtolower($request->method()) == 'post') {
                $dealCoupon = DealCoupon::find($request->dealCouponID);
                if ($dealCoupon) {
                    $dealCoupon->status = 'active';
                    $dealCoupon->save();
                }
            }

            if ($request->has('coupon')) {
                $dealCoupons = DealCoupon::whereRaw("BINARY `code` = ?", [$request->coupon])->orderByDesc('status')->get();
            }

            return view('admin.deal.redeem', compact(['dealCoupons']));
        }

    }
