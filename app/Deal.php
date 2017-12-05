<?php

    namespace App;

    use App\Helpers\Common;
    use Carbon\Carbon;
    use Excel;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Facades\Log;

    class Deal extends Model
    {
        use SoftDeletes;

        public static $avatar_path = '/uploads/avatars/deals/';


        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'title',
            'store_id',
            // 'avatar', // avatar only saved explicitly
            'price',
            'type',
            'begin',
            'end',
            'days',
            'description',
            'terms',
            'club_terms',
            'handling_fee',
            'discount_type',
            'discount_value',
            'kind',
            'city_id',
            'sub_city_id',
            'max_quantity',
            'max_daily_limit',
            'active',
            'call_to',
            'call_to_message',
            'person_limit',
            'coin_use',
            'coin_get',
            'meta_title',
            'meta_description',
            'master_pass_required',
            'master_pass',
            'price_type',
            'reach',
            'redeem_offline',
        ];

        protected $appends = [
            'usable',
            'usableMessage',
            'freshCoupons',
            'finalPrice',
            'discountedPrice',
            'discountMessage',
            'completeAvatar',
            'couponsLeft',
            'daysLeft',
            'daysLeftHuman',
            'redeemMode',
        ];

        protected $hidden = [
            'master_pass',
            'freshCoupons',
            'coupons',
            'redeemMode',
//            'daysLeft',
        ];
        protected $casts = [
            'active'               => 'boolean',
            'begin'                => 'date',
            'end'                  => 'date',
            'master_pass_required' => 'boolean',
        ];
        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = ['deleted_at'];

        public static function fillable_fields()
        {
            return (new Deal())->getFillable();
        }

        public function store()
        {
            return $this->belongsTo(Store::class);
        }

        public function categories()
        {
            return $this->belongsToMany(Category::class, 'category_deal');
        }

        public function sub_categories()
        {
            return $this->belongsToMany(SubCategory::class, 'deal_sub_category');
        }

        public function imageAvatar()
        {
            return $this->completeAvatar;
        }

        public function thumbAvatar()
        {
            $thumbA = Deal::$avatar_path . '/thumb/' . $this->avatar;
            if (file_exists(public_path($thumbA))) {
                return $thumbA;
            }

            return $this->imageAvatar();
        }

        public function getCompleteAvatarAttribute()
        {
            return Deal::$avatar_path . $this->avatar;
        }

        public function getDaysLeftAttribute()
        {
            $today = Carbon::today();

            return $this->end->diffInDays($today);
        }

        public function getDaysLeftHumanAttribute()
        {
            $today = Carbon::today();

            return $this->end->diffForHumans($today, false);
        }

        public function booklet()
        {
            return $this->belongsTo(Booklet::class);
        }

        public function city()
        {
            return $this->belongsTo(City::class);
        }

        public function subcity()
        {
            return $this->belongsTo(SubCity::class);
        }

        public function orders()
        {
            return $this->hasMany(Order::class);
        }

        public function import_coupons(User $user, $excelPath, $validity)
        {
            $today = Carbon::today();
            $ending = Carbon::today()->addDays($validity);

            $coupons = array();

            $excelData = Excel::load($excelPath, function ($reader) {
                $reader->noHeading();
                $reader->ignoreEmpty();
            })->get();

            if (!empty($excelData) && $excelData->count()) {
                foreach ($excelData->toArray() as $code) {
                    if (!empty($code)) {
                        $coupons[] = new DealCoupon([
                            'user_id' => $user->id,
                            'code'    => $code[1],
                            'begin'   => $today,
                            'end'     => $ending,
                            'method'  => 'imported',
                        ]);
                    }
                }
            }

            $chunks = array_chunk($coupons, 50);
            foreach ($chunks as $chunk) {
                $this->coupons()->saveMany($chunk);
            }

            return collect($coupons);
        }

        public function coupons()
        {
            return $this->hasMany(DealCoupon::class);
        }

        public function generate_coupons(User $user, $quantity, $method, $length, $value, $validity)
        {
            $today = Carbon::today();
            $ending = Carbon::today()->addDays($validity);

            if ($ending->gt($this->end)) {
                $ending = $this->end;
            }

            $coupons = array();

            $value = str_replace(" ", "", $value);

            for ($i = 0; $i < $quantity; $i++) {
                $coupons[] = new DealCoupon([
                    'user_id' => $user->id,
                    'code'    => strtoupper($value . $this->get_code($method, $length)),
                    'begin'   => $today,
                    'end'     => $ending,
                    'method'  => 'generated',
                ]);
            }
            $chunks = array_chunk($coupons, 200);
            foreach ($chunks as $chunk) {
                $this->coupons()->saveMany($chunk);
            }

            return collect($coupons);
        }

        public function get_code($method, $length)
        {
            switch ($method) {
                case 'random':
                    return str_random($length);
                    break;

                case 'simple':
                default:
                    return "";
                    break;
            }
        }

        public function getCouponsLeftAttribute()
        {
            return $this->coupons()->where('status', 'created')->count();
        }

        public function getUsableAttribute()
        {
            $expired = !$this->isExpired();

            $coupons = $this->inventoryFull();

            return $expired && $coupons && $this->active;
        }

        public function isExpired()
        {
            $today = date('Y-m-d');

            return !($today >= $this->begin->format('Y-m-d') && $today <= $this->end->format('Y-m-d'));
        }

        public function inventoryFull()
        {
            return ($this->couponsLeft > DefaultValue::getValue('minCouponCount', 1000)['clean']);
        }

        public function getUsableMessageAttribute()
        {
            $msg = "";
            if ($this->isExpired()) {
                $msg .= "Deal Expired";
            } else if (!$this->inventoryFull()) {
                $msg .= "No Coupons Left";
            } else if (!$this->active) {
                $msg .= " Deal Inactive";
            } else {
                $msg = "Deal is Usable";
            }

            return $msg;
        }

        public function getFreshCouponsAttribute()
        {
            return $this->coupons()->where('status', 'created')->get();
        }

        public function getDiscountedPriceAttribute()
        {
            if ($this->discount_type === 'percentage') {
                $discount = ($this->price * $this->discount_value) / 100;
            } else {
                $discount = $this->discount_value;
            }

            if ($discount >= $this->price) {
                $discount = $discount - 1;
            }

            return $discount;
        }

        public function getDiscountMessageAttribute()
        {
            $discount = "";
            if ($this->discount_type === 'percentage') {
                $messagePrefix = DefaultValue::getValue('dcPercentPre', 'Save ')['clean'];
                $messageSuffix = DefaultValue::getValue('dcPercentSuff', '%')['clean'];
                $discount = $messagePrefix . $this->discount_value . $messageSuffix;
            } else {
                $messagePrefix = DefaultValue::getValue('dcDirectPre', 'Save ₹ ')['clean'];
                $messageSuffix = DefaultValue::getValue('dcDirectSuff', '/-')['clean'];
                $discount = $messagePrefix . $this->discount_value . $messageSuffix;
            }

            return $discount;
        }

        public function getFinalPriceAttribute()
        {
            if ($this->price == 0) {
                $price = 0;
            } else {
                $price = $this->price - $this->discountedPrice;
            }

            if ($price < 0) {
                $price = 0;
            }

            return $price;
        }

        public function getRedeemModeAttribute()
        {
            return ($this->master_pass_required) ? 'offline' : 'online';
        }

        public function redeemUsingMasterPass($masterPass)
        {
            $today = date('Y-m-d');
            if (!($this->usable)) {
                Log::debug('Redeem Using Master Pass', [
                    'today'   => $today,
                    'begin'   => $today >= $this->begin->format('Y-m-d'),
                    'begin_d' => $this->begin,
                    'message' => 'deal expired',
                ]);

                return [
                    'status'  => 'failure',
                    'message' => $this->usableMessage,
                ];
            }


            if (!($this->master_pass_required)) {
                return [
                    'status'  => 'failure',
                    'message' => 'deal do not allow store passwords',
                ];
            }

            if (!($this->master_pass === $masterPass)) {
                return [
                    'status'  => 'failure',
                    'message' => 'code incorrect',
                ];
            }

            return [
                'status'  => 'success',
                'message' => 'deal can be used',
            ];
        }

        public function scopeCityDeals($query, $city_id, $kind = 'loose')
        {
            $minCouponCount = DefaultValue::getValue('minCouponCount', 1000)['clean'];

            $query
                ->couponCount($minCouponCount)
                ->whereHas('store', function ($query) {
                    $query->where('active', 1);
                })
                ->where('city_id', $city_id)
                ->where('kind', $kind)
                ->where('active', 1);

            return $query;
        }

        public function scopeCouponCount($query, $count = null, $operator = ">")
        {
            if ($count == null) {
                $count = DefaultValue::getValue('minCouponCount', 1000)['clean'];
            }

            $query->whereHas('coupons', function ($query) {
                $query->where('status', 'created');
            }, $operator, $count);

            return $query;
        }

        public function scopeExpired($query, Carbon $expiringOn = null, $operator = "<")
        {
            if (is_null($expiringOn)) {
                $expiringOn = Carbon::today();
            }
            $query
                ->where('end', $operator, $expiringOn->format('Y-m-d'));


            return $query;
        }


        public function button_class()
        {
            switch ($this->status()) {
                case 'future':
                    return "default";
                case 'expired':
                    return "danger";
                case 'use':
                    return 'primary';
                default:
                    return "warning";
            }
        }

        public function status()
        {
            $today = date('Y-m-d');
            if ($today >= $this->begin && $today <= $this->end) {
                return "use";
            } else {
                if ($this->begin >= $today) {
                    return "future";
                }

                return "expired";
            }
        }


        public function discountPrice() {
            return Common::calculateDiscount($this->discount_type, $this->discount_value, $this->price);
        }

        //scopes
        public function scopeIsActive($query) {
            return $query->where("active", 1);
        }


        public function scopeFreshArrivals($query) {
            $today = date("Y-m-d");
            return $query->where("begin", "<=", $today)->where("end", ">=", $today)->isActive()->orderBy("id", "DESC");
        }

    }
