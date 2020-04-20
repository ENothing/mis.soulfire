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

        $name = "Jordan官方JORDAN CHINESE NEW YEAR男子针织套头衫新年款CU2323";
        $thumb = "http://soulfire-media.ericnothing.cn/images/O1CN01LaHvrD1WgghA9wisT_!!0-item_pic.jpg_180x180.jpg";
        $qrcode = Storage::disk("images")->url("qrcode.jpg");
        $id = 1;


        $this->GoodsPoster($id,$name,$thumb,$qrcode,799.01,1299);














    }



}