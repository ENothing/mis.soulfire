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
        $grid->disableRowSelector();
//        $grid->column('id', __('Id'));

        $grid->filter(function($filter){
            $filter->expand();
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('nickname', '昵称');
            $filter->equal('openid', 'Openid');
            $filter->equal('mobile', '手机号');
            $filter->between('created_at', __('创建时间'))->datetime();
        });


        $grid->column('nickname', __('昵称'));
        $grid->column('openid', __('Openid'));
        $grid->column('level',__('等级'))->display(function () {

            $level = UserLevel::with("level")->where('user_id',$this->id)->first();

            return $level->level->name;

        });
        $grid->column('head_url','头像')->image('',95,95);
        $grid->column('mobile', __('手机号'));
        $grid->column('email', __('邮箱'));
        $states = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'info'],
        ];
        $grid->column('is_ban', __('是否禁用'))->switch($states)->filter([
            0 => '否',
            1 => '是',
        ]);;
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));
//        $grid->column('deleted_at', __('Deleted at'));
        $grid->actions(function ($actions) {

            // 去掉删除
            $actions->disableDelete();
            $actions->disableView();

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
        $form->image('head_url','头像')->readonly();
        $form->mobile('mobile', __('手机号'))->readonly();
        $form->email('email', __('邮箱'))->readonly();
        $form->display("user_id",__('等级'))->with(function (){


            $level = UserLevel::with("level")->where('user_id',$this->id)->first();

            return $level->level->name;


        });
        $form->display("parent_id",__('邀请人'))->with(function ($parent_id){


            if ($parent_id == 0){

                return "暂无";

            }


            return User::find($parent_id)->nickname;


        });
        $form->text('invitation_code', __('邀请码'))->readonly();
        $states = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'info'],
        ];

        $form->switch('is_ban', __('是否禁用'))->states($states);
        $form->tools(function (Form\Tools $tools) {
            // 去掉`删除`按钮
            $tools->disableDelete();
            // 去掉`查看`按钮
            $tools->disableView();

        });
        $form->footer(function ($footer) {

            // 去掉`重置`按钮
            $footer->disableReset();

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
