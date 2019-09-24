<?php

namespace App\Admin\Controllers;

use App\Models\ActivityOrder;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityOrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '活动订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ActivityOrder);

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('activity_id', __('Activity id'));
        $grid->column('order_sn', __('订单编号'));
        $grid->column('name', __('姓名'));
        $grid->column('sex', __('性别'));
        $grid->column('mobile', __('手机号'));
        $grid->column('unit_price', __('单价'));
        $grid->column('person_num', __('人数'));
        $grid->column('total_price', __('总价'));
        $grid->column('discount_price', __('折扣金额'));
        $grid->column('real_price', __('实际支付'));
        $grid->column('status', __('订单状态'));
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
        $show = new Show(ActivityOrder::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('activity_id', __('Activity id'));
        $show->field('order_sn', __('订单编号'));
        $show->field('name', __('姓名'));
        $show->field('sex', __('性别'));
        $show->field('mobile', __('手机号'));
        $show->field('unit_price', __('单价'));
        $show->field('person_num', __('人数'));
        $show->field('total_price', __('总价'));
        $show->field('discount_price', __('折扣金额'));
        $show->field('real_price', __('实际支付'));
        $show->field('status', __('订单状态'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ActivityOrder);

        $form->number('user_id', __('User id'));
        $form->number('activity_id', __('Activity id'));
        $form->text('name', __('姓名'))->readonly();
        $form->number('sex', __('性别'))->default(1)->readonly();
        $form->mobile('mobile', __('手机号'))->readonly();
        $form->decimal('unit_price', __('单价'))->default(0.00)->readonly();
        $form->number('person_num', __('人数'))->default(1)->readonly();
        $form->decimal('total_price', __('总价'))->default(0.00)->readonly();
        $form->decimal('discount_price', __('折扣金额'))->default(0.00)->readonly();
        $form->decimal('real_price', __('实际支付'))->default(0.00)->readonly();
        $form->number('status', __('订单状态'));

        return $form;
    }
}
