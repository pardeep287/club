<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class DefaultValue extends Model
    {

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'key', 'value',
        ];

        public static function terms()
        {
            return DefaultValue::getValue('jbTerms', "TnC");
        }

        /*
         *  *************************
         *         PREDEFINED
         *  *************************
         */

        public static function getValue($key, $value = "")
        {
            $serverValue = DefaultValue::where('key', $key)->first();
            if (empty($serverValue)) {
                $serverValue = [
                    'key'   => $key,
                    'value' => $value,
                    'clean' => strip_tags($value),
                ];
            } else {
                $serverValue->clean = strip_tags($serverValue->value);
            }

            return $serverValue;
        }

        public static function dealterms()
        {
            return DefaultValue::getValue('dealTerms', "Deal Terms");
        }

        public static function dealDescription()
        {
            return DefaultValue::getValue('dealdescription', "Deal Description");
        }

        public static function jbAbout()
        {
            return DefaultValue::getValue('about', "About JB");
        }

        public static function jbCare()
        {
            return DefaultValue::getValue('jbcare', "+918196081960");
        }

        public static function jbCareCity(City $city)
        {
            return DefaultValue::where('key', 'like', 'jbcare_' . $city->name . '%')->orWhere('key', 'jbcare')->orderBy('id', 'desc')->get()->all();
        }
    }
