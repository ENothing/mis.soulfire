<?php
/**
 * Created by Eric-Nothing.
 * Date: 2019/9/29
 * Time: 11:20
 */

namespace App\Admin\Extensions\Actions\Level;


use App\Models\ShopGoods;
use App\Models\UserLevel;
use Encore\Admin\Grid\Actions\Delete;
use Illuminate\Database\Eloquent\Model;

class LogicDelete extends Delete
{

    public function handle(Model $model)
    {
        $trans = [
            'failed'    => trans('admin.delete_failed'),
            'succeeded' => trans('admin.delete_succeeded'),
        ];

        try {

            if (UserLevel::where('level_id',$model->id)->first()){

                return $this->response()->error("等级已被使用");
            }

            $model->delete();

        } catch (\Exception $exception) {
            return $this->response()->error("{$trans['failed']} : {$exception->getMessage()}");
        }

        return $this->response()->success($trans['succeeded'])->refresh();
    }
}