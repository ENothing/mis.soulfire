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

        $grid->column('id', __('Id'));
        $grid->column('order_id', __('Order id'));
        $grid->column('pay_sn', __('支付单号'));
        $grid->column('price', __('金额'));
        $grid->column('status', __('支付状态'));
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

        $form->number('order_id', __('Order id'));
        $form->text('pay_sn', __('支付单号'))->readonly();
        $form->decimal('price', __('金额'))->default(0.00)->readonly();
        $form->number('status', __('支付状态'));

        return $form;
    }
}
