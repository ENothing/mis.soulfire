<?php

namespace App\Admin\Controllers;

use App\Models\ActivityOrder;
use App\Models\ActivityOrderRefund;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityOrderRefundController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '退款管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ActivityOrderRefund);
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->filter(function($filter){
            $filter->expand();
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->equal('refund_n', __('退款单号'));
            $filter->equal('activity_order.order_n', __('订单编号'));
            $filter->in('status', __('支付状态'))->checkbox([
                0 => '发起退款',
                1 => '取消退款',
                2 => '退款中',
                3 => '已退款',
                4 => '驳回退款',
            ]);
        });
        $grid->column('id', __('Id'));
        $grid->column('refund_n', __('退款单号'));
        $grid->activity_order('order_id', __('Order id'))->order_n(__('订单编号'));
        $grid->column('price', __('金额'));
        $grid->column('status', __('退款状态'))->using([
            0 => '发起退款',
            1 => '取消退款',
            2 => '退款中',
            3 => '已退款',
            4 => '驳回退款',
        ], '未知')->dot([
            0 => 'warning',
            1 => 'default',
            2 => 'primary',
            3 => 'success',
            4 => 'danger',
        ], 'danger');
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));
        $grid->actions(function ($actions) {

            // 去掉删除
            $actions->disableDelete();


            // 去掉查看
            $actions->disableView();
        });
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
        $show = new Show(ActivityOrderRefund::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('refund_n', __('Refund n'));
        $show->field('price', __('Price'));
        $show->field('order_id', __('Order id'));
        $show->field('status', __('Status'));
        $show->field('reason', __('Reason'));
        $show->field('reply_reason', __('Reply reason'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ActivityOrderRefund);

        $form->display('refund_n', __('退款单号'));
        $form->decimal('price', __('金额'))->default(0.00)->readonly();
        $form->display('order_id', __('订单编号'))->with(function ($order_id){

            return ActivityOrder::find($order_id)->order_n;

        });
        $form->display('status', __('退款状态'))->with(function ($status){
            switch ($status){
                case 0:
                    return '<span class="label-warning" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;发起退款';
                case 1:
                    return '<span class="label-default" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;取消退款';
                case 2:
                    return '<span class="label-primary" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;退款中';
                case 3:
                    return '<span class="label-success" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;已退款';
                case 4:
                    return '<span class="label-danger" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;驳回退款';
            }
        });
        $form->textarea('reason', __('原因'))->readonly();
        $form->textarea('reply_reason', __('驳回原因'));
        $form->tools(function (Form\Tools $tools) {

            // 去掉`删除`按钮
            $tools->disableDelete();

            // 去掉`查看`按钮
            $tools->disableView();

        });
        $form->activity_order_agree_refund();
        $form->footer(function ($footer) {

            // 去掉`重置`按钮
            $footer->disableReset();

            // 去掉`提交`按钮
            $footer->disableSubmit();

            // 去掉`查看`checkbox
            $footer->disableViewCheck();

            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();

            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });
        return $form;
    }
}
