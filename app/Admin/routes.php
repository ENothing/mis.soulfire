<?php

use Illuminate\Routing\Router;



Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('users', 'UserController');
    $router->resource('banner_cates', 'BannerCateController');
    $router->resource('banners', 'BannerController');
    $router->resource('activities', 'ActivityController');
    $router->resource('activity_cates', 'ActivityCateController');
    $router->resource('activity_orders', 'ActivityOrderController');
    $router->resource('activity_pay_logs', 'ActivityPayLogController');
    $router->resource('articles', 'ArticleController');
    $router->resource('article_cates', 'ArticleCateController');
    $router->resource('article_comments', 'ArticleCommentController');
    $router->resource('coupons', 'CouponController');
    $router->resource('feedback', 'FeedbackController');
    $router->resource('levels', 'LevelController');
    $router->resource('shop_goods', 'ShopGoodsController');
    $router->resource('shop_goods_brands', 'ShopGoodsBrandController');
    $router->resource('shop_goods_cates', 'ShopGoodsCateController');
    $router->resource('shop_orders', 'ShopOrderController');
    $router->resource('shop_order_pay_logs', 'ShopOrderPayLogController');
    $router->resource('shop_order_refunds', 'ShopOrderRefundController');
    $router->resource('user_invite_logs', 'UserInviteLogController');
    $router->resource('activity_order_refunds', 'ActivityOrderRefundController');
});

Route::group([
    'prefix'        => 'admin/api',
    'namespace'     => 'App\Admin\Api',
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/brands', 'GoodsCateController@brand');
    $router->post('/activity_order_agree_refund', 'ActivityOrderRefundController@agree_refund');
    $router->post('/activity_order_reject_refund', 'ActivityOrderRefundController@reject_refund');

});



