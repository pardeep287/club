<?php

    namespace App\Http\Controllers;

    use App\Deal;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class DealExpiryController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('admin');
        }

        public function index(Request $request)
        {
            $deals = Deal::expired()->get();

            return view('admin.deal.expired', compact(['deals']));
        }

        public function handle(Request $request)
        {
            $this->validate($request, [
                "deals" => "required",
                "days"  => "required|integer",
            ]);

            $extended = Carbon::today()->addDays($request->input('days'));

            $deals = Deal::whereIn('id', $request->input('deals'))->update(['end' => $extended->format('Y-m-d')]);

            return back()->with([
                'message' => "{$deals} Deal(s) extended and will now expire on {$extended->format('Y-m-d')}",
            ]);
        }

        public function endangered()
        {
            return view('admin.deal.endangered');
        }

        public function handleEndangered(Request $request)
        {
            $this->validate($request, [
                "deal_id" => "required|exists:deals,id",
                "handle"  => "required",
                "days"    => "required_if:handle,extend",
            ]);

            $deal = Deal::find($request->input('deal_id'));

            $today = Carbon::today();

            if ($request->input('handle') == 'pause') {
                $handler = [
                    'status' => "paused",
                ];
            } else {
                $extended = $today->copy();
                $extended->addDays($request->input('days'));

                $handler = [
                    'end'    => $extended->format('Y-m-d'),
                    "status" => "created",
                ];
            }

            $code_status = ['created'];

            if ($request->has('include-paused')) {
                $code_status[] = 'paused';
            }

            $affected = $deal->coupons()->expired($code_status)
                ->update($handler);

            return back()->with([
                'message' => "Updated Deal Coupons. {$affected} were affected.",
            ]);
        }

    }
