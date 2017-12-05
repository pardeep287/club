<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class CCTransaction extends Model
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'client_id', 'user_id', 'order_type', 'note', 'amount', 'status',
        ];

        protected $appends = [
            'report', 'cancelMessage',
        ];

        protected $casts = [
            'note' => 'array',
        ];

        //ToDo: Confirm if mutator is required

//    public function getAmountAttribute($value)
//    {
//        return "₹ {$value}/-";
//    }

        public function client()
        {
            return $this->belongsTo(Client::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function order()
        {
            return $this->hasOne(Order::class, 'cc_transaction_id')->withDefault([
                'deal'        => [
                    'title' => "",
                ],
                'redeem_mode' => '',
            ]);
        }

        public function bookletPurchase()
        {
            return $this->hasOne(BookletPurchase::class, 'cc_transaction_id');
        }


        public function getReportAttribute()
        {
            try {
                $response = array();
                $response['type'] = 'success';
                $response['details'] = [
                    'id'       => "-",
                    'title'    => "-",
                    'store'    => "-",
                    'location' => "-",
                ];
                if ($this->order_type === 'booklet') {
                    if (!is_null($this->bookletPurchase)) {
                        $response['code'] = $this->bookletPurchase->code;
                        $response['remarks'] = $this->bookletPurchase->remarks;
                        $response['additional'] = '';
                        $response['type'] = 'success';
                    } else {
                        $response['code'] = 'No Codes Generated';
                        $response['remarks'] = "N/A";
                        $response['type'] = 'danger';
                        $response['additional'] = 'Booklet Order was not placed';
                    }

                    $response['details']['id'] = $this->note['booklet']['id'];
                    $response['details']['title'] = $this->note['booklet']['name'];
                } else {
                    $response['remarks'] = (!is_null($this->order)) ? $this->order->remarks : "N/A";
                    $response['additional'] = (!is_null($this->order->status)) ? "Order Status: {$this->order->status}" : 'Order was not placed';
                    // $response['additional'] = (!is_null($this->order)) ?  "{$this->order->deal->title}, {$response['additional']}" : $response['additional'];
                    $response['code'] = (!is_null($this->order->dealCoupon)) ? $this->order->dealCoupon->code : 'No Codes Generated';
                    $response['type'] = (!is_null($this->order->dealCoupon)) ? 'success' : 'danger';

                    $response['details']['id'] = $this->order->deal->id;
                    $response['details']['title'] = $this->order->deal->title;
                    $response['details']['store'] = $this->order->deal->store->name;
                    $response['details']['location'] = $this->order->deal->store->city->name;

                }
            } catch (\Exception $e) {
                $response['details'] = $e->getMessage();
                $response['additional'] = "Exception in database : {$e->getMessage()},{$e->getLine()}";
                $response['code'] = 'No Codes Generated';
                $response['remarks'] = "N/A";
                $response['type'] = 'danger';
            }

            return $response;
        }

        public function getCancelMessageAttribute()
        {
            return DefaultValue::getValue("transaction_cancel_message", 'Cancel Payment?')['clean'];
        }
    }
