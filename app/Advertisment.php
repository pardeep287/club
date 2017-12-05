<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Advertisment extends Model
    {
        public static $avatar_path = '/uploads/avatars/advertisment/';
        protected $fillable = [
            'avatar',
            'active',
            'ord',
            'city_id',
        ];

        public function imageAvatar()
        {
            return Advertisment::$avatar_path . $this->avatar;
        }

        public function defaultAvatar()
        {
            return Advertisment::$avatar_path . 'jbadvert.png';
        }

        public function city()
        {
            return $this->belongsTo(City::class);
        }
    }
