<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);

        $grid->column('id', __('Id'));
        $grid->column('cate_id', __('Cate id'));
        $grid->column('user_id', __('User id'));
        $grid->column('thumb', __('封面'));
        $grid->column('title', __('标题'));
//        $grid->column('content', __('内容'));
        $grid->column('like', __('点赞数'));
        $grid->column('view', __('浏览量'));

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
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cate_id', __('Cate id'));
        $show->field('user_id', __('User id'));
        $show->field('thumb', __('封面'));
        $show->field('title', __('标题'));
        $show->field('content', __('内容'));
        $show->field('like', __('点赞数'));
        $show->field('view', __('浏览量'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article);
        $form->number('cate_id', __('Cate id'));
        $form->number('user_id', __('User id'));
        $form->text('thumb', __('封面'));
        $form->text('title', __('标题'));
        $form->textarea('content', __('内容'));
        $form->number('like', __('点赞数'));
        $form->number('view', __('浏览量'));

        return $form;
    }
}
