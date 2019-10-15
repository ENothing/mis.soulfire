<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    const DAY = 1;
    const MONTH = 2;


    public function index(Content $content)
    {
        $content
            ->title('Dashboard')
            ->description('Description...')
//            ->row(Dashboard::title())
            ->row(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(4, new InfoBox('会员', 'users', 'aqua', '#', User::calc_user_count()));

                        $row->column(4, new InfoBox('今日新增会员', 'user-plus', 'yellow', '#', User::calc_user_count(self::DAY)));

                        $row->column(4, new InfoBox('本月新增会员', 'user-plus', 'blue', '#', User::calc_user_count(self::MONTH)));
                    });
                    $column->row(function (Row $row) {
                        $row->column(4, new InfoBox('今日活动订单', 'shopping-basket', 'green', '#', 234));
                        $row->column(4, new InfoBox('本月活动订单', 'shopping-basket', 'green', '#', 234));
                        $row->column(4, new InfoBox('活动订单', 'shopping-basket', 'green', '#', 234));
                    });
                    $column->row(function (Row $row) {
                        $row->column(4, new InfoBox('今日商品订单', 'shopping-basket', 'maroon', '#', 234));
                        $row->column(4, new InfoBox('本月商品订单', 'shopping-basket', 'maroon', '#', 234));
                        $row->column(4, new InfoBox('商品订单', 'shopping-basket', 'maroon', '#', 234));

                    });
                    $column->row(function (Row $row) {
                        $row->column(12, new InfoBox('消费总额', 'shopping-basket', 'yellow', '#', 234));

                    });
                });

                $row->column(12, function (Column $column) {
                    $column->row(new Box('Bar chart', view('admin.chartjs')));

                });


//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::environment());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::extensions());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::dependencies());
//                });
            });


        return $content;

    }
}
