<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Country extends Model
    {
        protected $fillable = [
            'name',
            'locale',
            'currency_code',
            'currency_name',
            'mobile_prefix',
            'short_name',
        ];

        protected $hidden = [
            'created_at',
            'updated_at',
            'cities',
        ];

        public function states()
        {
            return $this->hasMany(State::class);
        }

        public function cities()
        {
            return $this->hasManyThrough(City::class, State::class);
        }

        public function setLocaleAttribute($value)
        {
            $this->attributes['locale'] = strtolower($value);
        }

        public function setCurrencyCodeAttribute($value)
        {
            $this->attributes['currency_code'] = strtolower($value);
        }

        public function setCurrencyNameAttribute($value)
        {
            $this->attributes['currency_name'] = strtolower($value);
        }

        public function setMobilePrefixAttribute($value)
        {
            $this->attributes['mobile_prefix'] = strtolower($value);
        }

        public function setShortNameAttribute($value)
        {
            $this->attributes['short_name'] = strtolower($value);
        }

    }
