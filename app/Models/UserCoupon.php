<?php

namespace App\Models;


class UserCoupon extends AppModel
{
    //
    protected $table = "user_coupons";
    public $timestamps = false;

    public function coupon()
    {
        return $this->hasOne(Coupon::class,"id","coupon_id");

    }

}
