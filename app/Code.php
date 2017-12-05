<?php

    namespace App;

    use Carbon\Carbon;
    use DB;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Log;

    class Code extends Model
    {

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'booklet_id', 'code', 'status', 'begin', 'end',
        ];

        protected $dates = [
            'begin',
            'end',
        ];

        protected $appends = [
            'statusMessage',
            'used',
            'purchased',
        ];

        public static function validate($code, Client $purchasedBy)
        {
            $codeS = DB::table('codes')
                ->select('id')
                ->whereRaw("id in (select code_id from booklet_purchases where client_id = {$purchasedBy->id}) ")
                ->where('code', strtoupper($code))
                ->where('status', 'purchased')
//                ->whereRaw("date(now()) between date(begin) and date(end)")
                ->where("begin", '<=', Carbon::today()->format('Y-m-d'))
                ->where("end", '>=', Carbon::today()->format('Y-m-d'))
                ->inRandomOrder();

            Log::info("Validate", [
                'code'    => $code,
                'codeSQL' => $codeS->toSql(),
            ]);

            $codeRe = $codeS
                ->first();

            if (isset($codeRe->id)) {
                return Code::find($codeRe->id);
            } else {
                return null;
            }


            // return Code::where('code', strtoupper($code))->where('status', 'purchased')->whereRaw("date(now()) between date(begin) and date(end)")->first();
        }

        public function getUsedAttribute()
        {
            return (strtolower($this->status) === 'active');
        }

        public function isUsed()
        {
            return $this->used;
        }

        public function getPurchasedAttribute()
        {
            return (strtolower($this->status) === 'purchased');
        }

        public function getStatusMessageAttribute()
        {
            // $message = "{$this->status}";
            $message = "-";

            if ($this->used) {
                $client = $this->client()->first();
                $message = "by {$client->name}, {$client->mobile} on {$client->pivot->created_at}";
            } else if ($this->purchased) {
                $message = "on {$this->updated_at}";
            }

            return $message;
        }

        public function client()
        {
            return $this->belongsToMany(Client::class, 'client_codes')->withTimestamps();
        }

        public function isPurchased()
        {
            return $this->purchased;
        }

        public function booklet()
        {
            return $this->belongsTo(Booklet::class);
        }

        public function client_code()
        {
            return $this->hasOne(ClientCode::class);
        }

        public function bookletPurchase()
        {
            return $this->hasOne(BookletPurchase::class, 'code_id');
        }

        public function scopeExpired($query, $status = ['created', 'paused'], $comparator = "<")
        {
            $today = Carbon::today();
            $query
                ->where('end', $comparator, $today->format('Y-m-d'))
                ->whereIn('status', $status);

            return $query;
        }
    }
