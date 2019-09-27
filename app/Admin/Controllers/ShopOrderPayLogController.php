<?php

namespace App\Admin\Controllers;

use App\Models\ShopOrderPayLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopOrderPayLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品订单支付记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ShopOrderPayLog);
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->column('id', __('Id'));
        $grid->shop_order('order_id', __('Order id'))->order_n(__('订单编号'));
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
        $show = new Show(ShopOrderPayLog::findOrFail($id));

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
        $form = new Form(new ShopOrderPayLog);

        $form->number('order_id', __('Order id'));
        $form->text('pay_sn', __('支付单号'));
        $form->decimal('price', __('金额'))->default(0.00);
        $form->number('status', __('支付状态'));

        return $form;
    }
}
