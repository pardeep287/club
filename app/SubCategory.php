<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class SubCategory extends Model
    {
        protected $fillable = [
            'name',
            'description',
            'category_id',
        ];

        public function category()
        {
            return $this->belongsTo(Category::class);
        }

        public function deals()
        {
            return $this->belongsToMany(Deal::class, 'deal_sub_category');
        }

    }
