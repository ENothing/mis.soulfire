<?php

namespace App\Admin\Controllers;

use App\Models\Level;
use App\Models\ShopGoods;
use App\Models\ShopGoodsBrand;
use App\Models\ShopGoodsCate;
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
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->expand();
            // 在这里添加字段过滤器
            $filter->like('name',__('商品名称'));
            $filter->like('article.title',__('文章标题'));
            $filter->equal('cate_id',__('商品分类'))->select(ShopGoodsCate::all()->pluck("name","id"));
            $filter->equal('brand_id',__('品牌分类'))->select(ShopGoodsBrand::all()->pluck("name","id"));
            $filter->between('created_at',  __('开始时间'))->datetime();
        });
        $grid->column('id', __('Id'));
        $grid->column('name', __('商品名称'));
        $grid->shop_goods_cate('cate_id')->name(__('商品分类'));
        $grid->shop_goods_brand('brand_id')->name(__('品牌分类'));
        $grid->column('thumb', __('封面'))->image('', 150, 150);
        $grid->column('cur_price', __('现价'))->sortable();
        $grid->column('ori_price', __('原价'))->sortable();
        $grid->column('stock', __('库存'))->sortable();
        $grid->column('sold', __('已售'))->sortable();
//        $grid->column('is_level', __('是否参与等级'))->display(function ($is_level) {
//
//            return $is_level == 0 ? "否" : "是";
//
//        })->filter([1=>"是",0=>"否"]);
//        $grid->level('level_id')->name(__('等级名称'));

        $states = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger'],
        ];
        $grid->column('is_shelf', __('是否上架'))->switch($states);
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


        // 在这一列中加入表单项

        $form->text('name', __('商品名称'));
//        $form->select('cate_id', __('商品分类'))->options(ShopGoodsCate::all()->pluck("name", "id"))->load('brand_id', '/admin/api/brands');
        $form->select('cate_id', __('商品分类'))->options(ShopGoodsCate::all()->pluck("name", "id"));
        $form->select('brand_id', __('品牌分类'))->options(ShopGoodsBrand::all()->pluck("name", "id"));
        $form->image('thumb', __('封面'));
        $form->multipleImage('banners', __('商品banner'))->removable()->sortable();
        $form->decimal('cur_price', __('现价'))->default(0.00);
        $form->decimal('ori_price', __('原价'))->default(0.00);
        $form->number('stock', __('库存'))->default(0)->min(0);
        $form->number('sold', __('已售'))->default(0)->min(0);
//        $form->radio('is_level', __('是否参与等级'))->options(['1' => '是', '0' => '否'])->default('0');
//        $form->select('level_id', __('等级'))->options(Level::all()->pluck("name", 'id'));

        $form->hasMany("shop_goods_spu", __('规格'), function (Form\NestedForm $form) {
            $form->text('name', __('规格名'));
            $form->decimal('price', __('价格'));
            $form->number('stock', __('库存'))->min(0);
        });
        $states = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger'],
        ];
        $form->switch('is_shelf', __('是否上架'))->states($states);

        $form->editor('goods_content', __('商品内容'));

        $form->saved(function (Form $form) {

            var_dump($form->model()->id);

        });

        return $form;
    }
}
