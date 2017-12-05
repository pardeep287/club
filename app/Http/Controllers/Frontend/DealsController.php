<?php

    namespace App\Http\Controllers\Frontend;

    use App\Http\Controllers\Controller;
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


    class DealsController extends Controller {
        private $sorts = ["popular", "new", "price_high_to_low", "price_low_to_high"];

        public function index(Request $request) {
            $sort = $this->sorts[0];

            $deals = DB::table(DB::raw("deals as a"))
                ->groupBy(DB::raw("a.id"))->limit(16);

            if($sort === "popular") {
                $deals = $deals->select(DB::raw("a.*, count(b.id) as orders_count, c.name as city_name"))
                    ->leftJoin(
                        DB::raw("orders as b"),
                        DB::raw("a.id"),
                        "=",
                        DB::raw("b.deal_id"))
                    ->leftJoin(
                        DB::raw("cities as c"),
                        DB::raw("c.id"),
                        "=",
                        DB::raw("a.city_id"))
                    ->whereRaw("b.status = 'success'")
                    ->orderBy("orders_count", "DESC");
            } else {
                $deals = $deals->select(DB::raw("a.*"));
            }

            $deals = collect($deals->get());

            return view("deals.index", compact(["deals"]));
        }

        public function single(Request $request, $id) {
            if(!$id || $id == null) {
                exit("ERROR");
            }

            try {
                $deal = Deal::findOrFail($id);
            } catch(ModelNotFoundException $ex) {
                exit("NOT FOUND");
            }

            return view("deals.single", compact(["deal"]));
        }
    }