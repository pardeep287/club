<?php

    namespace App\Http\Controllers;

    use App\BonusDealCode;
    use App\BonusDeal;
    use Illuminate\Http\Request;
    use App\Client;

    class ApiBonusDealCodeController extends Controller
    {
        /**
         * API call for validate bonus code.
         *
         */
        public function __construct()
        {
            ini_set('memory_limit', '256M');
        }


        public function validateCode(Request $request)
        {
            $client  = Client::where('mobile', $request->mobile)->first();
            $codest  = BonusDealCode::where('master_code',$request->master_code)->where('used_by',$client->id)->where('status',1)->first();
            if($codest && $codest->redeemed==1)
            {
                $res = ['status' => 'invalid', 'msg' => "Invalid Code."];
            }
            elseif($codest && $codest->redeemed==0)
            {
                $res = ['status' => 'invalid', 'msg' => "Code already redeemed"];

            }
            else{
                $codest = BonusDealCode::where('master_code',$request->master_code)->whereNull('used_by')->where('redeemed',0)->where('status',1)->first();
                if($codest){
                    $bonusdeal = BonusDeal::where('id',$codest->bonuscode_id)->where('status',1)->first();
                    $codest->used_by = $client->id;
                    $codest->save();
                    $res = ['status' => 'valid','code'=>$codest->code ,'msg' => "Code successfully redeemed",'title'=>$bonusdeal->title,'termNcondition'=>$bonusdeal->term_n_condition];
                }else{
                    $res = ['status' => 'invalid', 'msg' => "Invalid Code."];
                }

            }
            return $res;
        }


    }


