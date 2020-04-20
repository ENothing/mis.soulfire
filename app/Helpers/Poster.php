<?php
/**
 * Created by Eric-Nothing.
 * Date: 2020/4/17
 * Time: 13:27
 */

namespace App\Helpers;


use Illuminate\Support\Facades\Storage;

trait Poster
{

    /**
     * Created by Eric-Nothing.
     * @param $name -商品名称
     * @param $thumb -商品封面
     * @param $qrcode -小程序二维码
     */
    public function GoodsPoster($id,$name, $thumb, $qrcode,$price = 0.00,$old_price = 0.00)
    {


        $width = 375;
        $height = 667;
        $font = public_path("fonts\\msyh.ttf");
        $file = public_path("posters\\").$id . '.jpg';
        $logo = Storage::disk("images")->url("logo.jpg");

        $canvas = imagecreatetruecolor($width, $height);
        $background = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $background); //自定义画布的背景颜色


        $logo_info = getimagesize($logo);
        $logo_type = image_type_to_extension($logo_info[2], false);
        $logo_func = 'imagecreatefrom' . $logo_type;
        $logo_image = $logo_func($logo);
        imagecopyresampled($canvas, $logo_image, 17, 16, 0, 0, 70, 70, $logo_info[0], $logo_info[1]);


        $thumb_info = getimagesize($thumb);
        $thumb_type = image_type_to_extension($thumb_info[2], false);
        $thumb_func = 'imagecreatefrom' . $thumb_type;
        $thumb_image = $thumb_func($thumb);
        imagecopyresampled($canvas, $thumb_image, 17, 100, 0, 0, 340, 340, $thumb_info[0], $thumb_info[1]);


        $qr_info = getimagesize($qrcode);
        $qr_type = image_type_to_extension($qr_info[2], false);
        $qr_func = 'imagecreatefrom' . $qr_type;
        $qr_image = $qr_func($qrcode);
        imagecopyresampled($canvas, $qr_image, 200, 535, 0, 0, 100, 100, $qr_info[0], $qr_info[1]);


        $bc = imagecolorallocate($canvas, 0, 0, 0);
        $pc = imagecolorallocate($canvas, 232, 45, 45);
        $opc = imagecolorallocate($canvas, 119, 117, 117);
        $str1 = 'SoulFire乐焰';
        imagettftext($canvas, 15, 0, 100, 60, $bc, $font, $str1);


        $str2 = "￥".sprintf("%.2f",$price);
        $res=imagettfbbox(15,0,$font,$str2);
        $x=(440-$res[2]*2)/2;
        imagettftext($canvas, 15, 0, $x,470, $pc, $font, $str2);

        $str3 = sprintf("%.2f",$old_price);
        $box = imagettfbbox(10, 0, $font, $str3);
        $str3_width = $box[4] - $box[6];
        imagettftext($canvas, 10, 0,232 , 469, $opc, $font, $str3);
        imageline($canvas, 230, 463, 230+$str3_width+5, 463, $opc);


        $content = '';

        for ($i = 0; $i < mb_strlen($name); $i++) {
            $letter[] = mb_substr($name, $i, 1);
        }
        foreach ($letter as $l) {
            $teststr = $content . " " . $l;
            $fontBox = imagettfbbox(20, 0, $font, $teststr);
            if (($fontBox[2] > 640 * 0.9) && ($content !== "")) {
                $content .= "\n";
            }
            $content .= $l;
        }
        imagettftext($canvas, 11, 0, ceil((620 - $fontBox[2]) / 2), 493, $bc, $font, $content);


        $str5 = "长按识别";
        imagettftext($canvas, 11, 0, 65, 570, $bc, $font, $str5);
        $str6 = "扫一扫~";
        imagettftext($canvas, 11, 0, 70, 600, $bc, $font, $str6);

        header('content-type:image/jpeg');
        imagejpeg($canvas, $file, 100);
        imagedestroy($canvas);

    }


}