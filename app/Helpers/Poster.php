<?php
/**
 * Created by Eric-Nothing.
 * Date: 2020/4/17
 * Time: 13:27
 */

namespace App\Helpers;


trait Poster
{

    /**
     * Created by Eric-Nothing.
     * @param $name-商品名称
     * @param $thumb-商品封面
     * @param $qrcode-小程序二维码
     */
    public function GoodsPoster($name,$thumb,$qrcode)
    {


        $width = 375;
        $height = 667;
        $canvas = imagecreatetruecolor($width, $height);



        imagepng($canvas,app_path('app/public').'/posters/1.png');
        imagedestroy($canvas);
















    }

}