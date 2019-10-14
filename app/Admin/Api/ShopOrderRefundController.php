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
use App\Models\ShopOrderRefund;
use Illuminate\Http\Request;

class ShopOrderRefundController extends Controller
{
    use ApiReturn;

    public function agree_refund(Request $request)
    {

        $id = $request->post('id');

        $order_refund = ShopOrderRefund::find($id);

        if (is_null($order_refund)){

            return $this->failed("数据不存在");
        }


        $order_refund->update([
            'status'=>2
        ]);

        return $this->success();
    }

    public function reject_refund(Request $request)
    {
        $id = $request->post('id');
        $reply_reason = $request->get('reply_reason');

        $order_refund = ShopOrderRefund::find($id);

        if (is_null($order_refund)){

            return $this->failed("数据不存在");
        }


        $order_refund->update([
            'status'=>4,
            'reply_reason'=>$reply_reason??""
        ]);

        return $this->success();

    }

    public function finish_refund(Request $request)
    {
        $id = $request->post('id');

        $order_refund = ShopOrderRefund::find($id);

        if (is_null($order_refund)){

            return $this->failed("数据不存在");
        }


        $order_refund->update([
            'status'=>3,
        ]);

        return $this->success();
    }

}