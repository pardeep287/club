<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class BonusDealCode extends Model
    {
        protected $fillable = [
            'bonuscode_id','code','master_code'
        ];

        protected $hidden = [
            'status',
            'created_at',
            'updated_at',
        ];

        protected $casts = [
            'redeemed' => 'boolean',
            'status'   => 'boolean',
        ];

        public function setCodeAttribute($value)
        {
            $this->attributes['code'] = strtoupper($value);
        }

        public function bonusDeal()
        {
            return $this->belongsTo(BonusDeal::class, "bonuscode_id");
        }

        public function usedBy()
        {
            return $this->belongsTo(Client::class, 'used_by')->withDefault([
                "mobile" => "-",
                "name"   => "-",
            ]);
        }

    }
