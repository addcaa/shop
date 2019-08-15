<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    //添加购物车
    public function add(){
        $u_id=Auth::id();

        if(empty($u_id)){
            echo "<script>alert('请先登录');location.href='http://fang.shop.com';</script>";

        }
        $goods_id=$_GET['id'];
        $num=$_GET['num'];
        if(empty($num)){
            return $arr=json_encode([
                'mag'=>"请添加购买数量",
                'on'=>0,
            ],JSON_UNESCAPED_UNICODE);
        }
        $u_id=Auth::id();
        $where=[
            'goods_id'=>$goods_id,
            'u_id'=>$u_id
        ];
        $cart=DB::table('shop_car')->where($where)->first();
        $arr=DB::table('shop_goods')->where(['goods_id'=>$goods_id])->first();
        $goods_goods_num=$arr->goods_num;

        if($cart){
            //有值
            $buy_number=$cart->buy_number;
            $gnum=$buy_number+$num;
//            dd($gnum);/
            if($gnum<=$goods_goods_num){
                $data=[
                    'buy_number'=>$gnum
                ];
                $upa=DB::table('shop_car')->where($where)->update($data);
                if($upa){
                    return $arr=json_encode([
                        'mag'=>"添加购物车成功",
                        'on'=>0,
                    ],JSON_UNESCAPED_UNICODE);
                }else{
                    return $arr=json_encode([
                        'mag'=>"添加购物车失败",
                        'on'=>1,
                    ],JSON_UNESCAPED_UNICODE);
                }
            }else{
                return $arr=json_encode([
                    'mag'=>"添加购物车失败",
                    'on'=>1,
                ],JSON_UNESCAPED_UNICODE);
            }

        }else{
            //没值
            $info=[
                'goods_id'=>$goods_id,
                'u_id'=>$u_id,
                'buy_number'=>$num,
            ];
            $car=DB::table('shop_car')->insert($info);
            if($car){
                return $arr=json_encode([
                    'mag'=>"添加购物车成功",
                    'on'=>0,
                ],JSON_UNESCAPED_UNICODE);
            }else{
                return $arr=json_encode([
                    'mag'=>"添加购物车失败",
                    'on'=>1,
                ],JSON_UNESCAPED_UNICODE);
            }
        }

    }

    //购物车页面
    public function list(){
        $u_id=Auth::id();
        if(empty($u_id)){
            echo "<script>alert('请先登录');location.href='http://fang.shop.com';</script>";
        }
        $arr=DB::select("select * from shop_goods  join shop_car on shop_goods.goods_id=shop_car.goods_id where shop_goods.status=1 and u_id=$u_id");

        $below=DB::select("select shop_goods.goods_id,shop_goods.goods_name,shop_goods.goods_price,shop_car.buy_number,shop_car.car_id from shop_goods  join shop_car on shop_goods.goods_id=shop_car.goods_id where status=2 and u_id=$u_id");
        return view('goods.cart',['arr'=>$arr,'below'=>$below]);
    }

    public function del(){
        $id = Auth::id();
        $below=DB::select("select shop_car.car_id from shop_goods  join shop_car on shop_goods.goods_id=shop_car.goods_id where status=2");
        foreach ($below as $v){
            $car_id=$v->car_id;
            $where=[
                'u_id'=>$id,
                'car_id'=>$car_id,
            ];
            $res=DB::table('shop_car')->where($where)->delete();
            if($res){
                return $arr=json_encode([
                    'mag'=>"删除成功",
                    'on'=>0,
                ],JSON_UNESCAPED_UNICODE);
            }else{
                return $arr=json_encode([
                    'mag'=>"删除失败",
                    'on'=>1,
                ],JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function judge(){
        $id = Auth::id();
        $below=DB::select("select shop_car.car_id from shop_goods  join shop_car on shop_goods.goods_id=shop_car.goods_id where status=2 and u_id=$id");
        if(empty($below)){
            return $arr=json_encode([
                'on'=>0,
            ],JSON_UNESCAPED_UNICODE);
        }else{
            return $arr=json_encode([
                'on'=>1,
            ],JSON_UNESCAPED_UNICODE);
        }
    }

    //删除购物车商品
    public function dele(){
        $id=$_GET['id'];
        $where=[
            'car_id'=>$id
        ];
        $res=DB::table('shop_car')->where($where)->delete();
        if($res){
            return $arr=json_encode([
                'mag'=>"删除成功",
                'on'=>0,
            ],JSON_UNESCAPED_UNICODE);
        }else{
            return $arr=json_encode([
                'mag'=>"删除失败",
                'on'=>1,
            ],JSON_UNESCAPED_UNICODE);
        }
    }

    //购物车 展示 + —
    public function aa(){
        $data=$_GET;
        $where=[
            'car_id'=>$data['car_id'],
        ];
        $cart_id=$data['car_id'];
//        dd($where);
        $upd=[
            'buy_number'=>$data['buy_number']
        ];
        $arr=DB::select("select shop_goods.goods_num from shop_goods  join shop_car on shop_goods.goods_id=shop_car.goods_id where shop_car.car_id=$cart_id");
        if(($arr[0]->goods_num)<$arr){
            $res=DB::table('shop_car')->where($where)->update($upd);
            if($res){
                return $arr=json_encode([
                    'on'=>0,
                ],JSON_UNESCAPED_UNICODE);
            }else{
                return $arr=json_encode([
                    'mag'=>"添加购物车失败",
                    'on'=>1,
                ],JSON_UNESCAPED_UNICODE);
            }
        }else{
            return $arr=json_encode([
                'mag'=>"已无库存",
                'on'=>1,
            ],JSON_UNESCAPED_UNICODE);
        }
    }

}
