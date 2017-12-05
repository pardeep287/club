<?php

    namespace App;

    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable
    {
        use Notifiable;

        public static $avatar_path = '/uploads/avatars/users/';
        public static $admin = "admin";
        public static $care = "care";
        public static $executive = "executive";


        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'email', 'password', 'auth_level', 'avatar', 'mobile',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];

        public function imageAvatar()
        {
            return User::$avatar_path . $this->avatar;
        }

        public function is_executive()
        {
            return ($this->is_care()) || ($this->auth_level === User::$executive);
        }


        public function is_care()
        {
            return ($this->is_admin()) || ($this->auth_level === User::$care);
        }

        public function is_admin()
        {
            return ($this->auth_level === User::$admin);
        }

        public function orders()
        {
            return $this->hasMany(Order::class);
        }

        public function coupons()
        {
            return $this->hasMany(DealCoupon::class);
        }

    }
