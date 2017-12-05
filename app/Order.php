<?php

    namespace App;

    use App\Mail\OrderProcessed;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Log;
    use Mail;


    class Order extends Model
    {
        protected $fillable = [
            'deal_id',
            'client_id',
            'booklet_id',
            'client_code_id',
            'user_id',
            'remarks',
            'status',
            'cc_transaction_id',
            'deal_coupon_id',
            'redeem_mode',
            'pricing_details',
        ];

        protected $casts = [
            'pricing_details' => 'array',
        ];

        protected $appends = [
            'order_title',
            'deal_details',
            'coupon_code',
        ];

        protected $hidden = [
            'pricing_details',
        ];

        public static function place_order(Client $client, Deal $deal, $redeem_mode, Booklet $booklet = null, ClientCode $client_code = null, $remarks = null, User $user = null)
        {
            $order = Order::create(
                [
                    'deal_id'        => $deal->id,
                    'client_id'      => $client->id,
                    'booklet_id'     => (!is_null($booklet)) ? $booklet->id : null,
                    'client_code_id' => (!is_null($client_code)) ? $client_code->id : null,
                    'user_id'        => (!is_null($user)) ? $user->id : null,
                    'remarks'        => $remarks,
                    'status'         => 'pending',
                    'redeem_mode'    => $redeem_mode,
                ]
            );

            $pricing_details = array();

            $pricing_details["deal_title"] = $deal->title;
            $pricing_details["deal_price"] = $deal->price;
            $pricing_details["deal_discount_value"] = $deal->discount_value;
            $pricing_details["deal_discount_type"] = $deal->discount_type;
            $pricing_details["final_price"] = $deal->finalPrice;
            $pricing_details["handling_fee"] = $deal->handling_fee;
            $pricing_details["total_price"] = ($deal->finalPrice + $deal->handling_fee);

            $order->pricing_details = $pricing_details;
            $order->save();

            return $order;
        }

        public function getOrderTitleAttribute()
        {
            $title = $this->deal()->pluck('title')->all();

            return array_shift($title);
        }

        public function deal()
        {
            return $this->belongsTo(Deal::class);
        }

        public function getDealDetailsAttribute()
        {
            if (null === $this->pricing_details || array_key_exists('total_price', $this->pricing_details)) {
                $pricing_details = array();
                $deal = Deal::find($this->deal_id);

                if (is_null($deal)) {
                    return [
                        'deal_title'          => '-',
                        'deal_price'          => '0',
                        'deal_discount_value' => '0',
                        'deal_discount_type'  => '-',
                        'final_price'         => '0',
                        'handling_fee'        => '0',
                        'total_price'         => '0',
                    ];
                }

                $pricing_details['deal_title'] = $deal->title;
                $pricing_details["deal_price"] = $deal->price;
                $pricing_details["deal_discount_value"] = $deal->discount_value;
                $pricing_details["deal_discount_type"] = $deal->discount_type;
                $pricing_details["final_price"] = $deal->finalPrice;
                $pricing_details["handling_fee"] = $deal->handling_fee;
                $pricing_details["total_price"] = ($deal->finalPrice + $deal->handling_fee);

                $this->pricing_details = $pricing_details;
            }

            return $this->pricing_details;
        }

        public function getCouponCodeAttribute()
        {
            if ($this->deal_coupon_id) {
                $code = $this->dealCoupon()->pluck('code')->all();

                return array_shift($code);
            } else {
                return "-";
            }
        }

        public function dealCoupon()
        {
            return $this->belongsTo(DealCoupon::class)->withDefault([
                'code'    => "-",
                'deal_id' => "-",
            ]);
        }

        public function client()
        {
            return $this->belongsTo(Client::class);
        }

        public function booklet()
        {
            return $this->belongsTo(Booklet::class);
        }

        public function clientCode()
        {
            return $this->belongsTo(ClientCode::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function ccTransaction()
        {
            return $this->belongsTo(CCTransaction::class)->withDefault([
                'tracking_id' => '-',
                'status'      => 'aborted',
                'order_type'  => '-',
            ]);
        }

        public function complete_order($status, CCTransaction $ccTransaction = null)
        {
            if ($this->status !== 'pending') {
                return [
                    'status'  => 'failure',
                    'message' => "this order is already completed with status {$this->status}",
                ];
            }

            $this->status = $status;

            if (!is_null($ccTransaction)) {
                $this->cc_transaction_id = $ccTransaction->id;
            } else if ($this->redeem_mode == 'online') {
                $res = [
                    'status'  => 'failure',
                    'message' => 'online Deal Can not be complete without Payment information',
                ];

                return $res;
            }

            if ($status == 'success') {
                if ($this->deal->freshCoupons->count() < 1) {
                    $this->remarks .= ", no coupons left in inventory.";
                    $this->status = 'nocoupons';
                    $this->save();
                    $ccRef = (!is_null($ccTransaction)) ? ", Transaction: {$ccTransaction->id}, track: #{$ccTransaction->tracking_id}  " : "";

                    Log::alert('No Coupons Left', [
                        'deal' => $this->deal->toArray(),
                    ]);

                    return [
                        'status'  => 'failure',
                        'message' => 'this deal has no coupons left' . $ccRef,
                    ];
                }
                $coupon = $this->deal->freshCoupons->random();
                $coupon->status = 'active';
                $coupon->save();
                $this->deal_coupon_id = $coupon->id;
                $res = [
                    'status'  => 'success',
                    'message' => "Use $coupon->code to avail the deal.",
                    'coupon'  => $coupon,
                ];
            } else {
                $res = [
                    'status'  => $status,
                    'message' => "the order is $status",
                ];
            }
            $this->remarks .= '.';

            $this->save();

            try {
                $mail = new OrderProcessed($this);
                $res['mail'] = Mail::to($this->client->email)->send($mail);
                Log::info("Order Processed Mail Sent");
            } catch (\Exception $exception) {
                Log::error("Order Processing Mail NOT Sent", [
                    'message' => $exception->getMessage(),
                    'code'    => $exception->getCode(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                ]);
            }


            return $res;
        }



        // scopes
        public function scopeIsSuccess($query) {
            return $query->where("status", "success");
        }
    }
