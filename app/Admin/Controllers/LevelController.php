<?php

namespace App\Admin\Controllers;

use App\Models\Level;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LevelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '等级管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Level);

        $grid->column('id', __('Id'));
        $grid->column('name', __('等级名'));
        $grid->column('experience', __('经验值'));

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
        $show = new Show(Level::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('等级名'));
        $show->field('experience', __('经验值'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Level);

        $form->text('name', __('等级名'));
        $form->decimal('experience', __('经验值'));

        return $form;
    }
}
