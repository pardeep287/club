<?php

    namespace App\Http\Controllers\Api;

    use App\City;
    use App\Deal;
    use App\DefaultValue;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class DealController extends Controller
    {
        public function cityDeals(Request $request)
        {
            $this->validate($request, [
                'city_id' => "required|exists:cities,id",
            ]);

            $deal_count = ($request->has('deal_count')) ? $request->input('deal_count') : DefaultValue::getValue('optimal_deals_count', 10)['clean'];

            $city_object = City::find($request->city_id);
            $city_object->makeHidden(['booklets', 'state']);
            $city = $city_object->toArray();

            $deal_query = Deal::with([
                'store' => function ($query) {
                    $query->select('id', 'name', 'avatar');
                },
            ])
                ->cityDeals($request->city_id)
                ->orderByDesc('updated_at');

            $deals_page = $deal_query->paginate($deal_count);

            $deals = [];

            $dealAttributes = [
                'id',
                'avatar',
                'title',
                'store',
                'description',
                'price',
                'discount_type',
                'discount_value',
                'active',
            ];

            foreach ($deals_page->items() as $item) {
                $d = [];
                foreach ($dealAttributes as $attribute) {
                    $d[ $attribute ] = $item->$attribute;
                }
                $deals[] = $d;
            }

            $safe_deals = $deals_page->toArray();
            $safe_deals['data'] = $deals;

            $city['deals'] = $safe_deals;

//            $city['deals'] = $deals_page;

            return $city;
        }

    }
