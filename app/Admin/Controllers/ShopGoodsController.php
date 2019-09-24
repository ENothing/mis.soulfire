<?php

namespace App\Admin\Controllers;

use App\Models\ShopGoods;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopGoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ShopGoods);

        $grid->column('id', __('Id'));
        $grid->column('cate_id', __('Cate id'));
        $grid->column('brand_id', __('Brand id'));
        $grid->column('name', __('商品名称'));
        $grid->column('thumb', __('封面'));
        $grid->column('banners', __('商品banner'));
        $grid->column('goods_content', __('商品内容'));
        $grid->column('cur_price', __('现价'));
        $grid->column('ori_price', __('原价'));
        $grid->column('stock', __('库存'));
        $grid->column('sold', __('已售'));
        $grid->column('is_level', __('是否参与等级'));
        $grid->column('level_id', __('Level id'));
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
        $show = new Show(ShopGoods::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cate_id', __('Cate id'));
        $show->field('brand_id', __('Brand id'));
        $show->field('name', __('商品名称'));
        $show->field('thumb', __('封面'));
        $show->field('banners', __('商品banner'));
        $show->field('goods_content', __('商品内容'));
        $show->field('cur_price', __('现价'));
        $show->field('ori_price', __('原价'));
        $show->field('stock', __('库存'));
        $show->field('sold', __('已售'));
        $show->field('is_level', __('是否参与等级'));
        $show->field('level_id', __('Level id'));
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
        $form = new Form(new ShopGoods);

        $form->number('cate_id', __('Cate id'));
        $form->number('brand_id', __('Brand id'));
        $form->text('name', __('商品名称'));
        $form->text('thumb', __('封面'));
        $form->textarea('banners', __('商品banner'));
        $form->textarea('goods_content', __('商品内容'));
        $form->decimal('cur_price', __('现价'))->default(0.00);
        $form->decimal('ori_price', __('原价'))->default(0.00);
        $form->number('stock', __('库存'))->default(0);
        $form->number('sold', __('已售'))->default(0);
        $form->number('is_level', __('是否参与等级'));
        $form->number('level_id', __('Level id'));

        return $form;
    }
}
