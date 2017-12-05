<?php

    namespace App;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    class DealCoupon extends Model
    {
        protected $fillable = [
            'code',
            'deal_id',
            'begin',
            'end',
            'user_id',
            'method',
        ];
        //

        protected $hidden = ['user', 'client'];

        protected $appends = ['client'];

        public function getCreatedByAttribute()
        {
            return $this->user->name;
        }

        public function deal()
        {
            return $this->belongsTo(Deal::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function order()
        {
            return $this->hasOne(Order::class);
        }

        public function getClientAttribute()
        {
            if ($this->order) {
                $c = $this->order->client;
                $c->dated = $this->order->created_at;
            } else {
                $c = new Client([
                    'name'   => 'Not Used',
                    'mobile' => '-',
                    'avatar' => '',
                ]);

                $c->dated = '-';
            }

            return $c;
        }

        public function statusClass()
        {
            switch ($this->status) {
                case 'created':
                    return 'primary';
                case 'purchased':
                    return 'warning';
                case 'active':
                    return 'success';
                default:
                    return 'danger';
            }
        }

        public function scopeExpired($query, $status = ['created', 'paused'])
        {
            $today = Carbon::today();
            $query
                ->where('end', "<", $today->format('Y-m-d'))
                ->whereIn('status', $status);

            return $query;
        }

    }
