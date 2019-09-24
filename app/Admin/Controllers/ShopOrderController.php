<?php

namespace App\Admin\Controllers;

use App\Models\ShopOrder;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopOrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ShopOrder);

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('order_sn', __('订单编号'));
        $grid->column('user_coupon_id', __('User coupon id'));
        $grid->column('num', __('商品总数'));
//        $grid->column('unit_price', __('Unit price'));
        $grid->column('total_price', __('总价'));
        $grid->column('real_price', __('实际支付'));
        $grid->column('discount_price', __('折扣金额'));
        $grid->column('status', __('订单状态'));
        $grid->column('name', __('姓名'));
        $grid->column('mobile', __('手机号'));
        $grid->column('province', __('省'));
        $grid->column('city', __('市'));
        $grid->column('district', __('区'));
        $grid->column('detail_address', __('详细地址'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));
//        $grid->column('deleted_at', __('Deleted at'));

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
        $show = new Show(ShopOrder::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('order_sn', __('订单编号'));
        $show->field('user_coupon_id', __('User coupon id'));
        $show->field('num', __('商品总数'));
//        $show->field('unit_price', __('Unit price'));
        $show->field('total_price', __('总价'));
        $show->field('real_price', __('实际支付'));
        $show->field('discount_price', __('折扣金额'));
        $show->field('status', __('订单状态'));
        $show->field('name', __('姓名'));
        $show->field('mobile', __('手机号'));
        $show->field('province', __('省'));
        $show->field('city', __('市'));
        $show->field('district', __('区'));
        $show->field('detail_address', __('详细地址'));
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
        $form = new Form(new ShopOrder);

        $form->number('user_id', __('User id'));
        $form->text('order_sn', __('订单编号'))->readonly();
        $form->number('user_coupon_id', __('User coupon id'));
        $form->number('num', __('商品总数'))->default(1)->readonly();
//        $form->decimal('unit_price', __('Unit price'))->default(0.00);
        $form->decimal('total_price', __('总价'))->default(0.00)->readonly();
        $form->decimal('real_price', __('实际支付'))->default(0.00)->readonly();
        $form->decimal('discount_price', __('折扣金额'))->default(0.00)->readonly();
        $form->number('status', __('订单状态'))->readonly();
        $form->text('name', __('姓名'))->readonly();
        $form->mobile('mobile', __('手机号'))->readonly();
        $form->text('province', __('省'))->readonly();
        $form->text('city', __('市'))->readonly();
        $form->text('district', __('区'))->readonly();
        $form->text('detail_address', __('详细地址'))->readonly();

        return $form;
    }
}
