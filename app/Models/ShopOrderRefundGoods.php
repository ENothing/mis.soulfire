<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOrderRefundGoods extends Model
{
    //
    protected $table = "shop_order_refund_goods";
    public $timestamps = false;


    public function shop_order_goods()
    {
        return $this->hasOne(ShopOrderGoods::class,"id","order_goods_id");

    }




}
