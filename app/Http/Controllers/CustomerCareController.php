<?php

    namespace App\Http\Controllers;

    use App\Booklet;
    use App\Client;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;


    class CustomerCareController extends Controller
    {

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('admin', ['only' => ['giveBooklets', 'giveBooklets_form']]);
        }

        public function booklet_request()
        {
            return view('admin.care.booklet.purchase');
        }

        public function booklet_purchase_cc(Request $request)
        {
            dd([
                'error'   => "Not Implemented",
                'request' => $request,
            ]);
        }

        public function giveBooklets_form()
        {
            return view('admin.care.booklet.multi');
        }

        public function giveBooklets(Request $request)
        {
            $this->validate($request, [
                'booklet'  => "required|exists:booklets,id",
                'mobile'   => "required|exists:clients,mobile",
                'quantity' => 'required',
            ]);

            $user = auth()->user();
            $booklet = Booklet::find($request->booklet);
            $client = Client::mobile($request->mobile);

            Log::info('REQUESTED New Booklet Codes', [
                'to'        => $request->mobile,
                'authority' => $user->mobile,
                'booklet'   => $booklet,
                'quantity'  => $request->quantity,
            ]);

            $transaction = $request->transaction;

            $bk = array();

            for ($i = 0; $i < $request->quantity; $i++) {
                $purchaseCode = $booklet->purchaseCode($client, $user, $transaction);
                $purchaseCode['col_index'] = ($i + 1);

                $bk[] = $purchaseCode;
            }

            return view('admin.care.booklet.multi', compact(['bk', 'booklet', 'client', 'excelInfo']));
        }

        public function booklet_purchase(Request $request)
        {
            $this->validate($request, [
                'booklet' => "required|exists:booklets,id",
                'mobile'  => "required|exists:clients,mobile",
                'remarks' => 'required'
                // 'transaction_id' => 'required|exists:c_c_transactions,id'
            ]);

            $booklet = Booklet::find($request->booklet);
            $client = Client::mobile($request->mobile);
            $user = auth()->user();
            // $transaction = CCTransaction::find($request->transaction_id);
            $transaction = $request->remarks;

            $bk = $booklet->purchaseCode($client, $user, $transaction);

            if ($bk['msg'] === 'success') {
                $res = [
                    'message'     => "CODE Generated",
                    'booklet'     => $booklet,
                    'code'        => $bk['code'],
                    'transaction' => $bk['transaction'],
                ];

                Log::info('PROVIDED Booklet', $res);

                return back()->with($res);
            } else {
                Log::info('Unable to Give Booklet', [
                    'booklet' => $booklet,
                ]);

                return back()->withErrors(
                    [
                        'coupon' => "No Coupons Left for {$booklet->name}, {$booklet->city->name} cc txn {$transaction}",
                    ]
                );
            }
        }

    }