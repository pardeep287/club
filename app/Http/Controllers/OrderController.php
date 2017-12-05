<?php

    namespace App\Http\Controllers;

    use App\CCTransaction;
    use App\Client;
    use App\ClientCode;
    use App\Deal;
    use App\Order;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class OrderController extends Controller
    {

        public function __construct()
        {
            ini_set('memory_limit', '256M');
        }


        public function redeem_deal(Request $request)
        {

            $this->validate($request, [
                'mobile'      => 'required|exists:clients,mobile',
                // 'client_id' => "required|exists:clients,id",
                'deal_id'     => "required|exists:deals,id",
                'redeem_mode' => "required",
                'master_pass' => "required_if:redeem_mode,offline",
            ]);

            $client = Client::mobile($request->input('mobile'));
            $deal = Deal::find($request->input('deal_id'));

            $redeem_mode = $request->input('redeem_mode');
            $master_pass = $request->input('master_pass');

            if ($deal->kind == 'booklet') {
                $this->validate($request, [
                    'client_code_id' => 'required|exists:client_codes,id',
                ]);

                $client_code = ClientCode::find($request->input('client_code_id'));
                $booklet = $client_code->booklet;

                $clientUsable = $client->clientCodes->contains($client_code);
                $dealUsable = $booklet->deals->contains($deal);
            } else {
                $client_code = null;
                $booklet = null;
                $clientUsable = true;
                $dealUsable = true;
            }

            // $res['deal'] = $deal;

            $dealUsage = $client->getUsage($deal, $client_code);


            if ($deal->max_quantity <= $dealUsage['life_time']) {
                $res['lifetime'] = [
                    'status'  => 'failure',
                    'message' => "exceeds max allowed redemptions",
                ];
            } else {
                $res['lifetime'] = [
                    'status'  => 'success',
                    'message' => "deal can be used again",
                ];
            }

            if ($deal->max_daily_limit <= $dealUsage['today']) {
                $res['today'] = [
                    'status'  => 'failure',
                    'message' => "exceeds max allowed redemptions today.",
                ];
            } else {
                $res['today'] = [
                    'status'  => 'success',
                    'message' => 'deal can be used today',
                ];
            }

            $remarks = $request->input('remarks');


            if ($deal->redeemMode === 'offline') {
                // Store handles payment
                $order = Order::place_order($client, $deal, $redeem_mode, $booklet, $client_code, $remarks . ' Redeem using master password');
                $res['redemption'] = $deal->redeemUsingMasterPass($master_pass);
                $order->remarks .= ", {$res['lifetime']['message']}, {$res['today']['message']}, {$res['redemption']['message']}";

                $finalStatus = 'failure';

                if (('success' === $res['redemption']['status']) && ($res['redemption']['status'] === $res['lifetime']['status']) && ($res['lifetime']['status'] === $res['today']['status'])) {
                    $finalStatus = 'success';
                }

                if (!($clientUsable && $dealUsable)) {
                    $finalStatus = 'aborted';
                    $order->remarks .= ", the client has some issues with booklet";
                    $order->message = "We have encountered some issue during this deals processing, please check again.";
                }

                $res['code'] = $order->complete_order($finalStatus);
                $order->message = $res['code']['message'];
                $res['order'] = $order->makeHidden('deal', 'client');
                $ccTransaction = new CCTransaction();
            } else {
                // CC Transaction
                $order = Order::place_order($client, $deal, 'online', $booklet, $client_code, $remarks . ' Online Order');
                $note = array();
                $note['deal_order'] = $order;
                $res['order'] = $order->makeHidden(['ccTransaction', 'deal']);

                $price = $deal->finalPrice + $deal->handling_fee;

                $finalStatus = 'initiated';
                if (!($clientUsable && $dealUsable)) {
                    $finalStatus = 'aborted';
                    $order->remarks .= ", the client has some issues with booklet";
                    $order->message = "We have encountered some issue during this deals processing, please check again.";
                }

                $ccTransaction = CCTransaction::create([
                    'client_id'  => $client->id,
                    'user_id'    => 1,
                    'order_type' => 'coupon',
                    'note'       => $note,
                    'amount'     => $price,
                    'status'     => 'pending',
                ]);
                $order->ccTransaction()->associate($ccTransaction);
                $order->save();

                if ($finalStatus == 'aborted') {
                    $ccTransaction->status = 'aborted';
                    $ccTransaction->save();
                }
                $res['ccTransaction'] = $ccTransaction->makeHidden('note')->makeVisible('status');
                // $res['ccTransaction']['status'] = $ccTransaction->status;
                $res['ccTransaction']['currency'] = 'INR';
            }


//            $res['client'] = $client->makeHidden(['booklets', 'transactions']);

            $res['client'] = $client->makeHidden(
                [
                    'booklets',
                    'referred_to',
                    'transactions',
                    'everyReferral',
                    'indirectReferral',
                ]
            );

            if (false && App::environment(['local', 'dev'])) {
                Log::debug('Redeem Deal', [
                    'redeem_mode' => $redeem_mode,
                    'request'     => $request->all(),
                    'response'    => $res,
                ]);
            }

            return $res;
        }
    }
