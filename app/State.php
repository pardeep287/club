<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class State extends Model
    {

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'country_id',
        ];

        protected $hidden = [
            'created_at',
            'updated_at',
        ];


        public function getNameAttribute($value)
        {
            return $value . ', ' . $this->country->name;
        }

        public function cities()
        {
            return $this->hasMany(City::class);
        }

        public function country()
        {
            return $this->belongsTo(Country::class);
        }

    }
