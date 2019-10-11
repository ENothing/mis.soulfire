<?php
/**
 * Created by Eric-Nothing.
 * Date: 2019/10/11
 * Time: 10:38
 */

namespace App\Helpers;

use Illuminate\Http\Response as Status;
use Illuminate\Support\Facades\Response;

trait ApiReturn
{
    protected $success = Status::HTTP_OK;
    protected $error = Status::HTTP_INTERNAL_SERVER_ERROR;
    protected $validate = Status::HTTP_BAD_REQUEST;

    public function success($data = [], string $message = '操作成功', $header = [])
    {

        return Response::json(['code' => $this->success, 'msg' => $message, 'data' => $data], $this->success, $header);
    }

    public function failed(string $message = '操作失败', $code = Status::HTTP_INTERNAL_SERVER_ERROR, $header = [])
    {

        return Response::json(['code' => $code ?? $this->error, 'msg' => $message], $this->success, $header);
    }

    public function vali(string $message = '验证失败', $header = [])
    {

        return Response::json(['code' => $this->validate, 'msg' => $message], $this->success, $header);

    }


}