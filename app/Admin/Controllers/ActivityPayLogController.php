<?php

namespace App\Admin\Controllers;

use App\Models\ActivityPayLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityPayLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '活动订单支付记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ActivityPayLog);
        $grid->filter(function($filter){
            $filter->expand();

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->equal('activity_order.order_n', '订单编号');
            $filter->equal('pay_n', '支付单号');
            $filter->in('status', __('支付状态'))->checkbox([
                0 => '待支付',
                1 => '支付成功',
                2 => '支付失败',
            ]);
            $filter->between('created_at', __('创建时间'))->datetime();

        });
        $grid->column('id', __('Id'));
        $grid->activity_order()->order_n(__('订单编号'));
        $grid->column('pay_n', __('支付单号'));
        $grid->column('price', __('金额'));
        $grid->column('status', __('支付状态'))->using([
            0 => '待支付',
            1 => '支付成功',
            2 => '支付失败',
        ], '未知')->dot([
            0 => 'warning',
            1 => 'success',
            2 => 'danger',
        ], 'danger');
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->disableActions();
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
        $show = new Show(ActivityPayLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_id', __('Order id'));
        $show->field('pay_sn', __('支付单号'));
        $show->field('price', __('金额'));
        $show->field('status', __('支付状态'));
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
        $form = new Form(new ActivityPayLog);

        $form->text('order_id', __('Order id'));
        $form->text('pay_n', __('支付单号'))->readonly();
        $form->decimal('price', __('金额'))->default(0.00)->readonly();
        $form->number('status', __('支付状态'));

        return $form;
    }
}
