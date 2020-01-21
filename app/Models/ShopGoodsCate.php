<?php

namespace App\Models;


class ShopGoodsCate extends AppModel
{
    //
    protected $table = "shop_goods_cates";
    public $timestamps = false;

    public function setIconUrlAttribute($value)
    {
        $this->attributes['icon_url'] = "http://".config("filesystems.disks.qiniu.domains.default")."/$value";
    }
}
