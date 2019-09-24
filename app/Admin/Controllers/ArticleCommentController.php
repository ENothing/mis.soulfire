<?php

namespace App\Admin\Controllers;

use App\Models\ArticleComment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleCommentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章评论列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ArticleComment);

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('article_id', __('Article id'));
        $grid->column('content', __('内容'));
        $grid->column('parent_id', __('Parent id'));
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
        $show = new Show(ArticleComment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('article_id', __('Article id'));
        $show->field('content', __('内容'));
        $show->field('parent_id', __('Parent id'));
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
        $form = new Form(new ArticleComment);

        $form->number('user_id', __('User id'));
        $form->number('article_id', __('Article id'));
        $form->textarea('content', __('内容'));
        $form->number('parent_id', __('Parent id'));

        return $form;
    }
}
