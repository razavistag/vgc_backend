<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PoController;
use App\Http\Controllers\ReceivinglogenteryController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:api');


Route::group(['middleware' => 'auth:api'], function () {

    // USER ROUTES
    Route::get('user/mailList', [AuthController::class, 'mailList']);
    Route::get(
        'user',
        [AuthController::class, 'index']
    );
    Route::get('user/search/{find}', [AuthController::class, 'search']);
    Route::get('user/{id}', [AuthController::class, 'show']);
    Route::delete('user/{id}', [AuthController::class, 'destroy']);
    Route::put('user/{id}', [AuthController::class, 'update']);
    Route::put('user/profileUpdate/{id}', [AuthController::class, 'profileUpdate']);
    Route::get('user/get_city_autocomplete/{find}', [AuthController::class, 'get_ac_city_additional']);
    Route::get('user/get_ac_country_additional/{find}', [AuthController::class, 'get_ac_country_additional']);


    // DASHBOARD ROUES
    Route::get('dashboard/statment', [AuthController::class, 'dashboardStatment']);


    // ORDER ROUTES
    Route::get('order', [OrderController::class, 'index']);
    Route::get('order/auto_search/{type}/{find}', [OrderController::class, 'autoComplete']);
    Route::delete('order/{id}', [OrderController::class, 'destroy']);
    Route::delete('order/attachment/{id}', [OrderController::class, 'destroyAttachment']);
    Route::post('order', [OrderController::class, 'store']);
    Route::get('order/edit/{find}', [OrderController::class, 'edit']);
    Route::get('order/getAttachments/{find}', [OrderController::class, 'getAttachments']);
    Route::put('order/{id}', [OrderController::class, 'update']);
    Route::get('order/getOrderList/{find}', [OrderController::class, 'show']);
    Route::get('order/status/{find}', [OrderController::class, 'getStatus']);
    Route::put('order/statusupdate/{id}', [OrderController::class, 'updateStatus']);

    Route::get('po', [PoController::class, 'index']);
    Route::get('po/getPoList/{find}', [PoController::class, 'show']);
    Route::delete('po/{id}', [PoController::class, 'destroy']);
    Route::get('po/auto_search/{type}/{find}', [PoController::class, 'autoComplete']);
    Route::post('po', [PoController::class, 'store']);
    Route::get('po/edit/{find}', [PoController::class, 'edit']);
    Route::put('po/{id}', [PoController::class, 'update']);
    Route::get('po/getAttachments/{find}', [PoController::class, 'getAttachments']);
    Route::delete('po/attachment/{id}', [PoController::class, 'destroyAttachment']);
    Route::get('po/status/{find}', [PoController::class, 'getStatus']);
    Route::put('po/statusupdate/{id}', [PoController::class, 'updateStatus']);

    // COMMENTS ROUTES
    Route::get('comment/{id}', [CommentController::class, 'show']);
    Route::post('comment', [CommentController::class, 'sendMessage']);

    // RECEIVING LOG ENTERIES
    Route::get('receivinglogentries', [ReceivinglogenteryController::class, 'index']);
    Route::get('receivinglogentries/search/{find}', [ReceivinglogenteryController::class, 'show']);
    Route::delete('receivinglogentries/{id}', [ReceivinglogenteryController::class, 'destroy']);
    Route::get('receivinglogentries/auto_search/{type}/{find}', [ReceivinglogenteryController::class, 'autoComplete']);
    Route::post('receivinglogentries', [ReceivinglogenteryController::class, 'store']);
    Route::post('receivinglogentries/attachment/', [ReceivinglogenteryController::class, 'create']);
    Route::get('receivinglogentries/edit/{find}', [ReceivinglogenteryController::class, 'edit']);
    Route::put('receivinglogentries/{id}', [ReceivinglogenteryController::class, 'update']);



});
