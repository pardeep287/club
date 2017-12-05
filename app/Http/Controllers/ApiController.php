<?php

    namespace App\Http\Controllers;

    use App\Advertisment;
    use App\Category;
    use App\City;
    use App\DefaultValue;
    use App\Store;
    use App\SubCategory;
    use Illuminate\Http\Request;


    class ApiController extends Controller
    {

        public function adverts(Request $request)
        {
            $res = [];
            $advertisingLimit = DefaultValue::getValue('advertising_limit', 10)['clean'];
            if ($request->has('city_id')) {
                $this->validate($request, [
                    'city_id' => 'exists:cities,id',
                ]);
                $adverts = Advertisment::where('city_id', $request->city_id)
                    ->where('active', '1')->inRandomOrder()
                    ->limit($advertisingLimit)->get();
            } else {
                $adverts = Advertisment::where('active', '1')->inRandomOrder()->limit($advertisingLimit)->get();
            }

            $res['advertising_delay'] = DefaultValue::getValue('advertising_delay', 7);
            $res['advertising'] = $adverts;

            return $res;
        }

        public function topPickedStores(Request $request)
        {
            $this->validate($request, [
                'city_id' => 'required|exists:cities,id',
            ]);

            $city_id = $request->input("city_id");


            $queryForTopStores = Store::where('city_id', $city_id)
                ->where('active', 1)
                ->where('top_pick', 1)
                ->whereHas('deals', function ($query) use ($city_id) {
                    $query->cityDeals($city_id);

                }, ">", 0);


            $stores = $queryForTopStores
                ->get();

            return $stores;
        }

        public function storeDetails(Store $store)
        {
            return $store;
        }

        public function store_details(Request $request)
        {
            $this->validate($request, [
                'id' => 'required|exists:stores,id',
            ]);
            $store = Store::find($request->id);
            $store->load('categories');

            return $store;
        }

        public function category_details(Request $request)
        {
            $this->validate($request, [
                'id' => 'required|exists:categories,id',
            ]);
            $category = Category::with('subcategories')->find($request->id);

            return $category;
        }

        public function subcategories(Request $request)
        {
            $this->validate($request, [
                'id' => 'required|exists:categories,id',
            ]);

            $subcategories = SubCategory::with('category')->whereIn('category_id', $request->id)->get();

            return $subcategories;

        }

        public function categories()
        {
            return [
                'categories' => Category::with('subcategories')->get(),
            ];
        }

        public function jbCare()
        {
            return DefaultValue::jbCare();
        }

        public function jbCareCity(City $city)
        {
            return DefaultValue::jbCareCity($city);
        }

        public function about()
        {
            return DefaultValue::jbAbout();
        }

        public function getValue($value)
        {
            return DefaultValue::getValue($value);
        }

        public function getUpdate()
        {
            return [
                'currentversion' => DefaultValue::getValue('currentversion', 1)['clean'],
                'forcedupdate'   => DefaultValue::getValue('forcedupdate', 0)['clean'],
                'updatemessage'  => DefaultValue::getValue('updatemessage', "A new version is available")['clean'],
            ];
        }
    }
