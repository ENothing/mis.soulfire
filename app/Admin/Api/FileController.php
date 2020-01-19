<?php

namespace App\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $urls = [];
        $disk = Storage::disk('qiniu');
        foreach ($request->file() as $file) {

            $disk->put('images',$file);
            $urls[] = $disk->imagePreviewUrl($disk->lastReturn()["key"]);

        }

        return [
            "errno" => 0,
            "data"  => $urls,
        ];
    }
}
