<?php

    namespace App\Http\Controllers;

    use App\Client;
    use App\DefaultValue;
    use App\Mail\OrderProcessed;
    use App\Order;
    use App\Store;
    use App\Deal;
    use App\Category;
    use Illuminate\Http\Request;
    use Illuminate\Mail\Markdown;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\DB;


    class HomeController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth', ['except' => ['index', 'testMail']]);
        }

        public function testMail(Request $request)
        {
            $id = (isset($request->id)) ? $request->id : 2;

            $markdown = new Markdown(view(), config('mail.markdown'));


//        $tr = CCTransaction::find($id);
//        if($tr){
////            $mail = new PaymentSuccess($tr);
////            $res = Mail::to('lakshayverma.clubjb@gmail.com')->send($mail);
//            return $markdown->render('emails.payments.success',['transaction' => $tr]);
//        }else{
//            return "NOT FOUND";
//        }

            $order = Order::find($id);

            if ($order) {
                $mail = new OrderProcessed($order);
                Mail::to('lakshayverma.clubjb@gmail.com')->send($mail);

                return $markdown->render('emails.orders.processed', ['order' => $order]);
            } else {
                return "NOT FOUND";
            }


            // // $res = Mail::to('lakshayverma.clubjb@gmail.com')->send(new TestMail());

        }

        /**
         * Show the application dashboard.
         *
         * @return \Illuminate\Http\Response
         */
        public function dashboard()
        {
            $stores = Store::all();
            $clients = Client::all();

            // return $stores;
            $minified = true;

            return view('admin.dashboard', compact(['clients', 'stores', 'minified']));
        }

        public function index()
        {
            $freshArrivals = Deal::freshArrivals()->limit(10)->get();
            $storeTopPicks = Store::topPicks()->orderBy(DB::raw("RAND()"))->limit(10)->get();
            $categories = Category::limit(12)->get();
            return view('home', compact(["freshArrivals", "storeTopPicks", "categories"]));
        }


        public function defaults()
        {
            $defaultvalues = DefaultValue::all();

            return view('admin.default.index', compact(['defaultvalues']));
        }

        public function defaults_add(Request $request)
        {
            $this->validate($request, [
                'key'   => 'required|unique:default_values,key',
                'value' => 'required',
            ]);

            DefaultValue::create([
                'key'   => strtolower(str_replace(" ", "_", $request->key)),
                'value' => $request->value,
            ]);

            return back()->with([
                'message' => "Default Value for $request->key created.",
            ]);
        }

        public function defaults_edit(Request $request)
        {
            $defaultvalue = DefaultValue::find($request->id);

            $this->validate($request, [
                'id'    => 'required|exists:default_values,id',
                'key'   => 'required|unique:default_values,key,' . $request->id,
                'value' => 'required',
            ]);

            if ($defaultvalue->id > 8) {
                $defaultvalue->key = strtolower(str_replace(" ", "_", $request->key));
            }

            $defaultvalue->value = $request->value;

            $defaultvalue->save();

            return back()->with([
                'message' => "Default value for {$request->key} updated.",
            ]);
        }
    }