<?php

namespace App\Admin\Controllers;

use App\Models\ShopGoodsBrand;
use App\Models\ShopGoodsCate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopGoodsBrandController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '品牌列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ShopGoodsBrand);

        $grid->column('id', __('Id'));
        $grid->column('name', __('品牌名称'));
        $grid->column('cate_id', __('所属商品分类'))->display(function ($cate_id){
            return ShopGoodsCate::find($cate_id)->name;

        });
        $grid->column('logo', __('Logo'))->image('',100,100);

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
        $show = new Show(ShopGoodsBrand::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('logo', __('Logo'));
        $show->field('cate_id', __('所属商品分类'));
        $show->field('name', __('品牌名称'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ShopGoodsBrand);

        $form->image('logo', __('Logo'));
        $form->select('cate_id', __('所属商品分类'))->options(ShopGoodsCate::all()->pluck("name","id"));
        $form->text('name', __('品牌名称'));

        return $form;
    }
}
