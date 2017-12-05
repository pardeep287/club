<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class BonusDeal extends Model
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'title', 'type','term_n_condition'
        ];

        protected $hidden = [
            'created_at',
            'updated_at',
            'bonusDealCodes',
        ];

        public function setTypeAttribute($value)
        {
            $this->attributes['type'] = strtolower($value);
        }

        public function scopeType($query, $type)
        {
            $query->where('type', $type);
            $query->where('status', 1);

            $minCount = DefaultValue::getValue('minbonuscount', 1000)['clean'];
            $query->whereHas("bonusDealCodes", function ($query) {
                $query->where('status', 1);
            }, ">=", $minCount);

            return $query;
        }

        public function redeem(Client $client)
        {
            $ty = $this->type;
            $existing = $client->bonusCoupons()->whereHas('bonusDeal', function ($query) use ($ty) {
                $query->where('type', $ty);
            })
                ->first();
            if ($existing) {
                $existing->response = "failure";
                $existing->message = "Already Redeemed.";

                $existing->display_message = "{$existing->message} Requested: {$existing->bonusDeal->title}. Code: {$existing->code}";

                return $existing;
            }

            $code = $this->bonusDealCodes()->where('status', 1)->first();
            if ($code) {
                $client->bonusCoupons()->save($code);

                $code->status = 0;
                $code->save();

                $code->response = "success";
                $code->message = "Successfully Redeemed.";
            } else {
                $code = new BonusDealCode;
                $code->code = "-";
                $code->response = "failure";
                $code->message = "No Coupons at the moment";
            }

            $code->bonus_deal = $this;

            $code->display_message = "{$code->message} Requested: {$code->bonus_deal->title}. Code: {$code->code}";

            return $code;
        }

        public function bonusDealCodes()
        {
            return $this->hasMany(BonusDealCode::class, "bonuscode_id");
        }
    }
