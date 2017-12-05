<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class SubCity extends Model
    {
        protected $fillable = [
            'name',
            'city_id',
        ];

        public function getNameAttribute($value)
        {
            return $value . ', ' . $this->city->name;
        }

        public function city()
        {
            return $this->belongsTo(City::class);
        }

        public function stores()
        {
            return $this->hasMany(Store::class);
        }

        public function deals()
        {
            return $this->hasMany(Deal::class);
        }
    }
