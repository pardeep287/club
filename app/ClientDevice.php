<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class ClientDevice extends Model
    {
        protected $fillable = [
            "client_id",
            "device_id",
            "emulator",
            "additional",
        ];

        protected $casts = [
            'additional' => 'array',
        ];

        public function client()
        {
            return $this->belongsTo(Client::class);
        }
    }
