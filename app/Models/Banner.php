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

    public function setThumbAttribute($value)
    {

        $this->attributes['thumb'] = "http://".config("filesystems.disks.qiniu.domains.default")."/$value";
    }

    public function setVideoUrlAttribute($value)
    {

        $this->attributes['video_url'] = "http://".config("filesystems.disks.qiniu.domains.default")."/$value";
    }


}
