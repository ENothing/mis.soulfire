<?php

namespace App\Models;


class ShopOrderDelivery extends AppModel
{
    //
    protected $table = "shop_order_deliveries";
    protected $guarded = [];

    public function shop_order()
    {
        return $this->belongsTo(ShopOrder::class,"order_id","id");
    }

}
