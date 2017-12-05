<?php
    /**
     * Created by PhpStorm.
     * User: Lakshay
     * Date: 05-08-2017
     * Time: 11:38
     */

    namespace App;


    class VideoconSMS
    {
        protected $userName;
        protected $password;
        protected $messageType;
        protected $senderID;
        private $baseURL = 'https://bulksmsapi.videoconsolutions.com/';

        public function __construct()
        {
            $this->userName = env('VIDEOCON_SMS_USERNAME');
            $this->password = env('VIDEOCON_SMS_PASSWORD');
            $this->messageType = env('VIDEOCON_SMS_MESSAGE_TYPE');
            $this->senderID = env('VIDEOCON_SMS_SENDER_ID');
        }

        public function sendBroadcast($recipients, $message, $messageType = 'text')
        {
            $response = [];
            foreach ($recipients as $recipient) {
                $response[ $recipient ] = $this->send($recipient, $message, $messageType);
            }

            return $response;
        }

        public function send($recipient, $message, $messageType = 'text')
        {
            if ($this->senderID && $this->userName && $this->password) {
                $messageToSend = urlencode($message . " Thank you for choosing {$this->senderID}.");
                $params = "?username={$this->userName}"
                    . "&"
                    . "password={$this->password}"
                    . "&"
                    . "messageType={$messageType}"
                    . "&"
                    . "mobile={$recipient}"
                    . "&"
                    . "senderId={$this->senderID}"
                    . "&"
                    . "message={$messageToSend}";

                $requestURL = $this->baseURL . $params;

                $sslInfo = [
                    "ssl" => [
                        "verify_peer"      => false,
                        "verify_peer_name" => false,
                    ],
                ];
                $cxContext = stream_context_create($sslInfo);

                $resp['request'] = $requestURL;

                $resp['response'] = file_get_contents($requestURL, false, $cxContext);

                return $resp;

            } else {
                return [
                    'response' => "INCORRECT Credentials",
                ];
            }
        }


    }