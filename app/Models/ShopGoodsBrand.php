<?php

namespace App\Models;


class ShopGoodsBrand extends AppModel
{
    //
    protected $table = "shop_goods_brands";
    public $timestamps = false;
    protected $guarded = [];

    public function setLogoAttribute($value)
    {
        $this->attributes['logo'] = "http://".config("filesystems.disks.qiniu.domains.default")."/$value";
    }
}
