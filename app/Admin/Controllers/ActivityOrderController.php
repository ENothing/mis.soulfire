<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\ActivityOrder;
use App\Models\User;
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

//        $grid->column('id', __('Id'));
        $grid->user()->nickname(__('用户昵称'));
        $grid->activity()->title(__('活动标题'));
        $grid->column('order_sn', __('订单编号'));
        $grid->column('name', __('姓名'));
        $grid->column('sex', __('性别'))->display(function ($sex){
            return $sex == 1 ? '男':'女';
        });
        $grid->column('mobile', __('手机号'));
        $grid->column('unit_price', __('单价'));
        $grid->column('person_num', __('人数'));
        $grid->column('total_price', __('总价'));
        $grid->column('discount_price', __('折扣金额'));
        $grid->column('real_price', __('实际支付'));
        $grid->column('status', __('订单状态'))->using([
            0 => '待付款',
            1 => '已付款',
            2 => '已完成',
            3 => '已取消',
            4 => '发起退款',
            5 => '退款完成',
            6 => '退款失败',
        ], '订单状态不存在')->dot([
            0 => 'warning',
            1 => 'primary',
            2 => 'success',
            3 => 'default',
            4 => 'danger',
            5 => 'default',
            6 => 'warning',
        ], 'danger');


        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));
        $grid->disableCreateButton();
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
        $form = new Form(new ActivityOrder);

        $form->select('user_id', __('用户昵称'))->options(User::all()->pluck("nickname","id"))->readOnly();
        $form->select('activity_id', __('活动标题'))->options(Activity::all()->pluck("title","id"))->readOnly();
        $form->text('name', __('姓名'))->readonly();
        $form->radio('sex', __('性别'))->options(['1' => '男', '2'=> '女'])->readonly();
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
