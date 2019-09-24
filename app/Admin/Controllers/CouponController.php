<?php

namespace App\Admin\Controllers;

use App\Models\Coupon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CouponController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '优惠券列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Coupon);

        $grid->column('id', __('Id'));
        $grid->column('name', __('优惠券名'));
        $grid->column('type', __('所属模块'));
        $grid->column('coupon_type', __('优惠类型'));
        $grid->column('full_price', __('满'));
        $grid->column('reduction_price', __('减'));
        $grid->column('immediately_price', __('立减金额'));
        $grid->column('discount', __('打折'));
        $grid->column('start_receive_time', __('领取开始时间'));
        $grid->column('end_receive_time', __('领取结束时间'));
        $grid->column('is_timeing', __('是否设置使用时间限制'));
        $grid->column('start_use_time', __('开始使用时间'));
        $grid->column('end_use_time', __('结束使用时间'));
        $grid->column('day', __('领取后可使用天数'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Coupon::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('优惠券名'));
        $show->field('type', __('所属模块'));
        $show->field('coupon_type', __('优惠类型'));
        $show->field('full_price', __('满'));
        $show->field('reduction_price', __('减'));
        $show->field('immediately_price', __('立减金额'));
        $show->field('discount', __('打折'));
        $show->field('start_receive_time', __('领取开始时间'));
        $show->field('end_receive_time', __('领取结束时间'));
        $show->field('is_timeing', __('是否设置使用时间限制'));
        $show->field('start_use_time', __('开始使用时间'));
        $show->field('end_use_time', __('结束使用时间'));
        $show->field('day', __('领取后可使用天数'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Coupon);

        $form->text('name', __('优惠券名'));
        $form->number('type', __('所属模块'))->default(2);
        $form->number('coupon_type', __('优惠类型'))->default(1);
        $form->decimal('full_price', __('满'))->default(0.00);
        $form->decimal('reduction_price', __('减'))->default(0.00);
        $form->decimal('immediately_price', __('立减金额'))->default(0.00);
        $form->decimal('discount', __('打折'))->default(0.0);
        $form->datetime('start_receive_time', __('领取开始时间'))->default(date('Y-m-d H:i:s'));
        $form->datetime('end_receive_time', __('领取结束时间'))->default(date('Y-m-d H:i:s'));
        $form->switch('is_timeing', __('是否设置使用时间限制'));
        $form->datetime('start_use_time', __('开始使用时间'))->default(date('Y-m-d H:i:s'));
        $form->datetime('end_use_time', __('结束使用时间'))->default(date('Y-m-d H:i:s'));
        $form->number('day', __('领取后可使用天数'))->default(0);

        return $form;
    }
}
