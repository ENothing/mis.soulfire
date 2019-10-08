<?php

namespace App\Admin\Controllers;

use App\Models\Coupon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CouponController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '优惠券';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Coupon);
        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->expand();

            $filter->like('name', __('优惠券名'));
            $filter->in('type', __('	所属模块'))->checkbox([
                1 => '活动',
                2 => '商城',
            ]);
            $filter->in('coupon_type', __('	优惠方式'))->checkbox([
                1 => '满减',
                2 => '立减',
                3 => '打折',
            ]);
            $filter->between('created_at', __('创建时间'))->datetime();
            $filter->between('start_receive_time', __('领取开始时间'))->datetime();

        });
        $grid->column('id', __('Id'));
        $grid->column('name', __('优惠券名'));
        $grid->column('type', __('所属模块'))->using([1=>"活动",2=>"商城"])->label([
            1 => 'success',
            2 => 'primary',
        ]);
        $grid->column('coupon_type', __('优惠方式'))->display(function ($coupon_type) {
            switch ($coupon_type){
                case 1:
                    return '满 '.$this->full_price . ' 减 ' . $this->reduction_price;
                case 2:
                    return '立减 '.$this->immediately_price;
                case 3:
                    return $this->discount." 折";
            }
        });
//        $grid->column('full_price', __('满'));
//        $grid->column('reduction_price', __('减'));
//        $grid->column('immediately_price', __('立减金额'));
//        $grid->column('discount', __('打折'));
        $grid->column('start_receive_time', __('领取开始时间'))->sortable();
        $grid->column('end_receive_time', __('领取结束时间'));

        $grid->column('is_timeing', __('使用时间限制'))->display(function ($is_timeing) {
            switch ($is_timeing){
                case 0:
                    return "领取后 <span style='color: red'>".$this->day."</span> 天内可使用";
                case 1:
                    return $this->start_use_time." - ".$this->end_use_time;

            }
        });
//        $grid->column('start_use_time', __('开始使用时间'));
//        $grid->column('end_use_time', __('结束使用时间'));
//        $grid->column('day', __('领取后可使用天数'));
        $grid->column('created_at', __('创建时间'))->sortable();
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
        $show = new Show(Coupon::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('优惠券名'));
        $show->field('type', __('所属模块'));
        $show->field('coupon_type', __('优惠类型'));
        $show->field('full_price', __('满'));
        $show->field('reduction_price', __('减'));
        $show->field('immediately_price', __('立减金额'));
        $show->field('discount', __('打折'));
        $show->field('start_receive_time', __('领取开始时间'));
        $show->field('end_receive_time', __('领取结束时间'));
        $show->field('is_timeing', __('是否设置使用时间限制'));
        $show->field('start_use_time', __('开始使用时间'));
        $show->field('end_use_time', __('结束使用时间'));
        $show->field('day', __('领取后可使用天数'));
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
        $form = new Form(new Coupon);

        $form->text('name', __('优惠券名'))->rules('required');
        $form->radio('type', __('所属模块'))->options([1=>"活动",2=>"商城"])->default(2);
        $form->radio('coupon_type', __('优惠类型'))->options([1 => '满减', 2=> '立减',3=>"打折"])->default(1);
        $form->decimal('full_price', __('满'))->default(0.00);
        $form->decimal('reduction_price', __('减'))->default(0.00);
        $form->decimal('immediately_price', __('立减金额'))->default(0.00);
        $form->decimal('discount', __('打折'))->default(0.0);
        $form->datetimeRange('start_receive_time', 'end_receive_time', '领取时间')->rules('required');

        $states = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
        ];

        $form->switch('is_timeing', __('是否设置使用时间限制'))->states($states);
        $form->datetimeRange('start_use_time', 'end_use_time', '使用时间');
        $form->number('day', __('领取后可使用天数'))->min(0)->default(0);

        return $form;
    }
}
