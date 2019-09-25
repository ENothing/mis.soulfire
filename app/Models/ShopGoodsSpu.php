<?php

namespace App\Models;


class ShopGoodsSpu extends AppModel
{
    //
    protected $table = "shop_goods_spus";
    public $timestamps = false;
    protected $fillable = ['name', 'price', 'stock'];
    public function shop_goods()
    {

        return $this->belongsTo(ShopGoods::class,"goods_id","id");

    }

}
