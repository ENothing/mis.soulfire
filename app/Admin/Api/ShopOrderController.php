<?php
/**
 * Created by Eric-Nothing.
 * Date: 2019/10/11
 * Time: 10:13
 */

namespace App\Admin\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ApiReturn;
use App\Models\ActivityOrderRefund;
use App\Models\Express;
use App\Models\ShopOrder;
use App\Models\ShopOrderDelivery;
use App\Models\ShopOrderRefund;
use Illuminate\Http\Request;

class ShopOrderController extends Controller
{
    use ApiReturn;

    public function order_ship(Request $request)
    {

        $id = $request->post('id');
        $express_id = $request->post('express_id');
        $delivery_n = $request->post('delivery_n');

        $order = ShopOrder::find($id);

        if (is_null($order)) {

            return $this->failed("数据不存在");
        }


        if (!empty($express_id)) {


            $express = Express::find($express_id);

            if (is_null($express)) {

                return $this->failed("物流公司信息不存在");

            }




        }
        ShopOrderDelivery::create([
            'order_id' => $id,
            'name' => $express->name ?? "",
            'abbreviation' => $express->shortName??"",
            'delivery_n' => $delivery_n??"",
            'express_id' => $express_id??0,
        ]);

        $order->update([
            'status' => 3
        ]);

        return $this->success();
    }


    /**
     * Created by Eric-Nothing.
     * 更新快递单号
     */
    public function modify_delivery(Request $request)
    {

        $id = $request->post('id');
        $express_id = $request->post('express_id');
        $delivery_n = $request->post('delivery_n');

        $express = Express::find($express_id);

        if (is_null($express)) {

            return $this->failed("物流公司信息不存在");

        }

        $order_delivery = ShopOrderDelivery::where('order_id',$id)->first();

        if (is_null($order_delivery)) {

            ShopOrderDelivery::create([
                'order_id' => $id,
                'name' => $express->name,
                'abbreviation' => $express->number,
                'delivery_n' => $delivery_n,
                'express_id' => $express_id,
            ]);

            return $this->success("快递信息更新成功");

        }

        $order_delivery->update([
            'name' => $express->name,
            'abbreviation' => $express->number,
            'delivery_n' => $delivery_n,
            'express_id' => $express_id,
        ]);

        return $this->success("快递信息更新成功");


    }

    public function finish_order(Request $request)
    {
        $id = $request->post('id');
        $order = ShopOrder::find($id);

        if (is_null($order)) {

            return $this->failed("数据不存在");
        }

        $order->update([
            'status' => 4,
            'completed_at'=>date('Y-m-d H:i:s')
        ]);

        return $this->success();
    }


}
