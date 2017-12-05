<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class BookletDeal extends Model
    {

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'booklet_id', 'deal_id', 'quantity', 'daily_limit',
        ];

        public function booklet()
        {
            return $this->belongsTo(Booklet::class);
        }

        public function deal()
        {
            return $this->belongsTo(Deal::class);
        }
        //
    }
