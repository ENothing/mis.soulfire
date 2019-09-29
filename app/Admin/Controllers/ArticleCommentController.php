<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\User;
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
    protected $title = '文章评论管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ArticleComment);
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->expand();
            // 在这里添加字段过滤器
            $filter->like('user.nickname',__('昵称'));
            $filter->like('article.title',__('文章标题'));
            $filter->between('created_at',  __('开始时间'))->datetime();
        });
        $grid->column('id', __('Id'));
        $grid->user()->nickname(__('昵称'));
        $grid->article()->title(__('文章标题'));
        $grid->column('content', __('内容'))->display(function ($content){

            if ($this->parent_id != 0){

                $article_comment= ArticleComment::with(['user'])->find($this->parent_id);
                return "回复 ".$article_comment->user->nickname . " : ".$content;
            }

            return $content;

        });
//        $grid->column('parent_id', __('Parent id'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));
        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });
        $grid->disableCreateButton();

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
        $show->field('user_id', __('User id'))->as(function ($user_id){
            return User::find($user_id)->nickname;
        });
        $show->field('article_id', __('Article id'))->as(function ($article_id){
            return Article::find($article_id)->title;
        });
        $show->field('content', __('内容'));
//        $show->field('parent_id', __('Parent id'));
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
        $form->tools(function (Form\Tools $tools) {

            // 去掉`查看`按钮
            $tools->disableView();

        });
        $form->select('user_id', __('用户昵称'))->options(User::all()->pluck('nickname','id'))->readOnly();
        $form->select('article_id', __('文章标题'))->options(Article::all()->pluck('title','id'))->readOnly();
        $form->textarea('content', __('内容'))->with(function ($content){


            if ($this->parent_id != 0){

                $article_comment= ArticleComment::with(['user'])->find($this->parent_id);
                return "回复 ".$article_comment->user->nickname . " : ".$content;
            }

            return $content;



        })->readonly();
        $form->footer(function ($footer) {

            // 去掉`重置`按钮
            $footer->disableReset();

            // 去掉`提交`按钮
            $footer->disableSubmit();

            // 去掉`查看`checkbox
            $footer->disableViewCheck();

            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();

            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });
        return $form;
    }
}
