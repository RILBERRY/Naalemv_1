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

Route::resource('dashboard', CategoryController::class)->middleware('auth');
Route::resource('create', ShipmentController::class)->middleware('auth');
Route::resource('customer', CustomerController::class)->middleware('auth');
Route::resource('confirm', PackageController::class)->middleware('auth');
Route::resource('collect', CollectionController::class)->middleware('auth');
Route::resource('setting', SettingController::class)->middleware('auth');
Route::post('clam', [CollectionController::class, 'complete'])->middleware('auth');
Route::get('clam', [CollectionController::class, 'clam'])->middleware('auth');
Route::get('customerinfo', [CustomerController::class, 'customerInfo'])->middleware('auth');
Route::get('searchcate', [CategoryController::class, 'searchcate'])->middleware('auth');




