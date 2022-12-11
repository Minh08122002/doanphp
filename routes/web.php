<?php

use Illuminate\Support\Facades\Route;
use Illuminate\App\Http\Controllers;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TinController;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListUserController;
use App\Http\Controllers\QuanlibaidangController;
use App\Models\Tin;

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


Route::get('them-moi',[UserController::class, 'create'])->name('form-them-moi-tai-khoan');

Route::post('them-moi',[UserController::class,'store'])->name('them-moi-tai-khoan');

Route::get('tai-khoan',[UserController::class, 'index'])-> name('danh-sach-tai-khoan');

Route::get('dang-nhap',[LoginController::class,'create'])->name('login');

Route::post('login',[LoginController::class, 'xu_li_dang_nhap'])->name('dang-nhap');

Route::get('logout',[LoginController::class, 'logout'] )->name('logout')->middleware('auth');

Route::get('them-moi-tin',[TinController::class, 'create'])->name('form-them-moi-tin')->middleware('auth');

Route::post('them-moi-tin',[TinController::class,'store'])->name('them-moi-tin')->middleware('auth');

Route::get('home',[TinController::class, 'laytin'])-> name('home');

Route::get('/',[TinController::class,'laytin']);

Route::get('info',[UserController::class, 'infomation'])-> name('info')->middleware('auth');

Route::get('sua-info{id}',[UserController::class, 'ShowSuaThongTin'])-> name('suainfo')->middleware('auth');

Route::post('sua-info{id}',[UserController::class,'CapNhatThongTinUS'])->name('suathongtin')->middleware('auth');

Route::get('thong-tin-tin{id}',[TinController::class, 'lay1'])-> name('laytin');

Route::get('info/{id}',[TinController::class,'XoaBaiininfo'])->name('xoabaiuser');

Route::get('sua-tin{id}',[TinController::class, 'ShowSuaTin'])-> name('suatin')->middleware('auth');

Route::post('sua-tin{id}',[TinController::class,'CapNhatThongTin'])->name('acceptformsuatin')->middleware('auth');

Route::get('doimatkhau/{id}',[UserController::class, 'ShowSuaMatKhau'])->name('doimatkhaumoi')->middleware('auth');

Route::post('doimatkhau/{id}',[UserController::class,'CapNhatMatKhau'])->name('acceptdoimatkhau')->middleware('auth');

Route::get('home1',[TinController::class, 'getSearch'])-> name('homeSearch');

Route::get('admin',[LoginController::class,'trangadm'])->name('admin')->middleware('admin');

//menu
Route::get('add',[MenuController::class,'create'])->middleware('admin');
Route::post('add',[MenuController::class,'store'])->middleware('admin');
Route::get('list',[MenuController::class,'index'])->middleware('admin');
Route::get('/menus/edit/{menu}',[MenuController::class,'show'])->middleware('admin');
Route::post('/menus/edit/{menu}',[MenuController::class,'update'])->middleware('admin');
Route::get('/menus/destroy/{id}',[MenuController::class,'destroy'])->middleware('admin');

#qlnguoidung
Route::get('listuser',[ListUserController::class,'index'])->name('listuser')->middleware('admin');
Route::get('listuser/{i}',[ListUserController::class,'getAmount'])->name('ds-listuser')->middleware('admin');
Route::get('/listuser/destroy/{nguoi_dung_id}',[ListUserController::class,'destroy'])->name('listuser_xoa')->middleware('admin');

#qlbaidang
Route::get('listpost',[TinController::class,'index'])->name('listpost')->middleware('admin');
Route::get('/listpost/destroy/{id}',[TinController::class,'destroy'])->name('listpost_xoa')->middleware('admin');

Route::get('duyet-bai',[TinController::class,'duyetbai'])->name('duyetbai')->middleware('admin');
Route::get('/duyetbai/duyet/{id}',[TinController::class,'duyet'])->name('duyetbai_duyet')->middleware('admin');

