<?php

    namespace App\Http\Controllers;

    use App\Booklet;
    use App\CCTransaction;
    use App\Client;
    use App\Mail\PaymentSuccess;
    use App\Order;
    use App\User;
    use Illuminate\Http\Request;
    use Log;
    use Mail;
    use Storage;

    class PaymentController extends Controller
    {
        public function purchaseBooklet(Request $request)
        {
            $booklet = Booklet::find($request->booklet_id);
            $client = Client::mobile($request->mobile);

            if ($client == null) {
                $res['client'] = null;
                $res['request'] = $request->all();
                Log::debug('requested booklet', $res);

                return $res;
            }

            $note = array();
            $note['booklet'] = $booklet;

            // $res['access_code'] = env('CCAVENUE_ACCESS_CODE','');
            // $res['merchant_id'] = env('CCAVENUE_MERCHANT_ID','');

            Log::debug('Booklet Purchases', [
                'booklet' => $booklet,
                'request' => $request->all(),
            ]);

            $ccTransaction = CCTransaction::create([
                'client_id'  => $client->id,
                'user_id'    => 1,
                'order_type' => 'booklet',
                'note'       => $note,
                'amount'     => $booklet->price,
            ]);
            $ccTransaction->currency = "INR";
            $res['ccTransaction'] = $ccTransaction;
            $res['order_id'] = $ccTransaction->id;

            // $res['redirect_url'] = route('cc_response_redirect') ; // "http://122.182.6.216/merchant/ccavResponseHandler.jsp";
            // $res['cancel'] = route('cc_cancel')  ; // "http://122.182.6.216/merchant/ccavResponseHandler.jsp";
            // $res['rsa_key_url'] = route('cc_get_rsa')  ; // 'http://122.182.6.216/merchant/GetRSA.jsp';

            $res['booklet'] = $booklet;
            $res['client'] = $client;
            $res['price'] = $booklet->price;

            Log::debug('requested booklet', [
                'ccTransaction' => $ccTransaction->toArray(),
                'booklet'       => $booklet->toArray(),
            ]);

            return $res;
        }

        public function ccavResponseHandler(Request $request)
        {
            $workingKey = env('CCAVENUE_WORKING_KEY', '');                                                   //Working Key should be provided here.
            $encResponse = $_POST["encResp"];                                                                           //This is the response sent by the CCAvenue Server
            $rcvdString = $this->decrypt($encResponse, $workingKey);                                                    //Crypto Decryption used as per the specified working key.
            $order_status = "";
            $decryptValues = explode('&', $rcvdString);
            $dataSize = sizeof($decryptValues);

            $ccAvenueResponse = array();
            // Log::debug('CC Avenue Response Handler', ['printed' => $decryptValues]);

            for ($i = 0; $i < $dataSize; $i++) {
                $information = explode('=', $decryptValues[ $i ]);

                $ccAvenueResponse[ $information[0] ] = $information[1];
                if ($i == 3) $order_status = $information[1];
            }

            try {

                $ccAvenueTransaction = CCTransaction::find($ccAvenueResponse['order_id']);
                $ccAvenueTransaction->status = strtolower($ccAvenueResponse['order_status']);
                $ccAvenueTransaction->tracking_id = $ccAvenueResponse['tracking_id'];

                $note = $ccAvenueTransaction->note;
                $note['payment'] = $ccAvenueResponse;
                $ccAvenueTransaction->note = $note;

                $ccAvenueTransaction->save();


                $code = '-------';

                try {
                    $client = $ccAvenueTransaction->client;
                    $user = User::find(1);
                    if ($ccAvenueTransaction->order_type == 'booklet') {
                        // Process Booklet
                        $booklet = Booklet::find($ccAvenueTransaction->note['booklet']['id']);

                        $bk['code'] = $code;
                        $message = "";
                        if ($ccAvenueTransaction->status == 'success') {
                            $bk = $booklet->purchaseCode($client, $user, $ccAvenueResponse['tracking_id'], $ccAvenueTransaction);
                            $message = "Your booklet details are as :-";
                        }
                        try {
                            if (isset($bk['code']['code'])) {
                                $code = $bk['code']['code'];
                                $codeMessage = "Booklet Purchase {$bk['msg']}";
                            } else {
                                $code = "-";
                                $codeMessage = "Exception Occurred";
                            }
                        } catch (\Exception $e) {
                            $code = "-";
                            $codeMessage = "Exception Occurred";
                        }

                        Log::debug('CC Avenue Code Booklet', ['booklet' => $booklet, 'code' => $bk]);
                    } else {
                        // Process Deal
                        $deal_order = Order::find($ccAvenueTransaction->note['deal_order']['id']);
                        $response = $deal_order->complete_order($ccAvenueTransaction->status, $ccAvenueTransaction);
                        $dealCoupon = (isset($response['coupon'])) ? $response['coupon'] : null;
                        $code = (!is_null($dealCoupon)) ? $dealCoupon->code : '-------';
                        if ((!is_null($dealCoupon))) {
                            $message = "Your {$dealCoupon->deal->store->name} used coupon details are as :-";
                        } else {
                            $order_status = 'Failure';
                            $message = "We could not process your order, please contact JB Care";
                        }
                        $codeMessage = $response['message'];

                        Log::debug('CC Avenue Code Deal', ['order' => $deal_order, 'code' => $response, 'val' => $code]);
                    }

                    if (($client->name === $client->mobile || empty($client->name)) && !empty($ccAvenueResponse['billing_name'])) {
                        $client->name = $ccAvenueResponse['billing_name'];
                    }

                    if (empty($client->email) && !empty($ccAvenueResponse['billing_email'])) {
                        $client->email = $ccAvenueResponse['billing_email'];
                    }

                    if ((empty($client->address) || $client->address == $client->city->name) && !empty($ccAvenueResponse['billing_address'])) {
                        $client->address = $ccAvenueResponse['billing_address'];
                    }

                    $client->save();
                } catch (\Exception $e) {
                    $message = "Unable to process the request at the moment";
                    $order_status = 'Failure';
                    Log::error('Order Processing Client Updates',
                        [
                            'error' => [
                                'message'    => $e->getMessage(),
                                'error_code' => $e->getCode(),
                                'file'       => $e->getFile(),
                                'line'       => $e->getLine(),
                            ],
                        ]);
                }

                Mail::to($client->email)->send(new PaymentSuccess($ccAvenueTransaction));
            } catch (\Exception $e) {
                $ccAvenueTransaction = new CCTransaction();
                $ccAvenueTransaction->status = 'failure';
                $order_status = 'Failure';
                $message = "Unable to process the request at the moment";

                Log::error('Order Processing order not found in db',
                    [
                        'error'    => [
                            'message'    => $e->getMessage(),
                            'error_code' => $e->getCode(),
                            'file'       => $e->getFile(),
                            'line'       => $e->getLine(),
                        ],
                        'ccAvenue' => $ccAvenueResponse,
                    ]);
            }

            $ccAvenueTransaction->message = $message;

            if ($order_status === "Success") {
                Log::debug('CC Transaction success', [$code]);

                return view('payments.success', ['transaction' => $ccAvenueTransaction]);
            } else if ($order_status === "Aborted") {
                return view('payments.fail', ['transaction' => $ccAvenueTransaction]);
            } else if ($order_status === "Failure") {
                return view('payments.fail', ['transaction' => $ccAvenueTransaction]);
            } else {
                return view('payments.security', ['transaction' => $ccAvenueTransaction]);
            }

        }


        // ************** Encryption and Decryption Tools ***************

        // CC Crypto Direct method

        function decrypt($encryptedText, $key)
        {
            $secretKey = $this->hextobin(md5($key));
            $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
            $encryptedText = $this->hextobin($encryptedText);
            $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
            mcrypt_generic_init($openMode, $secretKey, $initVector);
            $decryptedText = mdecrypt_generic($openMode, $encryptedText);
            $decryptedText = rtrim($decryptedText, "\0");
            mcrypt_generic_deinit($openMode);

            return $decryptedText;
        }

        function hextobin($hexString)
        {
            $length = strlen($hexString);
            $binString = "";
            $count = 0;
            while ($count < $length) {
                $subString = substr($hexString, $count, 2);
                $packedString = pack("H*", $subString);
                if ($count == 0) {
                    $binString = $packedString;
                } else {
                    $binString .= $packedString;
                }

                $count += 2;
            }

            return $binString;
        }

        public function getRSA(Request $request)
        {

            $this->validate($request, [
                'order_id' => 'required|max:30',
            ]);

            $url = "https://secure.ccavenue.com/transaction/getRSAKey";
            // $url = "https://test.ccavenue.com/transaction/getRSAKey";
            $fields = array(
                'access_code' => env('CCAVENUE_ACCESS_CODE', ''),
                'order_id'    => $request->order_id,
            );

            $postvars = '';
            $sep = '';
            foreach ($fields as $key => $value) {
                $postvars .= $sep . urlencode($key) . '=' . urlencode($value);
                $sep = '&';
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_CAINFO, Storage::disk('local')->get('cacert.pem'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);

            Log::debug('Getting RSA for order: #' . $request->order_id, [
                'fields' => $fields,
                'result' => $result,
            ]);

            return $result;
        }


        //*********** Padding Function *********************

        function encrypt($plainText, $key)
        {
            $secretKey = $this->hextobin(md5($key));
            $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
            $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
            $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
            $plainPad = $this->pkcs5_pad($plainText, $blockSize);
            if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) {
                $encryptedText = mcrypt_generic($openMode, $plainPad);
                mcrypt_generic_deinit($openMode);

            }

            return bin2hex($encryptedText);
        }

        //********** Hexadecimal to Binary function for php 4.0 version ********

        function pkcs5_pad($plainText, $blockSize)
        {
            $pad = $blockSize - (strlen($plainText) % $blockSize);

            return $plainText . str_repeat(chr($pad), $pad);
        }
    }