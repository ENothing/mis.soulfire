<?php

namespace App\Models;


class ActivityOrder extends AppModel
{

    const PENDING_PAY = 0;//待付款
    const PAID = 1;//已付款
    const FINISHED = 2;//已完成
    const CANCEL = 3;//已取消
    const INIT_REFUND = 4;//发起退款
    const REFUNDING = 5;//退款完成关闭订单
    const OVER_REFUND = 6;//退款失败



    //
    protected $table = "activity_orders";

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id','id');
    }

    public function activity_pay_log()
    {
        return $this->hasOne(ActivityPayLog::class,"order_id","id");

    }

//    public function getSexAttribute($value)
//    {
//        return $value == 1 ? '男':'女';
//    }

//    public function getStatusAttribute($value)
//    {
//        $status = '';
//        switch ($value){
//            case 0:
//                $status = "待付款";
//                break;
//            case 1:
//                $status = "已付款";
//                break;
//            case 2:
//                $status = "已完成";
//                break;
//            case 3:
//                $status = "已取消";
//                break;
//            case 4:
//                $status = "发起退款";
//                break;
//            case 5:
//                $status = "退款完成";
//                break;
//            case 6:
//                $status = "退款失败";
//                break;
//            default:
//                $status = "订单状态不存在";
//        }
//
//        return $status;
//
//
//    }

}
