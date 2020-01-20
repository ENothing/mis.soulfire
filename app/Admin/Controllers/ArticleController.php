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
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->expand();
            // 在这里添加字段过滤器
            $filter->like('title',__('标题'));
            $filter->like('user.nickname',__('作者'));
            $filter->equal('cate_id',__('文章类型'))->select(ArticleCate::all()->pluck("name","id"));
            $filter->between('start_at',  __('开始时间'))->datetime();
            $filter->between('start_enter_at', __('开始报名时间'))->datetime();
        });
        $grid->column('id', __('Id'));
        $grid->column('title', __('标题'));
        $grid->user()->nickname(__('作者'));
        $grid->article_cate()->name(__('文章类型'));
        $grid->column('thumb', __('封面'))->image('',150,150);
//        $grid->column('content', __('内容'));
        $grid->column('likes', __('点赞数'))->sortable();
        $grid->column('view', __('浏览量'))->sortable();
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
        $form->number('likes', __('点赞数'))->min(0)->default(0);
        $form->number('view', __('浏览量'))->min(0)->default(0);

        return $form;
    }
}
