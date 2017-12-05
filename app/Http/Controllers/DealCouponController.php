<?php

    namespace App\Http\Controllers;

    use App\Deal;
    use Illuminate\Http\Request;

    class DealCouponController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('admin', ['only' => ['index', 'add']]);
        }

        public function index(Request $request)
        {
            $this->validate($request, [
                'id' => 'required|exists:deals,id',
            ]);
            $deal = Deal::find($request->id);
            $coupons = $deal->coupons()->paginate(100);

            return view('admin.deal.coupons.index', compact(['deal', 'coupons']));
        }

        public function add(Request $request)
        {
            $this->validate($request, [
                'deal'      => 'required|exists:deals,id',
                'quantity'  => 'required|numeric|min:1',
                'mechanism' => 'required',
                'method'    => 'required_if:mechanism,generate',
                'excel'     => 'required_if:mechanism,import',
                'length'    => 'required_if:mechanism,generate|numeric|min:0',
                'value'     => 'required_if:mechanism,generate|min:3',
                'validity'  => 'required|numeric|min:1',
            ]);

            $deal = Deal::find($request->deal);

            if ($request->mechanism == 'generate') {
                $coupons = $deal->generate_coupons(auth()->user(), $request->quantity, $request->input('method'), $request->length, $request->value, $request->validity);
            } else {
                // Handle excel sheet
                if ($request->hasFile('excel')) {
                    $excelPath = $request->file('excel')->getRealPath();
                    $coupons = $deal->import_coupons(auth()->user(), $excelPath, $request->validity);
                }
            }

            return back()->with(
                [
                    'message' => "{$coupons->count()} coupons added to this deal.",
                ]
            );
        }

    }