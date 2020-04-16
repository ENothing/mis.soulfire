<?php

namespace App\Models;


class Activity extends AppModel
{
    //
    protected $table = "activities";

    public function activity_cate()
    {
        return $this->belongsTo(ActivityCate::class,'cate_id','id');

    }
    public function setThumbAttribute($value)
    {
        $this->attributes['thumb'] = "http://".config("filesystems.disks.qiniu.domains.default")."/$value";
    }

    public function setActionQrAttribute($value)
    {
        $this->attributes['action_qr'] = "http://".config("filesystems.disks.qiniu.domains.default")."/$value";
    }

}
