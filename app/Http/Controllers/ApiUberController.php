<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ApiUberController extends Controller
{
    public function getAccessToken(Request $request)
    {
        $code = $request->code;

        $postData = [
            "client_id" => "DCHYdlJ665jKAnVX9nJGeikNIF2dYAQD",
            "client_secret" =>"ixErZEFcgXjQZsiXy10z6LEajYoTpZd6feV4WTAi",
            "grant_type" =>"authorization_code",
            "redirect_uri" =>"https://dev.clubjb.com/api/uber",
            "code" => $code
        ];

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,"https://login.uber.com/oauth/v2/token");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $verbose = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);

        $output=curl_exec($ch);

        //rewind($verbose);
        //$verboseLog = stream_get_contents($verbose);

        //echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";

        //print_r($output);

        curl_close($ch);

        return response()->json(json_decode($output));
    }
}