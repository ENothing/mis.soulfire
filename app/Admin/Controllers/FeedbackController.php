<?php

namespace App\Admin\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FeedbackController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '反馈及建议';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Feedback);
        $grid->disableCreateButton();

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->expand();

            $filter->like('title', __('标题'));
            $filter->like('user.nickname', __('用户昵称'));
            $filter->between('created_at', __('创建时间'))->datetime();

        });
        $grid->column('id', __('Id'));
        $grid->user('user_id')->nickname(__('用户昵称'));
        $grid->column('title', __('标题'));
        $grid->column('content', __('内容'));
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
        $show = new Show(Feedback::findOrFail($id));

        $show->field('id', __('Id'));
        $show->user('user_id')->nickname(__('用户昵称'));
        $show->field('title', __('标题'));
        $show->field('content', __('内容'));
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
        $form = new Form(new Feedback);

        $form->display('user_id', __('用户昵称'))->with(function ($user_id){

            return User::find($user_id)->nickname;

        });
        $form->text('title', __('标题'))->readonly();
        $form->text('content', __('内容'))->readonly();
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
