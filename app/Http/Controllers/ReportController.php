<?php

    namespace App\Http\Controllers;

    use App\Client;
    use Illuminate\Http\Request;

    class ReportController extends Controller
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

        public function bookletReports(Request $request)
        {
            $client = Client::mobile($request->mobile);
            if (is_null($client)) {
                $client = Client::first();
            }
            return view('admin.report.codes', compact(['client']));
        }
    }