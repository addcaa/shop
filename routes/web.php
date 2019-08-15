<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//商品展示
Route::get('Goodslist/list', 'AList\ListController@lista');
//添加购物车
Route::get('Goodscret/add', 'Cart\CartController@add');
//添加购物车 查看购物车库存是否超标
Route::get('Goodscret/surpass', 'Cart\CartController@surpass');
Route::get('Goodscret/list', 'Cart\CartController@list');
//删除已下架的商品
Route::get('Goodscret/del', 'Cart\CartController@del');
Route::get('Goodscret/judge', 'Cart\CartController@judge');
//删除要购物车商品
Route::get('Goodscret/dele', 'Cart\CartController@dele');
//购物车 展示 + —
Route::get('Goodscret/aa', 'Cart\CartController@aa');

//结算
Route::get('Order/lista', 'Order\OrderController@lista');

Route::get('admin/goods', 'Admin\AdminController@goods');
Route::post('admin/goodsdo', 'Admin\AdminController@goodsdo');





Route::post('login/log', 'LogPort\LogPortController@log');
