<?php

namespace App\Admin\Controllers;

use App\Models\Express;
use App\Models\ShopOrderRefund;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopOrderRefundController extends AdminController
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
        $grid = new Grid(new ShopOrderRefund);
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->expand();

            $filter->equal('shop_order.order_n', __('订单编号'));
            $filter->equal('refund_n', __('退款单号'));
            $filter->between('created_at', __('创建时间'))->datetime();
            $filter->equal('r_type', __('退款类型'))->radio([
                ''   => '全部',
                1    => '仅退款',
                2    => '退货退款',
            ]);
            $filter->in('status', __('	退款状态'))->checkbox([
                0 => '发起退款',
                1 => '取消退款',
                2 => '退款中',
                3 => '已退款',
                4 => '驳回退款',
            ]);


        });
        $grid->column('id', __('Id'));
        $grid->column('refund_n', __('退款单号'));
        $grid->shop_order('order_id', __('order_id'))->order_n(__('订单编号'));
//        $grid->column('order_goods_id', __('Order goods id'));
        $grid->column('r_type', __('退款类型'))->display(function ($type){

            return $type == 1 ? "仅退款":"退货退款";

        })->label([
            1 => 'primary',
            2 => 'danger',
        ]);
        $grid->column('status', __('退款状态'))->using([
            0 => '发起退款',
            1 => '取消退款',
            2 => '退款中',
            3 => '已退款',
            4 => '驳回退款',
            5=>'同意退款',
            6=>'等待审核货运信息'
        ], '未知')->dot([
            0 => 'warning',
            1 => 'default',
            2 => 'primary',
            3 => 'success',
            4 => 'danger',
            5=>'success',
            6=>'warning'
        ], 'danger');

        $grid->column('price', __('金额'))->sortable();

//        $grid->column('reason_pics', __('Reason pics'));
//        $grid->column('reason', __('Reason'));
//        $grid->column('reply_reason', __('Reply reason'));
        $grid->column('created_at', __('创建时间'))->sortable();
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
        $show = new Show(ShopOrderRefund::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_goods_id', __('Order goods id'));
        $show->field('refund_no', __('Refund no'));
        $show->field('price', __('Price'));
        $show->field('status', __('Status'));
        $show->field('type', __('Type'));
        $show->field('reason_pics', __('Reason pics'));
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
        $form = new Form(new ShopOrderRefund);



// 第一列占据1/2的页面宽度
        $form->column(1/2, function ($form) {
            $form->display('refund_n', __('退款单号'));
            $form->decimal('price', __('金额'))->readonly();
//            $form->display('r_type', __('退款类型'))->with(function ($type){
//
//                return $type == 1 ? "仅退款":"退货退款";
//
//            });
            $form->radio('r_type', __('退款类型'))->options(['1' => '仅退款', '2'=> '退款退货'])->stacked();
            $form->display('status', __('退款状态'))->with(function ($status){
                switch ($status){
                    case 0:
                        return '<span class="label-warning" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;发起退款';
                    case 1:
                        return '<span class="label-default" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;取消退款';
                    case 2:
                        return '<span class="label-primary" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;审核通过';
                    case 3:
                        return '<span class="label-success" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;已退款';
                    case 4:
                        return '<span class="label-danger" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;驳回退款';
                    case 5:
                        return '<span class="label-success" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;同意退款';
                    case 6:
                        return '<span class="label-warning" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;等待审核货运信息';
                }
            });
            $form->multipleImage('reason_pics', __('原因附图'))->readonly();
            $form->textarea('reason', __('原因'))->readonly();
            $form->divider();
            $form->textarea('reply_reason', __('驳回原因'));

            $form->radio('r_way',"退款平台")->options([1 => '微信', 2=> '支付宝'])->default(1);
            $form->shop_order_agree_refund();



        });

// 第二列占据右边1/2的页面宽度
        $form->column(1/2, function ($form) {


//            $form->hasMany('sorg_with_og', __('商品'), function (Form\NestedForm $form) {
////                $form->display('shop_order_goods.shop_goods.thumb',__('商品封面'))->with(function ($thumb){
////                    return '<img src="'.env('APP_URL').'/storage/'. $thumb.'" style="width:100px;height:100px">';
////                });
//                $form->text('shop_order_goods.shop_goods.name',__('商品名称'))->readonly();
//                $form->display('shop_order_goods.num',__('数量'));
//                $form->text('shop_order_goods.shop_goods_spu.name',__('商品规格'))->readonly();
//                $form->text('shop_order_goods.shop_goods_spu.price',__('商品价格'))->readonly();
//
//            })->disableDelete()->disableCreate();



            $form->fieldset('快递', function (Form $form) {
                $form->select('shop_order_delivery.express_id', '快递名称')->options(Express::all()->pluck("name", "id"));
                $form->text('express_n', "快递单号");
            });

        });







        $form->tools(function (Form\Tools $tools) {


            // 去掉`删除`按钮
            $tools->disableDelete();

            $tools->disableView();

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
