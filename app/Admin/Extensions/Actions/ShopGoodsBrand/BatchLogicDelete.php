<?php
/**
 * Created by Eric-Nothing.
 * Date: 2019/9/29
 * Time: 11:27
 */

namespace App\Admin\Extensions\Actions\ShopGoodsBrand;


use App\Models\ShopGoods;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchLogicDelete extends BatchAction
{

    public $name = '批量删除';

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {

            if (!ShopGoods::where('brand_id',$model->id)->first()){

                $model->delete();

            }

        }

        return $this->response()->success('成功删除未使用的品牌')->refresh();
    }

}