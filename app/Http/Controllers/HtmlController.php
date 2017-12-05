<?php

    namespace App\Http\Controllers;

    use App\Booklet;
    use App\Client;
    use Illuminate\Http\Request;

    class HtmlController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            // $this->middleware('auth',['except'=>['booklet']]);
            // $this->middleware('admin', ['only' => []]);
        }

        public function booklet(Request $request)
        {
            $this->validate($request, [
                'id'            => 'required|exists:booklets,id',
                'client_mobile' => 'required|exists:clients,mobile',
            ]);

            $booklet = Booklet::find($request->id);
            $client = Client::mobile($request->mobile);

            return view('layouts.table', [
                'rows'    => $booklet->deals,
                'columns' => ['id', 'title', 'price', 'end', 'description', 'terms', 'club_terms',],
            ]);
        }

        public function orders(Request $request)
        {
            $this->validate($request, [
                'mobile'    => 'required|exists:clients,mobile',
                'device_id' => 'required|exists:clients,device_id',
            ]);

            $client = Client::mobile($request->mobile);

            if ($client->device_id === $request->device_id) {

                if ($request->has('data_format') && $request->input('data_format') == 'json') {
                    $orders = $client->orders()->orderByDesc('id')->get();

                    $orders->each(
                        function ($item) {
                            if (!$item->pricing_details) {
                                $item->deal_details;
                                $item->save();
                            }
                        }
                    );

                    return $orders;
                } else {
                    return view('layouts.table', [
                        'rows'            => $client->orders()->orderByDesc('id')->get(),
                        'columns'         => [
                            'id', 'redeem_mode', 'status', 'remarks', 'created_at', 'updated_at',
                        ],
                        'special_columns' => [
                            'deal'       => ['title'],
                            'dealCoupon' => ['code'],
                        ],
                    ]);
                }
            } else {
                if ($request->has('data_format') && $request->input('data_format') == 'json') {
                    return [
                        "msg" => 'not allowed',
                    ];
                } else {
                    return "<h1> NOT ALLOWED</h1>";
                }
            }
        }

    }
