<?php

namespace App\Models;


class ShopOrderRefund extends AppModel
{

    const INIT_REFUND = 0;//发起退款
    const CANCEL_REFUND = 1;//取消退款
    const REFUNDING = 2;//退款中
    const FINISH_REFUND = 3;//退款完成
    const FAILD_REFUND = 4;//退款失败 驳回退款


    //
    protected $table = "shop_order_refunds";
    protected $guarded = [];

    public function shop_order()
    {

        return $this->belongsTo(ShopOrder::class,"order_id","id");

    }


    public function shop_order_refund_goods()
    {
        return $this->hasMany(ShopOrderRefundGoods::class,"refund_id","id");

    }



    public function sorg_with_og()
    {
        return $this->shop_order_refund_goods()->with(['shop_order_goods','shop_order_goods.shop_goods','shop_order_goods.shop_goods_spu']);

    }

}
