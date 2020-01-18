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

        foreach ($request->file() as $file) {
            $urls[] = Storage::url($file->store("public/images"));
        }

        return [
            "errno" => 0,
            "data"  => $urls,
        ];
    }
}
