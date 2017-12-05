<?php

    namespace App\Helpers;

    class Common
    {
        public static function calculateDiscount($discountType, $discountValue, $price) {
            $discount = 0;

            $type = $discountType;

            if($type == "direct") {
                $discount = $discountValue;
            } elseif($type == "percentage") {
                $discount = (($discountValue*$price)/100);
            }

            return $discount;
        }
    }