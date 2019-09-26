<?php

namespace App\Models;


class ShopGoods extends AppModel
{
    //
    protected $table = "shop_goods";
    protected $fillable = [];

    public function setBannersAttribute($val)
    {
        $this->attributes['banners'] = serialize($val);

    }

    public function getBannersAttribute($val)
    {
        return unserialize($val);

    }

    public function shop_goods_spu()
    {
        return $this->hasMany(ShopGoodsSpu::class,"goods_id","id");

    }

    public function shop_goods_cate()
    {
        return $this->belongsTo(ShopGoodsCate::class,"cate_id","id");

    }

    public function shop_goods_brand()
    {
        return $this->belongsTo(ShopGoodsBrand::class,"brand_id","id");
    }

    public function level()
    {
        return $this->belongsTo(Level::class,"level_id","id");
        
    }

    public function shop_order_goods()
    {

        return $this->belongsTo(ShopOrderGoods::class,"id","goods_id");

    }



}
