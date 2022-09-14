<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\SettingController;

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
    return redirect('/login');
});

Route::patch('/edit/{id}', [CollectionController::class,'edit'])->middleware('auth');
Route::get('/collect/search', [CollectionController::class, 'search'])->middleware('auth');
Route::post('clam', [CollectionController::class, 'complete'])->middleware('auth');
Route::get('clam', [CollectionController::class, 'clam'])->middleware('auth');
Route::get('customerinfo', [CustomerController::class, 'customerInfo'])->middleware('auth');
Route::get('searchcate', [CategoryController::class, 'searchcate'])->middleware('auth');
Route::get('/dashboard', [ShipmentController::class, 'island'])->middleware('auth');
Route::post('/dashboard/island', [ShipmentController::class, 'createIsland'])->middleware('auth');
Route::post('/setting/user', [SettingController::class,'AddNewUser'])->middleware('auth');
Route::patch('/setting/user/{id}', [SettingController::class,'update'])->middleware('auth');
Route::post('/setting/change', [SettingController::class,'ChangePassword'])->middleware('auth');


Route::resource('/category', CategoryController::class)->middleware('auth');
Route::resource('create', ShipmentController::class)->middleware('auth');
Route::resource('customer', CustomerController::class)->middleware('auth');
Route::resource('confirm', PackageController::class)->middleware('auth');
Route::resource('collect', CollectionController::class)->middleware('auth');
Route::resource('setting', SettingController::class)->middleware('auth');


