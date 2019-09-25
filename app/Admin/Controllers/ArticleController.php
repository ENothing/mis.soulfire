<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\ArticleCate;
use App\Models\User;
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
    protected $title = '文章管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);

        $grid->column('id', __('Id'));
        $grid->column('title', __('标题'));
        $grid->user()->nickname(__('作者'));
        $grid->article_cate()->name(__('文章类型'));
        $grid->column('thumb', __('封面'))->image('',150,150);
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
        $show->field('title', __('标题'));
        $show->field('thumb', __('封面'))->image('',250,250);
        $show->field('cate_id', __('Cate id'))->as(function ($cate_id){
            return ArticleCate::find($cate_id)->name;


        });
        $show->field('user_id', __('User id'))->as(function ($user_id){

            return User::find($user_id)->nickname;

        });
        $show->field('content', __('内容'))->unescape();
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

        $form->text('title', __('标题'));
        $form->image('thumb', __('封面'));
        $form->select('cate_id', __('文章分类'))->options(ArticleCate::all()->pluck("name","id"));
        $form->select('user_id', __('作者'))->options(User::all()->pluck("nickname","id"));
        $form->editor('content', __('内容'));
        $form->number('like', __('点赞数'))->min(0)->default(0);
        $form->number('view', __('浏览量'))->min(0)->default(0);

        return $form;
    }
}
