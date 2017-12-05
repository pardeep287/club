<?php

    namespace App\Http\Controllers;

    use App\BonusDealCode;
    use Illuminate\Http\Request;

    class BonusDealCodeController extends Controller
    {

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('care', ['except' => ['index']]);
            $this->middleware('admin', ['only' => ['destroy']]);
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index($id)
        {

            $bonusDealCode = BonusDealCode::where('bonuscode_id', $id)->get();

            return view('admin.bonusdealcode.index', compact(['bonusDealCode', 'id']));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {

        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $this->validate($request, [
                'quantity' => 'required|numeric|min:1',
                'length'   => 'required|numeric|min:4',

            ]);

            // $coupons = $deal->generate_coupons(auth()->user(), $request->quantity, $request->length, $request->value);
            $codes = array();

            $value = str_replace(" ", "", $request->value);

            for ($i = 0; $i < $request->quantity; $i++) {
                $codes = new BonusDealCode([
                    'bonuscode_id' => $request->bonuscode_id,
                    'master_code' => $request->master_code,
                    'code'         => strtoupper($value . random_password($request->length)),
                ]);
                $codes->save();
            }


            return back()->with(['message' => "Bonus deal code generated successfully"]);
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {

        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            $bonusCode = BonusDealCode::find($id);
            $bonusCode->redeemed = true;
            $bonusCode->save();

            return back()->with([
                'message' => "{$bonusCode->bonusDeal->title} Redeemed successfully.",
            ]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $bonusdealcode = BonusDealCode::find($id)->first();
            try {

                $bonusdealcode->delete();

                return back()->with([
                    'message' => "Bonus deal code deleted.",
                ]);
            } catch (\Exception $e) {
                return back()->withErrors([
                    'state' => "Bonus deal can not be deleted.",
                ]);
            }
        }





    }
