<?php
/**
 * Created by Eric-Nothing.
 * Date: 2020/4/17
 * Time: 13:37
 */

namespace App\Http\Controllers\Api\V1;


use App\Helpers\Poster;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    use Poster;
    public function index()
    {

        $name = "测试商品";
        $thumb = "http://b-ssl.duitang.com/uploads/item/201903/21/20190321202037_Q5dXF.thumb.700_0.jpeg";
        $qrcode = Storage::disk("images")->url("logo.jpg");


        $this->GoodsPoster($name,$thumb,$qrcode);














    }



}