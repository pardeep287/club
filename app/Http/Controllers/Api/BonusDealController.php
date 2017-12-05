<?php

    namespace App\Http\Controllers\Api;

    use App\BonusDeal;
    use App\Client;
    use App\DefaultValue;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class BonusDealController extends Controller
    {
        public function bonusDeals(Request $request)
        {
            $this->validate($request, [
                'type' => "required",
            ]);

            $response['title'] = DefaultValue::getValue("title_bonus_{$request->input('type')}", "Congratulations!!!")['clean'];
            $response['sub_title'] = DefaultValue::getValue("sub_title_bonus_{$request->input('type')}", "Select your {$request->input('type')} deal.")['clean'];
            $response['bonus_deals'] = BonusDeal::type($request->input('type'))->get();

            return $response;
        }

        public function redeem(Request $request)
        {

            $this->validate($request, [
                'bonus_deal_id' => "required|exists:bonus_deals,id",
                "mobile"        => "required|exists:clients,mobile",
            ]);

            $bonusDeal = BonusDeal::find($request->input("bonus_deal_id"));
            $client = Client::mobile($request->input("mobile"));

            return $bonusDeal->redeem($client);
        }
    }
