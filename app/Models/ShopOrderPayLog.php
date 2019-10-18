<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;

class ShopOrderPayLog extends AppModel
{
    //
    protected $table = "shop_order_pay_logs";

    public function shop_order()
    {
        return $this->belongsTo(ShopOrder::class,"order_id","id");
        
    }

    public static function calc_consume_in_30()
    {
        $firstday = date("Y-m-d 00:00:00",strtotime("-30 day"));
        $lastday = date("Y-m-d 23:59:59",strtotime("-1 day"));

        $between_dates = between_dates($firstday,$lastday);


        $user = self::where('status',1)->whereBetween("created_at",[$firstday,$lastday])
            ->select([DB::raw('DATE_FORMAT(created_at,"%c-%e") as time'),DB::raw('SUM("price") as price')])
            ->groupBy(DB::raw('DATE_FORMAT(created_at,"%c-%e")'))->get()->toArray();

        $arr = array_column($user,"count","time");
        $between_dates = array_fill_keys($between_dates, 0);
        $user = array_merge($between_dates,$arr);

        $time = array_keys($user);
        $count = array_values($user);

        return [$time,$count];

    }

}
