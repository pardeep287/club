<?php

    namespace App;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Facades\Log;

    class Booklet extends Model
    {

        use SoftDeletes;

        public static $avatar_path = '/uploads/avatars/booklets/';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'price', 'validity', 'avatar', 'city_id',
        ];

        protected $appends = ['dealCount', 'usable', 'freshCodes', 'fresh_codes_count'];

        protected $hidden = ['deals', 'freshCodes'];

        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = ['deleted_at'];


        public function deals()
        {
            return $this->belongsToMany(Deal::class, 'booklet_deals')
                ->with(['categories', 'sub_categories'])
                ->withTimestamps()
                ->withPivot('id', 'quantity', 'daily_limit', 'ord');
        }

        public function getDealCountAttribute()
        {
            return $this->deals->count();
        }

        public function city()
        {
            return $this->belongsTo(City::class);
        }

        public function orders()
        {
            return $this->hasMany(Order::class);
        }

        public function imageAvatar()
        {
            return Booklet::$avatar_path . $this->avatar;
        }

        public function create_codes($quantity, $method, $length, $value, $validity)
        {
            $today = Carbon::today();
            $ending = Carbon::today()->addDays($validity);

            $codes = array();

            for ($i = 0; $i < $quantity; $i++) {
                $codes[] = new Code([
                    'code'  => strtoupper($value . $this->get_code($method, $length)),
                    'begin' => $today,
                    'end'   => $ending,
                ]);
            }
            $chunks = array_chunk($codes, 50);
            foreach ($chunks as $chunk) {
                $this->codes()->saveMany($chunk);
            }

            return $codes;

        }

        public function get_code($method, $length)
        {
            switch ($method) {
                case 'random':
                    return str_random($length);
                    break;

                case 'simple':
                default:
                    return "";
                    break;

            }
        }

        public function codes()
        {
            return $this->hasMany(Code::class);
        }

        public function getUsableAttribute()
        {
            return ($this->codes()->expired(['created'], '>=')->count() > DefaultValue::getValue('minBookletCount', 1000)['clean']);
        }

        public function getFreshCodesAttribute()
        {
            return $this->codes()->expired(['created'], '>')->inRandomOrder();
        }

        public function getFreshCodesCountAttribute()
        {
            return $this->getFreshCodesAttribute()->count();
        }

        public function purchaseCode(Client $client, $user, $transaction, CCTransaction $ccTransaction = null)
        {
            $code = $this->freshCodes->first();

            if (isset($code->code)) {
                $bookletPurchase = BookletPurchase::create([
                    'client_id'         => $client->id,
                    'user_id'           => $user->id,
                    'code'              => $code->code,
                    'code_id', $code->id,
                    'remarks'           => "{$this->name}({$this->city->name}), @₹{$this->price}/- {$transaction}",
                    'price'             => $this->price,
                    'cc_transaction_id' => (is_null($ccTransaction)) ? null : $ccTransaction->id,
                ]);

                $bookletPurchase->bookletCode()->associate($code);
                $bookletPurchase->save();

                $res['msg'] = "success";
                $res['code'] = $code;
                $res['transaction'] = $bookletPurchase;

                $code->status = 'purchased';
                $code->save();

            } else {
                Log::alert('No Coupons Left', [
                    'booklet' => $this->toArray(),
                ]);
                $res['msg'] = 'failure';
            }

            return $res;
        }

        public function codesLeft($paddingNumerals = '4')
        {
            return str_pad($this->fresh_codes_count, $paddingNumerals, '0', STR_PAD_LEFT);
        }
    }