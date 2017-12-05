<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class BookletPurchase extends Model
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'client_id', 'user_id', 'code', 'remarks', 'price', 'cc_transaction_id', 'code_id',
        ];

        protected $appends = [
            'realCode',
            'status',
            'booklet',
            'usedBy',
            'usedOn',
        ];

        public function client()
        {
            return $this->belongsTo(Client::class);
        }

        public function getRealCodeAttribute()
        {
            $realCode = $this->bookletCode;
            if (is_null($realCode)) {
                $realCode = Code::where('code', $this->code)->first();
            }

            return $realCode;
        }


        public function getStatusAttribute()
        {
            return $this->realCode->status;
        }

        public function getUsedByAttribute()
        {
            $usedBy = $this->realCode->client->first();
            if (is_null($usedBy)) {
                $usedBy = new Client([
                    'name'   => "-",
                    'mobile' => '-',
                    'avatar' => "jbClient.png",
                ]);
            }

            return $usedBy;
        }

        public function getUsedOnAttribute()
        {
            return (isset($this->usedBy->pivot)) ? $this->usedBy->pivot->created_at->format('d-m-Y') : "-";
        }

        public function getBookletAttribute()
        {
            return $this->realCode->booklet()->withTrashed()->first();
        }

        public function bookletCode()
        {
            return $this->belongsTo(Code::class, 'code_id');
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function ccTransaction()
        {
            return $this->belongsTo(CCTransaction::class);
        }
    }
