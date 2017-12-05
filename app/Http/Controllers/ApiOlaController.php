<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ApiOlaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function olaindex(Request $request)
    {

        $accessToken = $request->access_token;

        return response()->json([
            "access_token" => $accessToken
        ]);
    }
}
