<?php

namespace App\Http\Controllers\AList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
class ListController extends Controller
{
    //商品展示
    public function lista(){
        $arr=DB::table('shop_goods')->get();
        return view('goods.list',['arr'=>$arr]);
    }
}
