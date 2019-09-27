<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends AppModel
{
    //
    protected $table = "banners";

    public function banner_cate()
    {
        return $this->belongsTo(BannerCate::class,"cate_id","id");

    }

}
