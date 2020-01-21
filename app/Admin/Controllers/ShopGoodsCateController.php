<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Actions\ShopGoodsCate\BatchLogicDelete;
use App\Admin\Extensions\Actions\ShopGoodsCate\LogicDelete;
use App\Models\ShopGoods;
use App\Models\ShopGoodsCate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopGoodsCateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ShopGoodsCate);
        $grid->disableFilter();
        $grid->column('id', __('Id'));
        $grid->column('name', __('类名'));
        $grid->column('icon_url', __('图标'))->image('', 100, 100);
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            // 去掉查看
            $actions->disableView();
            $actions->add(new LogicDelete());
        });
        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
            $batch->add(new BatchLogicDelete());
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
        $show = new Show(ShopGoodsCate::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('类名'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ShopGoodsCate);

        $form->text('name', __('类名'));
        $form->image('icon_url', __('图标'));
        $form->deleting(function (Form $form) {

            $id = request()->route()->parameters()['shop_goods_cate'];
            if (ShopGoods::where('cate_id',$id)->first()){

                return response()->json([
                    'status'  => false,
                    'message' => '分类已被使用',
                ]);

            }

        });
        return $form;
    }
}
