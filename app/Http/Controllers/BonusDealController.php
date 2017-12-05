<?php

    namespace App\Http\Controllers;

    use App\BonusDeal;
    use Illuminate\Http\Request;


    class BonusDealController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('care', ['except' => ['index']]);
            $this->middleware('admin', ['only' => ['destroy']]);
        }

        public function index()
        {
            $bonusDeal = BonusDeal::withCount(['bonusDealCodes' => function ($query) {
                $query->where('status', 1);
            }])->get();

            return view('admin.bonusdeal.index', compact(['bonusDeal']));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            echo 'i am here';
            exit;
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
                'title' => "required",
                "type"  => "required",
            ]);

            $bonusDeal = BonusDeal::create([
                'title' => $request->title,
                'type'  => $request->type,
                'term_n_condition'  => $request->term_n_condition,
            ]);

            return redirect()->route('bonusdeal.index')->with(['message' => "Bonus deal added successfully"]);
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
            //
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
            $bonusDeal = BonusDeal::find($request->id);

            $this->validate($request, [
                'title' => "required",
                "type"  => "required",
            ]);

            $bonusDeal->title = $request->title;
            $bonusDeal->type = $request->type;
            $bonusDeal->term_n_condition = $request->term_n_condition;
            $bonusDeal->status = ($request->has('status')) ? 1 : 0;

            $bonusDeal->save();

            return back()->with(['message' => "Bonus deal edited successfully"]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $bonusDeal = BonusDeal::find($id)->first();
            try {

                $bonusDeal->delete();

                return back()->with([
                    'message' => "Bonus deal deleted.",
                ]);
            } catch (\Exception $e) {
                return back()->withErrors([
                    'state' => "Bonus deal can not be deleted.",
                ]);
            }
        }
    }
