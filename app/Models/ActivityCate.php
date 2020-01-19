<?php

namespace App\Models;


class ActivityCate extends AppModel
{
    //
    protected $table = "activity_cates";
    public $timestamps = false;

    public function setIconUrlAttribute($value)
    {
        $this->attributes['icon_url'] = "http://".config("filesystems.disks.qiniu.domains.default")."/$value";
    }
}
