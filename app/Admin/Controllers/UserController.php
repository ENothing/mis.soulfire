<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\UserLevel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $grid->disableCreateButton();
//        $grid->column('id', __('Id'));
        $grid->column('nickname', __('昵称'));
        $grid->column('openid', __('Openid'));
        $grid->column('level',__('等级'))->display(function () {

            $level = UserLevel::with("level")->where('user_id',$this->id)->first();

            return $level->level->name;

        });
        $grid->column('head_url','头像')->image('',95,95);
        $grid->column('mobile', __('手机号'));
        $grid->column('email', __('邮箱'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));
//        $grid->column('deleted_at', __('Deleted at'));
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
        $show = new Show(User::findOrFail($id));

//        $show->field('id', __('Id'));
        $show->field('nickname', __('昵称'));
        $show->field('openid', __('Openid'));
//        $show->field('head_url', __('头像'));
        $show->head_url('头像')->image();
        $show->field('mobile', __('手机号'));
        $show->field('email', __('邮箱'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));
//        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

//        $form->text('openid', __('Openid'));
        $form->text('nickname', __('昵称'))->readonly();
//        $form->text('head_url', __('头像'))->readonly();
        $form->image('head_url','头像');
        $form->mobile('mobile', __('手机号'));
        $form->email('email', __('邮箱'));

        return $form;
    }
}
