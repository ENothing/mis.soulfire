<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\ActivityOrder;
use App\Models\ActivityOrderRefund;
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
        $grid->disableRowSelector();
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->expand();

            // 在这里添加字段过滤器
            $filter->like('user.nickname', '用户昵称');
            $filter->like('activity.title', '活动标题');
            $filter->equal('order_n', '订单编号');
            $filter->like('name', '姓名');
            $filter->equal('mobile', '手机号');
            $filter->between('created_at', __('创建时间'))->datetime();
        });
//        $grid->column('id', __('Id'));
        $grid->user()->nickname(__('用户昵称'));
        $grid->activity()->title(__('活动标题'));
        $grid->column('order_n', __('订单编号'));
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


        $grid->column("status", __('订单状态'))->display(function ($status) {


            $activity_order_refund = ActivityOrderRefund::find($this->refund_id);
            if ($activity_order_refund && $activity_order_refund->status != ActivityOrderRefund::CANCEL_REFUND && $activity_order_refund->status != ActivityOrderRefund::FAILD_REFUND){
                switch ($activity_order_refund->status){
                    case 0:
                        return '<span class="label-warning" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;发起退款';
                    case 2:
                        return '<span class="label-info" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;退款中';
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


        $grid->column('created_at', __('创建时间'))->sortable();
        $grid->column('updated_at', __('更新时间'));
        $grid->disableCreateButton();
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
        $show = new Show(ActivityOrder::findOrFail($id));

        $show->field('user_id', __('用户昵称'))->as(function ($user_id){

            return User::find($user_id)->nickname;

        });
        $show->field('activity_id', __('活动标题'))->as(function ($activity_id){

            return Activity::find($activity_id)->title;

        });
        $show->field('order_n', __('订单编号'));
        $show->field('name', __('姓名'));

        $show->sex(__('性别'))->using(['2' => '女', '1' => '男']);
        $show->field('mobile', __('手机号'));
        $show->field('unit_price', __('单价'));
        $show->field('person_num', __('人数'));
        $show->field('total_price', __('总价'));
        $show->field('discount_price', __('折扣金额'));
        $show->field('real_price', __('实际支付'));
        $show->field('status', __('订单状态'))->as(function ($val){

            switch ($val) {
                case 0:
                    $status = "待付款";
                    break;
                case 1:
                    $status = "已付款";
                    break;
                case 2:
                    $status = "已完成";
                    break;
                case 3:
                    $status = "已取消";
                    break;
                case 4:
                    $status = "发起退款";
                    break;
                case 5:
                    $status = "退款完成";
                    break;
                case 6:
                    $status = "退款失败";
                    break;
                default:
                    $status = "订单状态不存在";
            }

            return $status;


        });
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));
        $show->panel()
            ->tools(function ($tools) {
                $tools->disableDelete();
            });;
        $show->activity_pay_log('支付记录', function ($activity_pay_log) {

            $activity_pay_log->pay_sn(__('支付单号'));
            $activity_pay_log->status(__('支付状态'));
            $activity_pay_log->created_at(__('创建时间'));
            $activity_pay_log->updated_at(__('更新时间'));
            $activity_pay_log->panel()
                ->tools(function ($tools) {
                    $tools->disableEdit();
                    $tools->disableList();
                    $tools->disableDelete();
                });;
        });
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
        $form->tools(function (Form\Tools $tools) {

            // 去掉`删除`按钮
            $tools->disableDelete();

        });
        $form->select('user_id', __('用户昵称'))->options(User::all()->pluck("nickname","id"))->readOnly();
        $form->select('activity_id', __('活动标题'))->options(Activity::all()->pluck("title","id"))->readOnly();
        $form->text('name', __('姓名'))->readonly();
        $form->display('sex', __('性别'))->with(function ($sex){
            return $sex == 1?'男':'女';
        })->readOnly();
        $form->mobile('mobile', __('手机号'))->readonly();
        $form->decimal('unit_price', __('单价'))->default(0.00)->readonly();
        $form->text('person_num', __('人数'))->readonly();
        $form->decimal('total_price', __('总价'))->default(0.00)->readonly();
        $form->decimal('discount_price', __('折扣金额'))->default(0.00)->readonly();
        $form->decimal('real_price', __('实际支付'))->default(0.00)->readonly();
        $form->display('status', __('订单状态'))->with(function ($status){

            $activity_order_refund = ActivityOrderRefund::find($this->refund_id);
            if ($activity_order_refund && $activity_order_refund->status != ActivityOrderRefund::CANCEL_REFUND && $activity_order_refund->status != ActivityOrderRefund::FAILD_REFUND){
                switch ($activity_order_refund->status){
                    case 0:
                        return '<span class="label-warning" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;发起退款';
                    case 2:
                        return '<span class="label-info" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;退款中';
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
