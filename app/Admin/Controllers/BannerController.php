<?php

namespace App\Admin\Controllers;

use App\Models\Banner;
use App\Models\BannerCate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BannerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '轮播管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner);
        $grid->disableFilter();
        $grid->disableExport();
        $grid->column('id', __('Id'));
        $grid->banner_cate('id')->name(__('分类'));
        $grid->column('thumb','图片')->image('',150,250);
        $grid->column('url', __('链接'))->link();
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
        $show = new Show(Banner::findOrFail($id));

        $show->field('id', __('Id'));
        $show->thumb( __('图片'))->image();
        $show->field('url', __('链接'));
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
        $form = new Form(new Banner);

        $form->select('cate_id', __('分类'))->options(BannerCate::all()->pluck("name","id"));
        $form->image('thumb', __('图片'));
        $form->file("video_url","视频");
        $form->text('url', __('链接'));
        $form->text('content', __('短文本'));
        $form->radio('show_type', __('展示类型'))->options([0 => '多媒体', 1=> '文字'])->default(0);
        return $form;
    }
}
