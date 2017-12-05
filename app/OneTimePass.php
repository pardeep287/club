<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class OneTimePass extends Model
    {
        protected $fillable = [
            'client_id',
            'otp',
        ];

        public function client()
        {
            return $this->belongsTo(Client::class);
        }
        //
    }
