<?php

namespace App\Models;


class ShopOrder extends AppModel
{

    const PENDING_PAY = 0;
    const ORDER_CANCEL = 1;
    const PAID = 2;
    const PENDING_RECEIPT = 3;
    const RECEIVED = 4;
    const REFUND_CANCEL = 4;
    const REFUNDING = 5;
    const REFUNDED = 6;


    protected $table = "shop_orders";

    public function shop_order_goods()
    {

        return $this->hasMany(ShopOrderGoods::class,"order_id","id");


    }


    public function shop_order_goods_with_goods()
    {

        return $this->shop_order_goods()->with(['shop_goods','shop_goods_spu']);

    }

    public function shop_goods()
    {
        return $this->hasManyThrough(
            ShopGoods::class,
            ShopOrderGoods::class,
            'order_id',
            'id',
            'id',
            'goods_id'
        );

    }


    public function shop_order_refund()
    {
        return $this->hasOne(ShopOrderRefund::class,"id","refund_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");

    }

}
