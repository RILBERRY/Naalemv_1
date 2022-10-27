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
Route::middleware('auth')->group(function () {
    Route::get('customer/dashboard', [CustomerController::class, 'dashboard']);
    Route::get('customer/schedule', [CustomerController::class, 'schedule']);
    Route::get('customer/transaction', [CustomerController::class, 'transaction']);
    Route::get('customer/settlement', [CustomerController::class, 'settlement']);
    Route::get('customer/setting', [CustomerController::class, 'setting']);
    Route::get('customer/logout', [CustomerController::class, 'logout']);

    Route::patch('/edit/{id}', [CollectionController::class,'edit']);
    Route::get('/collect/search', [CollectionController::class, 'search']);
    Route::post('clam', [CollectionController::class, 'complete']);
    Route::get('clam', [CollectionController::class, 'clam']);
    Route::get('customerinfo', [CustomerController::class, 'customerInfo']);
    Route::get('searchcate', [CategoryController::class, 'searchcate']);
    Route::get('/dashboard', [ShipmentController::class, 'island']);
    Route::post('/dashboard/island', [ShipmentController::class, 'createIsland']);
    Route::post('/setting/user', [SettingController::class,'AddNewUser']);
    Route::patch('/setting/user/{id}', [SettingController::class,'update']);
    Route::patch('/setting/dathuru/{id}', [SettingController::class,'dathuruUpdate']);
    Route::post('/setting/change', [SettingController::class,'ChangePassword']);
    Route::post('/setting/dathuru', [SettingController::class,'dathuru']);


    Route::resource('/category', CategoryController::class);
    Route::resource('create', ShipmentController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('confirm', PackageController::class);
    Route::resource('collect', CollectionController::class);
    Route::resource('setting', SettingController::class);
});
// must add auth


