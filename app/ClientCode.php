<?php

    namespace App;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    class ClientCode extends Model
    {

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'client_id', 'code_id',
        ];

        protected $appends = ['booklet'];

        public function client()
        {
            return $this->belongsTo(Client::class);
        }

        public function code()
        {
            return $this->belongsTo(Code::class);
        }

        public function getBookletAttribute()
        {
            $today = Carbon::today();

            $code = $this->code;
            $booklet = $code->booklet;
            if ($booklet) {
                $booklet->client_code_id = $this->id;
                $booklet->code = $code->code;
                $booklet->purchased_on = $this->created_at;//->format('Y-m-d');
                $expiry = $this->created_at->copy()->addDays($booklet->validity);
                $booklet->exp_msg = ($expiry->gte($today)) ? "usable" : "expired";
                $booklet->expires_on = $expiry;//->format('Y-m-d');

                $booklet->is_expired = !$expiry->gte($today);
            }

            return $booklet;
        }

        public function orders()
        {
            return $this->hasMany(Order::class);
        }

        //
    }
