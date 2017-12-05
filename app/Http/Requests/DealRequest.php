<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class DealRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            $beginExtra = "";
            if ($this->method() == 'patch') {
                $beginExtra = "|after_or_equal:today";
            }
            $rules = [
                'title'                => 'required|max:255',
                'store_id'             => 'required|exists:stores,id',
                'avatar'               => 'nullable|image',
                'price'                => 'required|numeric|min:0',
                'type'                 => "required",
                'begin'                => 'required|date' . $beginExtra,
                'end'                  => "required|date|after_or_equal:{$this->begin}",
                'days'                 => "required_if:type,explicit|numeric|min:0",
                'description'          => 'required|min:3',
                'terms'                => 'required|min:3',
                'max_quantity'         => "required|integer|min:1",
                'max_daily_limit'      => "required|integer|min:1",
                'handling_fee'         => 'required|numeric|min:0',
                'discount_type'        => 'required',
                'discount_value'       => 'required|numeric|min:0',
                'club_terms'           => 'required',
                'active'               => 'required',
                'call_to'              => 'required',
                'call_to_message'      => 'required',
                'person_limit'         => 'required|min:1',
                'coin_use'             => 'required|min:1',
                'coin_get'             => 'required|min:1',
                'meta_title'           => 'required',
                'meta_description'     => 'required',
                'kind'                 => 'required',
                'master_pass_required' => 'required',
                'master_pass'          => 'required_if:master_pass_required,1',
                'price_type'           => 'required',
                'reach'                => 'required',
            ];

            return $rules;
        }
    }
