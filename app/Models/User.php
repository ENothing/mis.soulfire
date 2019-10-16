<?php

namespace App\Models;


class User extends AppModel
{
    //
    protected $table = "users";

    public function user_level()
    {
        return $this->hasOne(UserLevel::class,"user_id",'id');

    }

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

}
