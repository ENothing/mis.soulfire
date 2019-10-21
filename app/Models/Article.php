<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Article extends AppModel
{
    //
    protected $table = "articles";

    public function article_cate()
    {
        return $this->belongsTo(ArticleCate::class,"cate_id","id");

    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");

    }


    public static function calc_article_in_30()
    {
        $firstday = date("Y-m-d 00:00:00",strtotime("-30 day"));
        $lastday = date("Y-m-d 23:59:59",strtotime("-1 day"));

        $between_dates = between_dates($firstday,$lastday);


        $article = self::where('is_publish',1)->whereBetween("created_at",[$firstday,$lastday])
            ->select([DB::raw('DATE_FORMAT(created_at,"%c-%e") as time'),DB::raw('COUNT("*") as count')])
            ->groupBy(DB::raw('DATE_FORMAT(created_at,"%c-%e")'))->get()->toArray();

        $arr = array_column($article,"count","time");
        $between_dates = array_fill_keys($between_dates, 0);
        $user = array_merge($between_dates,$arr);

        $time = array_keys($user);
        $count = array_values($user);

        return [$time,$count];

    }
}
