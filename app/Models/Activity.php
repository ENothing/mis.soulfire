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
}
