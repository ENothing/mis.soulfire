<?php

namespace App\Models;


class ShopOrderGoods extends AppModel
{
    //
    protected $table = "shop_order_goods";


    public function shop_goods()
    {

        return $this->hasOne(ShopGoods::class,"id","goods_id");

    }

    public function shop_goods_spu()
    {
        return $this->hasOne(ShopGoodsSpu::class,"id","spu_id");

    }

}
