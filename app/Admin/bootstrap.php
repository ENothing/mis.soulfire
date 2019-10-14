<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
use Encore\Admin\Grid;
use Encore\Admin\Form;
use App\Admin\Extensions\Forms\ActivityOrderAgreeRefund;
use App\Admin\Extensions\Forms\ShopOrderAgreeRefund;
use App\Admin\Extensions\Forms\ShopOrderShip;

Form::forget(['map']);

Form::extend('activity_order_agree_refund', ActivityOrderAgreeRefund::class);
Form::extend('shop_order_agree_refund', ShopOrderAgreeRefund::class);
Form::extend('shop_order_ship', ShopOrderShip::class);


Grid::init(function (Grid $grid) {

    $grid->actions(function (Grid\Displayers\Actions $actions) {
        $actions->disableView();
    });
});

Form::init(function (Form $form) {

    $form->disableViewCheck();

    $form->tools(function (Form\Tools $tools) {
        $tools->disableView();
    });
});