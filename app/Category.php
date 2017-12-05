<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Category extends Model
    {
        protected $fillable = [
            'name',
            'description',
        ];

        public function subcategories()
        {
            return $this->hasMany(SubCategory::class);
        }

        public function stores()
        {
            return $this->belongsToMany(Store::class, 'category_store');
        }

        public function deals()
        {
            return $this->belongsToMany(Deal::class, 'category_deal');
        }
    }
