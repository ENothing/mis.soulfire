<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\ActivityCate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '活动列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Activity);

//        $grid->column('id', __('Id'));
        $grid->column('title', __('标题'));
        $grid->column('thumb', __('封面'))->image('', 150, 150);;
//        $grid->column('cate_id', __('活动分类'));
        $grid->activity_cate()->name(__('活动类型'));
//        $grid->column('content', __('内容'));
        $grid->column('person_limit', __('人数限制'));
        $grid->column('view', __('浏览数'));
        $grid->column('like', __('点赞数'));
        $grid->column('start_at', __('开始时间'));
        $grid->column('end_at', __('结束时间'));
        $grid->column('start_enter_at', __('开始报名时间'));
        $grid->column('end_enter_at', __('结束报名时间'));

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
        $show = new Show(Activity::findOrFail($id));

//        $show->field('id', __('Id'));
        $show->field('title', __('标题'));
        $show->field('thumb', __('封面'))->image('',250,250);
        $show->cate_id(__('活动分类'))->as(function ($cate_id){
            return ActivityCate::find($cate_id)->name;
        });
        $show->field('content', __('内容'))->unescape();
        $show->field('start_at', __('开始时间'));
        $show->field('end_at', __('结束时间'));
        $show->field('start_enter_at', __('开始报名时间'));
        $show->field('end_enter_at', __('结束报名时间'));
        $show->field('person_limit', __('人数限制'));
        $show->field('view', __('浏览数'));
        $show->field('like', __('点赞数'));
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
        $form = new Form(new Activity);

        $form->text('title', __('标题'));
        $form->image('thumb', __('封面'));
        $form->select('cate_id', __('活动分类'))->options(ActivityCate::all()->pluck("name","id"));
        $form->editor('content', __('内容'));
        $form->datetime('start_at', __('开始时间'))->default(date('Y-m-d H:i:s'));
        $form->datetime('end_at', __('结束时间'))->default(date('Y-m-d H:i:s'));
        $form->datetime('start_enter_at', __('开始报名时间'))->default(date('Y-m-d H:i:s'));
        $form->datetime('end_enter_at', __('结束报名时间'))->default(date('Y-m-d H:i:s'));
        $form->number('person_limit', __('人数限制'))->default(0)->min(0);
        $form->number('view', __('浏览数'))->default(0)->min(0);
        $form->number('like', __('点赞数'))->default(0)->min(0);

        return $form;
    }
}