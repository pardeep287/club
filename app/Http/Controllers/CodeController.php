<?php

    namespace App\Http\Controllers;

    use App\Booklet;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class CodeController extends Controller
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

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Booklet $booklet)
        {
            return view('admin.code.index', compact(['booklet']));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create(Request $request, Booklet $booklet)
        {

            $this->validate($request, [
                'quantity' => 'required|integer|min:1',
                'method'   => 'required',
                'length'   => 'required_if:method,random|integer|min:3',
                'value'    => 'required',
                'validity' => 'required|integer|min:1',
            ]);

            $booklet->create_codes($request->quantity, $request->input('method'), $request->length, $request->value, $request->validity);

            return redirect()->route('code', $booklet->id)->with(
                [
                    'message' => "$request->quantity codes have been created for this booklet",
                ]
            );
        }

        public function expiry(Request $request, Booklet $booklet)
        {
            $this->validate($request, [
                "handle" => "required",
                "days"   => "required_if:handle,extend",
            ]);

            $today = Carbon::today();

            $code_status = ['created'];

            if ($request->has('include-paused')) {
                $code_status[] = 'paused';
            }


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

            $affected = $booklet->codes()->expired($code_status)
                ->update($handler);

            return back()->with([
                'message' => "Updated Booklet Codes. {$affected} were affected.",
            ]);

        }
    }