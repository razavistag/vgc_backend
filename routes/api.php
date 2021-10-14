<?php

use App\Http\Controllers\AgentController;
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
use App\Http\Controllers\BugController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OpenOrderController;
use App\Http\Controllers\PoController;
use App\Http\Controllers\ReceivinglogenteryController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorfactoryController;
use App\Models\OpenOrder;
use App\Models\Vendorfactory;

Route::post('gustRegister', [AuthController::class, 'gustRegister']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forget', [AuthController::class, 'forget']);
Route::post('forget/update', [AuthController::class, 'forgetupdate']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('user/get_city_autocomplete/{find}', [AuthController::class, 'get_ac_city_additional']);
Route::get('user/get_ac_country_additional/{find}', [AuthController::class, 'get_ac_country_additional']);

// BUG CAPTURE ROUTES
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('bug_capture', [BugController::class, 'store']);
    Route::get('bug_capture', [BugController::class, 'index']);
});

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
    Route::put('user/profile/{id}', [AuthController::class, 'profileUpdate']);
    Route::put('user/profileUpdate/{id}', [AuthController::class, 'profileUpdate']);
    Route::put('user/passwordUpdate/{id}', [AuthController::class, 'passwordUpdate']);
    Route::put('user/profileImageUpdate/{id}', [AuthController::class, 'profileImageUpdate']);

    // AGENT ROUTES
    Route::get('agent',  [AgentController::class, 'index']);
    Route::get('agent/search/{find}', [AgentController::class, 'show']);
    Route::delete('agent/{id}', [AgentController::class, 'destroy']);
    Route::get('agent/edit/{find}', [AgentController::class, 'edit']);
    Route::put('agent/{id}', [AgentController::class, 'update']);
    Route::post('agent', [AgentController::class, 'store']);

    // Vendor ROUTES
    Route::get('vendor',  [VendorController::class, 'index']);
    Route::delete('vendor/{id}', [VendorController::class, 'destroy']);
    Route::get('vendor/search/{find}', [VendorController::class, 'show']);
    Route::get('vendor/edit/{find}', [VendorController::class, 'edit']);
    Route::put('vendor/{id}', [VendorController::class, 'update']);
    Route::post('vendor', [VendorController::class, 'store']);


    // Factory ROUTES
    Route::get('factory',  [VendorfactoryController::class, 'index']);
    Route::delete('factory/{id}', [VendorfactoryController::class, 'destroy']);
    Route::get('factory/search/{find}', [VendorfactoryController::class, 'show']);
    Route::get('factory/edit/{find}', [VendorfactoryController::class, 'edit']);
    Route::put('factory/{id}', [VendorfactoryController::class, 'update']);
    Route::get('factory/auto_search/{type}/{find}', [VendorfactoryController::class, 'autoComplete']);
    Route::post('factory', [VendorfactoryController::class, 'store']);


    // DASHBOARD ROUES
    Route::get('dashboard/statment', [AuthController::class, 'dashboardStatment']);
    Route::get('dashboard/orderStatment', [AuthController::class, 'orderStatment']);
    Route::get('dashboard/poStatment', [AuthController::class, 'poStatment']);


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
    Route::post('order/filter/', [OrderController::class, 'filter']);

    // PO ROUTES
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
    Route::post('po/filter/', [PoController::class, 'filter']);

    // COMMENTS ROUTES
    Route::get('comment/{id}/{type}', [CommentController::class, 'show']);
    Route::post('comment', [CommentController::class, 'sendMessage']);
    Route::put('comment/mark_read/{id}', [CommentController::class, 'mark_read']);

    // RECEIVING LOG ENTERIES
    Route::get('receivinglogentries', [ReceivinglogenteryController::class, 'index']);
    Route::get('receivinglogentries/search/{find}', [ReceivinglogenteryController::class, 'show']);
    Route::delete('receivinglogentries/{id}', [ReceivinglogenteryController::class, 'destroy']);
    Route::get('receivinglogentries/auto_search/{type}/{find}', [ReceivinglogenteryController::class, 'autoComplete']);
    Route::post('receivinglogentries', [ReceivinglogenteryController::class, 'store']);
    Route::post('receivinglogentries/attachment/', [ReceivinglogenteryController::class, 'create']);
    Route::get('receivinglogentries/edit/{find}', [ReceivinglogenteryController::class, 'edit']);
    Route::put('receivinglogentries/{id}', [ReceivinglogenteryController::class, 'update']);
    Route::get('receivinglogentries/getAttachments/{find}', [ReceivinglogenteryController::class, 'getAttachments']);
    Route::delete('receivinglogentries/attachment/{id}', [ReceivinglogenteryController::class, 'destroyAttachment']);

    // LOCATION
    Route::get('location', [LocationController::class, 'index']);
    Route::get('location/search/{find}', [LocationController::class, 'show']);
    Route::delete('location/{id}', [LocationController::class, 'destroy']);
    Route::get('location/edit/{find}', [LocationController::class, 'edit']);
    Route::put('location/{id}', [LocationController::class, 'update']);
    Route::post('location', [LocationController::class, 'store']);

    // OPEN ORDER
    Route::post('openorder', [OpenOrderController::class, 'store']);
    Route::get('openorder', [OpenOrderController::class, 'index']);
    Route::get('openorder/majorcompany', [OpenOrderController::class, 'majorCompany']);
    Route::get('openorder/filter/', [OpenOrderController::class, 'filter']);
    Route::delete('openorder/{id}', [OpenOrderController::class, 'destroy']);
    Route::get('openorder/edit/{id}', [OpenOrderController::class, 'show']);
    Route::put('openorder/{id}', [OpenOrderController::class, 'update']);
    Route::put('openorder/stylecheck/{id}', [OpenOrderController::class, 'styleCheckUpdate']);
});
