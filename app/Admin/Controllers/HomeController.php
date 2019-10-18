<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityOrder;
use App\Models\ActivityPayLog;
use App\Models\ShopOrder;
use App\Models\ShopOrderPayLog;
use App\Models\User;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    const DAY = 1;
    const MONTH = 2;


    public function index(Content $content)
    {
        $content
//            ->row(Dashboard::title())
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {

                    $column->row(function (Row $row) {
                        $row->column(4, new InfoBox('会员', 'users', 'aqua', '#', User::calc_user_count()));
                        $row->column(4, new InfoBox('今日新增会员', 'user-plus', 'yellow', '#', User::calc_user_count(self::DAY)));
                        $row->column(4, new InfoBox('本月新增会员', 'user-plus', 'blue', '#', User::calc_user_count(self::MONTH)));
                        $row->column(4, new InfoBox('今日活动订单', 'flag', 'green', '#', ActivityOrder::calc_order_count(self::DAY)));
                        $row->column(4, new InfoBox('本月活动订单', 'flag', 'green', '#', ActivityOrder::calc_order_count(self::MONTH)));
                        $row->column(4, new InfoBox('活动订单', 'flag', 'green', '#', ActivityOrder::calc_order_count()));
                        $row->column(4, new InfoBox('今日商品订单', 'shopping-basket', 'maroon', '#', ShopOrder::calc_order_count(self::DAY)));
                        $row->column(4, new InfoBox('本月商品订单', 'shopping-basket', 'maroon', '#', ShopOrder::calc_order_count(self::MONTH)));
                        $row->column(4, new InfoBox('商品订单', 'shopping-basket', 'maroon', '#', ShopOrder::calc_order_count()));

                        $shop_order_money = ShopOrderPayLog::where('status',1)->sum('price');
                        $activity_order_money = ActivityPayLog::where('status',1)->sum('price');

                        $sum_money = $shop_order_money + $activity_order_money;
                        $row->column(12, new InfoBox('消费总额', 'dollar', 'yellow', '#', $sum_money));

                        $row->column(12, function (Column $column) {
//
                            $column->row(function (Row $row) {

                                list($user_time,$user_count) = User::calc_user_in_30();
                                $row->column(3, new Box('近30天会员数量', view('admin.member_num_statistics',['time'=>json_encode($user_time),'count'=>json_encode($user_count)])));


                                list($ao_time,$ao_price) = ActivityPayLog::calc_consume_in_30();
                                $row->column(3, new Box('近30天活动订单消费趋势', view('admin.activity_order_statistics',['ao_time'=>json_encode($ao_time),'ao_price'=>json_encode($ao_price)])));


                                list($sop_time,$sop_price) = ShopOrderPayLog::calc_consume_in_30();
                                $row->column(3, new Box('近30天商品订单消费趋势', view('admin.shop_order_statistics',['sop_time'=>json_encode($sop_time),'sop_price'=>json_encode($sop_price)])));










                                $row->column(3, new Box('近30天', view('admin.consume_statistics')));
                            });

                        });

                    });

                });
            });


        return $content;

    }
}
