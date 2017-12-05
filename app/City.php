<?php

    namespace App;

    use DB;
    use Illuminate\Database\Eloquent\Model;

    class City extends Model
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'state_id',
        ];

        protected $hidden = [
            'created_at',
            'updated_at',
        ];

        protected $appends = [
            'pincode', 'usableBooklets',
        ];

        public function getNameAttribute($value)
        {
            return $value . ', ' . array_get($this->state->getAttributes(), 'name');
        }

        public function getPincodeAttribute()
        {
            return DefaultValue::getValue("jbPinCode_{$this->state_id}", '144001')['clean'];
        }

        public function clients()
        {
            return $this->hasMany(Client::class);
        }

        public function getUsableBookletsAttribute()
        {
            return $this->booklets->where('usable', true)->values();
        }

        public function deals()
        {
            return $this->hasMany(Deal::class)->with(['categories', 'sub_categories']);
        }

        public function state()
        {
            return $this->belongsTo(State::class);
        }

        public function booklets()
        {
            return $this->hasMany(Booklet::class);
        }

        public function subCities()
        {
            return $this->hasMany(SubCity::class);
        }

        public function stores()
        {
            return $this->hasMany(Store::class);
        }

        public function advertisments()
        {
            return $this->hasMany(Advertisment::class);
        }

        public function fnHomeDeals()
        {


//            $dealsWithEnoughCoupons = DealCoupon::select('deal_id', DB::raw('count(*) as total'))
//                ->where('status', 'created')
//                ->groupBy('deal_id')
//                ->havingRaw("count(*) > {$minCouponCount}")
//                ->pluck('deal_id');

            $candidateDeals = Deal::select(DB::raw('store_id, max(id) as id'))
                ->cityDeals($this->id)
//                ->whereIn('id', $dealsWithEnoughCoupons)
                ->groupBy('store_id')
                ->orderByDesc('id');

            $globalDeals = Deal::select('id')
                ->couponCount()
                ->where('reach', 'global')
                ->whereHas('store', function ($query) {
                    $query->where('active', 1);
                })
                ->pluck('id');

            $cityDeals = $candidateDeals->pluck('id');

            $confirmedDeals = $cityDeals->merge($globalDeals);

            $city_deals = $this->deals()
                ->whereIn('id', $confirmedDeals)
                ->orderByDesc('updated_at')
                ->get();

            return $city_deals;
        }
    }
