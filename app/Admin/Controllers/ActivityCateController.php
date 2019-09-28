<?php

namespace App\Admin\Controllers;

use App\Models\ActivityCate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityCateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '活动分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ActivityCate);
        $grid->disableFilter();
        $grid->column('id', __('Id'));
        $grid->column('name', __('类名'));

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
        $show = new Show(ActivityCate::findOrFail($id));

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
        $form = new Form(new ActivityCate);

        $form->text('name', __('类名'));

        return $form;
    }
}
