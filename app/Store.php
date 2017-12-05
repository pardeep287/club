<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Store extends Model
    {
        public static $avatar_path = '/uploads/avatars/stores/';
        public static $memeber_silver = 'silver';
        public static $memeber_gold = 'gold';
        public static $memeber_platinum = 'platinum';
        public static $memeber_diamond = 'diamond';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name',
            'address',
            'avatar',
            'city_id',
            'sub_city_id',
            'address_1',
            'address_2',
            'address_3',
            'pincode',
            'latitude',
            'longitude',
            'active',
            'terms',
            'mobile',
            'top_pick',
            'preferred',
            'trusted',
            'membership',
        ];
        protected $appends = ['completeAvatar'];
        protected $casts = [
            'active'    => 'boolean',
            'top_pick'  => 'boolean',
            'preferred' => 'boolean',
            'trusted'   => 'boolean',
        ];

        public function getMobileAttribute($value)
        {
            return (empty($value)) ? DefaultValue::getValue('jbCare')['clean'] : $value;
        }

        public function getMembershipAttribute($value)
        {
            if (is_null($value)) {
                $value = 'silver';
            }

            return strtolower($value);
        }

        public function setMembershipAttribute($value)
        {
            if (!in_array($value, $this->membershipOptions())) {
                $value = 'silver';
            }

            $this->attributes['membership'] = strtolower($value);
        }

        public function deals()
        {
            return $this->hasMany(Deal::class);
        }

        public function imageAvatar()
        {
            return $this->completeAvatar;
        }


        public function formatted_address()
        {
            return $this->address_1 . '<br>' . $this->address_2 . '<br>' . $this->address_3;
        }

        public function getCompleteAvatarAttribute()
        {
            return Store::$avatar_path . $this->avatar;
        }


        public function categories()
        {
            return $this->belongsToMany(Category::class, 'category_store');
        }

        public function city()
        {
            return $this->belongsTo(City::class);
        }

        public function sub_city()
        {
            return $this->belongsTo(SubCity::class);
        }


        public function membershipOptions()
        {
            return [
                Store::$memeber_silver,
                Store::$memeber_gold,
                Store::$memeber_diamond,
            ];
        }


        public  function scopeTopPicks($query) {
            return $query->where("top_pick", 1);
        }
    }
