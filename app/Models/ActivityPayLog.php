<?php

namespace App\Models;


class ActivityPayLog extends AppModel
{
    //
    protected $table = "activity_pay_logs";

    public function activity_order()
    {
        return $this->belongsTo(ActivityOrder::class,"order_id","id");

    }

}
