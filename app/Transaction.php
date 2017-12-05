<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Transaction extends Model
    {

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'user_id',
            'cc_transaction_id',
            'remarks',
            'client_code_id',
            'deal_id',
        ];

        protected $casts = [
            'remarks' => 'array',
        ];

        protected $appends = [
            'client', 'code', 'booklet',
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function cctransaction()
        {
            return $this->belongsTo(CCTransaction::class);
        }

        public function client_code()
        {
            return $this->belongsTo(ClientCode::class);
        }

        public function deal()
        {
            return $this->belongsTo(Deal::class);
        }

        public function getClientAttribute()
        {
            return $this->client_code->client;
        }

        public function getCodeAttribute()
        {
            return $this->client_code->code;
        }

        public function getBookletAttribute()
        {
            $client_code = $this->client_code;
            $code = $client_code->code;
            $bklt = $code->booklet;
            $bklt->code = $code->code;
            $bklt->purchased_on = $client_code->created_at;

            return $bklt;
        }

    }
