<?php

    use App\City;
    use App\Client;
    use App\Deal;
    use App\DefaultValue;


    function route_equals($route_1, $route_2)
    {
        return ((strpos(route($route_1), $route_2) !== false) || (strpos($route_2, $route_1) !== false));
    }

    function current_route_equals($route)
    {
        return route_equals($route, Request::path());
    }

    function authority_match($required)
    {
        switch ($required) {
            case 'admin':
                return auth()->user()->is_admin();

            case 'care':
                return auth()->user()->is_care();

            case 'executive':
            case 'auth':
                return auth()->user()->is_executive();

            default:
                return true;
        }
    }

    /**
     * Home Deals
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    function home_deals(Illuminate\Http\Request $request)
    {
        $client = Client::mobile($request->mobile);
        $city = City::find($request->city_id);

//        $maxHomeDeals = DefaultValue::getValue('max_home_deals', 16)['clean'];

        if (is_null($city)) {
            $city = City::first();
        }
        $maxHomeDeals = $city->stores()->where('active', 1)->count();

        $candidateDeals = $city->fnHomeDeals();

        if (!is_null($client)) {
            $city->deals = filter_deals($candidateDeals, $client, $maxHomeDeals);
        } else {
            $city->deals = $candidateDeals;
        }

        $city->totalDeals = $city->deals->count();
        $city->totalStores = $city->stores()->count();

        return $city;
    }

    /**
     * Returns deals for a specific client based on their usage.
     * @param $deals_to_filter
     * @param $client
     * @param $maxDeals
     * @param $confirmOnly
     * @return \Illuminate\Support\Collection
     */
    function filter_deals($deals_to_filter, Client $client, $maxDeals = 16, $confirmOnly = false)
    {
        $deals = [];


        $selectedDeals = $deals_to_filter->pluck('id');

        foreach ($deals_to_filter as $deal) {
            $confirmedDeal = confirmDeal($deal, $client, $selectedDeals, $confirmOnly);
            if ($confirmedDeal) {
                $deals[] = $confirmedDeal;
            }

            if (count($deals) >= $maxDeals) {
                break;
            }
        }

        return collect($deals);
    }

    /**
     * Confirms if Deal should be displayed
     * @param Deal $deal
     * @param Client $client
     * @param $selectedDeals
     * @param bool $confirmOnly
     * @return Deal|null
     */
    function confirmDeal(Deal $deal, Client $client, $selectedDeals, $confirmOnly = false)
    {
        $selectedDeals[] = $deal->id;

        $dealTemp = $client->getUsage($deal);
        $deal->usage = $dealTemp;

        $finalDeal = null;

        if (($dealTemp['today'] < $deal->max_daily_limit) && ($dealTemp['life_time'] < $deal->max_quantity) && $deal->usable) {
            $deal->dealEndsIn = $deal->daysLeft;
            $deal->load('store');
            $deal->load('categories');
            $deal->load('sub_categories');

            $finalDeal = $deal;

        } else if (!$confirmOnly) {
            $newDeal = Deal::where('store_id', $deal->store_id)
                ->cityDeals($deal->city_id)
                ->whereNotIn('id', $selectedDeals)
                ->inRandomOrder()
                ->first();

            if ($newDeal) {
                $selectedDeals[] = $newDeal->id;
                $finalDeal = confirmDeal($newDeal, $client, $selectedDeals);
            } else {
                $newDeal = Deal::cityDeals($deal->city_id)
                    ->whereNotIn('id', $selectedDeals)
                    ->whereNotIn('store_id', [$deal->store_id])
                    ->inRandomOrder()
                    ->first();
                if ($newDeal) {
                    $selectedDeals[] = $newDeal->id;
                    $finalDeal = confirmDeal($newDeal, $client, $selectedDeals);
                }
            }
        }

        return $finalDeal;
    }

    /**
     * Return a random string of given length
     * @param int $length
     * @return string
     */
    function random_password($length = 5)
    {
        $chars = "ABCDEFGHIJKLMNPQRSTUVWXYZ23456789";
        $password = substr(str_shuffle($chars), 0, $length);

        return $password;
    }
