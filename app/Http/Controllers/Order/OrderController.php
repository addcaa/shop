<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    //结算展示
    public function lista(){
        $u_id = Auth::id();
        if (empty($u_id)) {
            echo "<script>alert('请先登录');location.href='http://fang.shop.com';</script>";
        }
        if (empty($_GET['car_id']) || empty($_GET['sum'])) {
            return $arr = json_encode([
                'mag' => "至少选择一件商品",
                'on' => 1,
            ], JSON_UNESCAPED_UNICODE);
        }
        $car_id=rtrim($_GET['car_id'], ',');
        $sum=$_GET['sum'];
        $arr=DB::select("select * from (shop_goods left join shop_car on shop_goods.goods_id=shop_car.goods_id) left join shop_commercial on shop_goods.c_id=shop_commercial.c_id  where  u_id=$u_id and  shop_car.car_id in($car_id)");
        foreach ($arr as $v){
            $arr=[
                'goods_name'=>$v->goods_name,
                'goods_price'=>$v->goods_price,
                'goods_price'=>$v->goods_price,
                'c_name'=>$v->c_name,
                'buy_number'=>$v->buy_number
            ];
            $info[]=$arr;
        }
        if($info){
            return $arr=json_encode([
                'data'=>$info,
                'sum'=>$sum,
                'on'=>0,
            ],JSON_UNESCAPED_UNICODE);
        }else{
            return $arr=json_encode([
                'mag'=>"结算失败",
                'on'=>1,
            ],JSON_UNESCAPED_UNICODE);
        }

    }
}
