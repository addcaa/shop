<?php

namespace App\Http\Controllers\LogPort;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class LogPortController extends Controller
{
    public function log(){
//        $a=password_hash('fang',CRYPT_BLOWFISH );
        $name=$_POST['name'];
        $user=DB::table('users')->where(['name'=>$name])->first();
        if($user){
            $pwd=$_POST['password'];
            if(password_verify($pwd,$user->password)){
                $token=str_shuffle(Str::random(10).md5("cuifang")).'id'.$user->id;
                $key='cuifangid:'.$user->id;
                Redis::set($key,$token);
                Redis::EXPIRE($key,604800);
                dd(Redis::get($key  ));
                return $arr=json_encode([
                    'error'=>0,
                    'mag'=>"登陆成功",
                    'token'=>Redis::get($key)
                ],JSON_UNESCAPED_UNICODE);
            }else{
                return $arr=json_encode([
                    'error'=>20000,
                    'mag'=>"密码错误",
                ],JSON_UNESCAPED_UNICODE);
            }
        }else{
            return $arr=json_encode([
                'error'=>10000,
                'mag'=>"没有此用户请先注册",
            ],JSON_UNESCAPED_UNICODE);
        }
    }
}
