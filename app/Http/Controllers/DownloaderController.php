<?php

    namespace App\Http\Controllers;

    use App\Client;
    use App\DefaultValue;
    use App\Mail\OrderProcessed;
    use App\Order;
    use App\Store;
    use App\Deal;
    use App\Category;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Request;
    use Illuminate\Mail\Markdown;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\DB;


    class DownloaderController extends Controller {
        public function index(Request $request, $refCode='8196081960', $username=null) {
            if(!$username)
            {
                $username = $refCode;
            }

            return view('downloader', compact(["refCode", "username"]));
        }
    }