<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function goods(){
        return view('admin.goods');
    }

    public function goodsdo(){
        $_POST['c_id']=2;

        $arr=DB::table('goods')->insert($_POST);

    }
}
