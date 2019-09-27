<?php

namespace App\Models;


class ShopOrderPayLog extends AppModel
{
    //
    protected $table = "shop_order_pay_logs";

    public function shop_order()
    {
        return $this->belongsTo(ShopOrder::class,"order_id","id");
        
    }
    
}
