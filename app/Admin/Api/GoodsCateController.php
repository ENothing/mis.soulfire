<?php

namespace App\Admin\Api;

use App\Models\ShopGoodsBrand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsCateController extends Controller
{
    //

    public function brand(Request $request)
    {
        $q = $request->get('q');

        return ShopGoodsBrand::where('cate_id', $q)->get(['id', DB::raw('name as text')]);
    }

}
