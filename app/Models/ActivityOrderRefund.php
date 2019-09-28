<?php

namespace App\Models;


class ActivityOrderRefund extends AppModel
{
    //
    const INIT_REFUND = 0;//发起退款
    const CANCEL_REFUND = 1;//取消退款
    const REFUNDING = 2;//退款中
    const FINISH_REFUND = 3;//退款完成
    const FAILD_REFUND = 4;//退款失败 驳回退款

    protected $table = "activity_order_refunds";

    public function activity_order()
    {
        return $this->belongsTo(ActivityOrder::class,"id","refund_id");

    }
}
