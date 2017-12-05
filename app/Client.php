<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Log;

    class Client extends Model
    {
        public static $avatar_path = '/uploads/avatars/clients/';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name',
            'mobile',
            'email',
            'address',
            'avatar',
            'city_id',
            'referral',
            'device_id',
            'client_type',
        ];


        protected $appends = [
            'booklets',
            'transactions',
            'completedOrders',
            'completeAvatar',
            'imageDimension',
            'everyReferral',
            'indirectReferral',
            'installKind',
        ];

        protected $hidden = [
            'clientCodes',
            'codes',
            'transactions',
            'completedOrders',
            'orders',
            'created_at',
            'updated_at',
            'installKind',
        ];

        public static function defaultAvatar()
        {
            return Client::$avatar_path . 'jbclient.png';
        }

        public static function mobile($mobile)
        {
            $client = Client::with('city')->with(['bonusCoupons.bonusDeal'])->withCount(['devices'])->where('mobile', $mobile)->first();

            return $client;
        }

        public static function findOrCreate($mobile, $deviceID, City $city = null)
        {
            if ($city == null) {
                $city = City::first();
            }

            $client = Client::where('mobile', $mobile)->first();
            if (!$client) {
                $client = Client::create(
                    [
                        'mobile'    => $mobile,
                        'name'      => $mobile,
                        'city_id'   => $city->id,
                        'address'   => $city->name,
                        'device_id' => $deviceID,
                    ]
                );
            } else {
                if (!is_null($deviceID)) {
                    $client->device_id = $deviceID;
                    $client->save();
                }
            }

            $client->load('city');

            return $client;
        }

        public function setNameAttribute($value)
        {
            $this->attributes['name'] = ucwords(strtolower($value));
        }

        public function setEmailAttribute($value)
        {
            $this->attributes['email'] = strtolower($value);
        }

        public function getInstallKindAttribute()
        {
            if ($this->device_id) {
                $resultSet = \DB::select("SELECT min(id) AS 'first_install' FROM clients WHERE device_id = ? GROUP BY device_id", [$this->device_id]);

                if ($resultSet) {
                    $first_install = $resultSet[0]->first_install;
                } else {
                    return 'fresh';
                }

                if ($first_install === $this->id) {
                    return "fresh";
                } else {
                    $resultSet2 = \DB::select("SELECT mobile, created_at FROM clients WHERE id = ?", [$first_install]);
                    if ($resultSet2) {
                        $data = $resultSet2[0];

                        return "stale_{$data->mobile}_{$data->created_at}";
                    } else {
                        return "stale_{$first_install}";
                    }
                }
            } else {
                return 'device_id_not_available';
            }

        }

        public function getEveryReferralAttribute()
        {
            return $this->referredTo->count() + $this->indirectReferral;
        }

        public function getIndirectReferralAttribute()
        {
            return $this->referredTo->sum('everyReferral');
        }

        public function getBookletsAttribute()
        {

            $booklets = array();
            foreach ($this->clientCodes as $client_code) {
                $bklt = $client_code->booklet;
                if (!$bklt->is_expired) {
                    $booklets[] = $bklt;
                }
            }

            return collect($booklets);
        }

        public function getTransactionsAttribute()
        {
            $transactions = array();

            foreach ($this->clientCodes as $ccode) {
                $transactions[] = $ccode->transactions;
            }

            return collect($transactions);
        }

        public function getCompleteAvatarAttribute()
        {
            if (isset($this->avatar)) {
                return Client::$avatar_path . $this->avatar;
            } else {
                return Client::$avatar_path . 'jbclient.png';
            }
        }

        public function getImageDimensionAttribute()
        {
            return DefaultValue::getValue('client_imageDimension', '156')['clean'];
        }

        public function imageAvatar()
        {
            return $this->completeAvatar;
        }

        public function formattedAddress()
        {

            return (isset($this->address_1)) ? "{$this->address_1}\n{$this->address_2}\n{$this->address_3}" : $this->address;
        }

        public function bookletPurchases()
        {
            return $this->hasMany(BookletPurchase::class);
        }

        public function city()
        {
            return $this->belongsTo(City::class);
        }

        public function clientCodes()
        {
            return $this->hasMany(ClientCode::class);
        }

        public function referredBy()
        {
            return $this->belongsTo(Client::class, 'referral')
                ->withDefault([
                    'mobile' => '-',
                    'name'   => '-',
                ]);
        }

        public function referredTo()
        {
            return $this->hasMany(Client::class, 'referral');
        }

        public function activate($code)
        {
            if ($code) {
                $this->codes()->attach($code);

                $code->status = 'active';
                $code->save();

                return true;
            } else {
                return false;
            }
        }

        public function codes()
        {
            return $this->belongsToMany(Code::class, 'client_codes')->withTimestamps();
        }

        public function getCompletedOrdersAttribute()
        {
            return $this->orders->where('status', 'success');
        }

        public function getUsage(Deal $deal, ClientCode $client_code = null)
        {
            $today = 0;
            $life_time = 0;
            if (!is_null($client_code)) {
                $today = $this->orders()->where('status', 'success')->whereDate('created_at', date('Y-m-d'))->where('deal_id', $deal->id)->where('client_code_id', $client_code->id)->count();
                $life_time = $this->orders()->where('status', 'success')->where('deal_id', $deal->id)->where('client_code_id', $client_code->id)->count();
            } else {
                $today = $this->orders()->where('status', 'success')->whereDate('created_at', date('Y-m-d'))->where('deal_id', $deal->id)->count();
                $life_time = $this->orders()->where('status', 'success')->where('deal_id', $deal->id)->count();
            }

            return [
                'today'     => $today,
                "life_time" => $life_time,
            ];
        }

        public function orders()
        {
            return $this->hasMany(Order::class);
        }

        public function getOTP()
        {
//            $value = strtoupper(str_random(4));
            $value = random_password(5);
            $otp = $this->oneTimePass;
            if (is_null($otp)) {
                $otp = $this->oneTimePass()->save(new OneTimePass(['otp' => $value]));
            } else {
                $otp->otp = $value;
                $otp->save();
            }

            if ($this->city->state->country->id == 1) {
                $otp->required = DefaultValue::getValue('otp', 0)['clean'];
            } else {
                $otp->required = 0;
            }

            $result = null;

            if ($otp->required) {
                $otp_message = "Your Club JB verification OTP is {$otp->otp}.";
                $this->sendMessage($otp_message);
            } else {
                Log::info("OTP Not sent", [
                    'otp' => $otp->toArray(),
                ]);
            }

            return $otp;
        }

        public function sendMessage($message)
        {
            try {
                $sms = new VideoconSMS();
                $result = $sms->send($this->mobile, $message);
                Log::info('Message Sending', ['client' => ["id" => $this->id, "mobile" => $this->mobile], 'message' => $message, 'result' => $result]);

                return [
                    'status'  => 'success',
                    'message' => "Sent {$message}",
                    'result'  => $result,
                ];

            } catch (\Exception $e) {
                $addOns = ['message' => $message,
                           'result'  => [
                               'message' => $e->getMessage(),
                               'line'    => $e->getLine(),
                               'file'    => $e->getFile(),
                               'trace'   => $e->getTraceAsString(),
                           ],
                ];
                Log::error('Message Sending', ['client' => ["id" => $this->id, "mobile" => $this->mobile], $addOns]);

                $addOns['status'] = 'failure';

                return $addOns;
            }
        }

        public function oneTimePass()
        {
            return $this->hasOne(OneTimePass::class);
        }

        public function devices()
        {
            return $this->hasMany(ClientDevice::class);
        }

        public function bonusCoupons()
        {
            return $this->hasMany(BonusDealCode::class, 'used_by', 'id');
        }
    }