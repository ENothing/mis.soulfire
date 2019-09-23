<?php

namespace App\Admin\Controllers;

use App\Models\BannerCate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BannerCateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '轮播分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BannerCate);

        $grid->column('id', __('Id'));
        $grid->column('name', __('类名'));
        $grid->actions(function ($actions) {

            // 去掉删除
            $actions->disableDelete();

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
        $show = new Show(BannerCate::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('类名'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new BannerCate);

        $form->text('name', __('类名'));

        return $form;
    }
}
