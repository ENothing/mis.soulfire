<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Actions\ShopGoodsBrand\BatchLogicDelete;
use App\Admin\Extensions\Actions\ShopGoodsBrand\LogicDelete;
use App\Models\ShopGoods;
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
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->expand();
            // 在这里添加字段过滤器
            $filter->like('name',__('品牌名称'));
            $filter->equal('cate_id',__('所属商品分类'))->select(ShopGoodsCate::all()->pluck("name","id"));
        });
        $grid->column('id', __('Id'));
        $grid->column('name', __('品牌名称'));
        $grid->column('cate_id', __('所属商品分类'))->display(function ($cate_id){
            return ShopGoodsCate::find($cate_id)->name;

        });
        $grid->column('logo', __('Logo'))->image('',100,100);
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            // 去掉查看
            $actions->disableView();
            $actions->add(new LogicDelete);
        });
        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
            $batch->add(new BatchLogicDelete);
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

        $form->hidden('id');
        $form->image('logo', __('Logo'));
        $form->select('cate_id', __('所属商品分类'))->options(ShopGoodsCate::all()->pluck("name","id"));
        $form->text('name', __('品牌名称'));
        $form->footer(function ($footer) {

            // 去掉`重置`按钮
            $footer->disableReset();

            // 去掉`查看`checkbox
            $footer->disableViewCheck();


        });

        $form->deleting(function (Form $form) {

            $id = request()->route()->parameters()['shop_goods_brand'];

            if (ShopGoods::where('brand_id',$id)->first()){

                return response()->json([
                    'status'  => false,
                    'message' => '品牌已被使用',
                ]);

            }

        });

        return $form;
    }
}
