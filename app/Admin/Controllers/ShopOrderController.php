<?php

namespace App\Admin\Controllers;

use App\Models\ShopOrder;
use App\Models\ShopOrderRefund;
use App\Models\User;
use App\Models\UserCoupon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;


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
        $grid->user('user_id', __('User id'))->nickname( __('用户昵称'));
        $grid->column('order_n', __('订单编号'));
        $grid->column('num', __('商品总数'));
//        $grid->column('unit_price', __('Unit price'));
        $grid->column('total_price', __('总价'));
        $grid->column('real_price', __('实际支付'));
        $grid->column('discount_price', __('折扣金额'));

        $grid->column("status", __('订单状态'))->display(function ($status){

           $order_refund = ShopOrderRefund::find($this->refund_id);
           if ($order_refund && $order_refund->status != ShopOrderRefund::CANCEL_REFUND && $order_refund->status != ShopOrderRefund::FAILD_REFUND){
               switch ($order_refund->status){
                   case 0:
                       return '<span class="label-info" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;发起退款';
                   case 2:
                       return '<span class="label-warning" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;退款中';
                   case 3:
                       return '<span class="label-success" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;完成退款';
               }
           }

           switch ($status){
               case 0:
                   return '<span class="label-default" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;待付款';
               case 1:
                   return '<span class="label-default" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;订单取消';
               case 2:
                   return '<span class="label-warning" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;已付款待发货';
               case 3:
                   return '<span class="label-primary" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;已发货待收货';
               case 4:
                   return '<span class="label-success" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;已完成';
               default:
                   return '<span class="label-danger" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;未知';
           }
        });

        $grid->column('name', __('姓名'));
        $grid->column('mobile', __('手机号'));
        $grid->column("address" ,__('收货地址'))->display(function () {
            return $this->province . $this->city . $this->district . $this->detail_address;
        });
//        $grid->column('province', __('省'));
//        $grid->column('city', __('市'));
//        $grid->column('district', __('区'));
//        $grid->column('detail_address', __('详细地址'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));
//        $grid->column('deleted_at', __('Deleted at'));
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
        $show = new Show(ShopOrder::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('order_n', __('订单编号'));
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

        $form->column(1/2, function ($form) {

            $form->text('order_n', __('订单编号'))->readonly();
            $form->select('user_id', __('用户昵称'))->options(User::all()->pluck("nickname",'id'))->readonly();
            $form->display('user_coupon_id', __('优惠券'))->with(function ($user_coupon_id){

                if ($user_coupon_id == 0){

                    return "未使用优惠券";

                }

                $user_coupon = UserCoupon::with('coupon')->find($user_coupon_id);

                switch ($user_coupon->coupon_type){
                    case 1:
                        return "满 ".$user_coupon->full_price . " 减 ".$user_coupon->reduction_price;
                    case 2:
                        return "立减 ".$user_coupon->immediately_price;
                    case 3:
                        return $user_coupon->discount." 折";
                }

            });
            $form->display('num', __('商品总数'));
//        $form->decimal('unit_price', __('Unit price'))->default(0.00);
            $form->decimal('total_price', __('总价'))->default(0.00)->readonly();
            $form->decimal('discount_price', __('折扣金额'))->default(0.00)->readonly();
            $form->decimal('real_price', __('实际支付'))->default(0.00)->readonly();
            $form->display('status', __('订单状态'))->with(function ($status){

                $order_refund = ShopOrderRefund::find($this->refund_id);
                if ($order_refund && $order_refund->status != ShopOrderRefund::CANCEL_REFUND && $order_refund->status != ShopOrderRefund::FAILD_REFUND){
                    switch ($order_refund->status){
                        case 0:
                            return '<span class="label-info" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;发起退款';
                        case 2:
                            return '<span class="label-warning" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;退款中';
                        case 3:
                            return '<span class="label-success" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;完成退款';
                    }
                }

                switch ($status){
                    case 0:
                        return '<span class="label-default" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;待付款';
                    case 1:
                        return '<span class="label-default" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;订单取消';
                    case 2:
                        return '<span class="label-warning" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;已付款待发货';
                    case 3:
                        return '<span class="label-primary" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;已发货待收货';
                    case 4:
                        return '<span class="label-success" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;已完成';
                    default:
                        return '<span class="label-danger" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;未知';
                }


            });
            $form->text('name', __('姓名'));
            $form->mobile('mobile', __('手机号'));
            $form->text('province', __('省'));
            $form->text('city', __('市'));
            $form->text('district', __('区'));
            $form->text('detail_address', __('详细地址'));
        });

        $form->column(1/2, function ($form) {
            $form->hasMany('shop_order_goods_with_goods', __('商品'), function (Form\NestedForm $form) {
                $form->display('shop_goods.thumb',__('商品封面'))->with(function ($thumb){
                    return '<img src="'.env('APP_URL').'/storage/'. $thumb.'" style="width:100px;height:100px">';
                });
                $form->text('shop_goods.name',__('商品名称'))->readonly();
                $form->display('num',__('数量'));
                $form->text('shop_goods_spu.name',__('商品规格'))->readonly();
                $form->text('shop_goods_spu.price',__('商品价格'))->readonly();

            })->disableDelete()->disableCreate();
        });

        $form->tools(function (Form\Tools $tools) {
            // 去掉`删除`按钮
            $tools->disableDelete();
        });
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
