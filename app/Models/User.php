<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;

class User extends AppModel
{
    //
    protected $table = "users";

    public function user_level()
    {
        return $this->hasOne(UserLevel::class,"user_id",'id');

    }

    /**
     * Created by Eric-Nothing.
     * @param int $type
     * @return mixed
     * 计算指定时间用户总数
     */
    public static function calc_user_count($type = 0)
    {
        switch ($type){
            case 1://日
                $item = self::whereBetween("created_at" ,[date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')])->count();
                break;
            case 2://月
                $item = self::whereBetween("created_at" ,[date('Y-m-1 00:00:00'),date('Y-m-31 23:59:59')])->count();
                break;
            default:
                $item = self::count();

        }

        return $item;

    }

    /**
     * Created by Eric-Nothing.
     * 近30天会员数量变化
     */
    public static function calc_user_in_30()
    {
        $firstday = date("Y-m-d 00:00:00",strtotime("-30 day"));
        $lastday = date("Y-m-d 23:59:59",strtotime("-1 day"));

        $between_dates = between_dates($firstday,$lastday);


        $user = self::whereBetween("created_at",[$firstday,$lastday])
            ->select([DB::raw('DATE_FORMAT(created_at,"%c-%e") as time'),DB::raw('COUNT("*") as count')])
            ->groupBy(DB::raw('DATE_FORMAT(created_at,"%c-%e")'))->get()->toArray();

        $arr = array_column($user,"count","time");
        $between_dates = array_fill_keys($between_dates, 0);
        $user = array_merge($between_dates,$arr);

        $time = array_keys($user);
        $count = array_values($user);

        return [$time,$count];

    }

}
