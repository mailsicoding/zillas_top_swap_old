<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ContactUsController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\AccountSettingController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\FundsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Users and Roles and Permissions routes

// User routes

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('signup', [AuthController::class, 'signup']);


// Route::post('forget-password', [AuthController::class, 'passwordReset']);
// Route::post('verify-code', [AuthController::class, 'verifyCode']);
// Route::post('update-password', [AuthController::class, 'updatePassword']);

Route::post('send-forget-email-code', [AuthController::class, 'send_forget_email_code']);
Route::post('verify-forget-email-code', [AuthController::class, 'verify_forget_email_code']);
Route::post('update-password', [AuthController::class, 'update_password']);


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['middleware' => 'can:Users,Roles'], function () {
        Route::get('all_users', [AuthController::class, 'index']);
        Route::post('add_user', [AuthController::class, 'store_user']);
        Route::post('edit-user', [AuthController::class, 'edit_user']);
        Route::post('update-user', [AuthController::class, 'update']);
        Route::post('delete-user', [AuthController::class, 'delete_user']);
        // Route::post('delete-user', [AuthController::class, 'delete_user']);
        Route::get('get_roles', [AuthController::class, 'get_roles']);
        Route::post('edit_roles', [AuthController::class, 'edit_roles']);
        Route::get('get_permissions', [AuthController::class, 'get_permissions']);
        Route::post('assign_permission_role', [AuthController::class, 'assign_permission_role']);
        // contact us mail module
        Route::apiResource('contact', ContactUsController::class)->only(['index','destroy']);

    });

    Route::group(['middleware' => 'can:Offers,Getting Match'], function () {
        Route::get('get-offers', [OfferController::class, 'getoffers']);
        Route::post('create-offer', [OfferController::class, 'create']);
        Route::post('remove-offer', [OfferController::class, 'remove']);
        Route::post('edit-offer', [OfferController::class, 'edit']);
        Route::post('update-offer', [OfferController::class, 'update']);
        Route::post('match-offers', [OfferController::class, 'match_offers']);
        Route::get('get-match-status', [OfferController::class, 'get_match_status']);
        Route::post('trade-cancel', [OfferController::class, 'trade_cancel']);
        Route::post('get-match-offer-user', [OfferController::class, 'get_match_offers']);
        Route::get('get-funds', [FundsController::class, 'get_funds']);
        // Contact us mail module
        Route::apiResource('contact', ContactUsController::class)->only('store');
        // Route::post('add_contact_us', [ContactUsController::class, 'add_contact_us']);
    });

    Route::group(['middleware' => 'can:Funds'], function () {
        Route::get('users', [FundsController::class, 'users']);
        Route::post('add-funds', [FundsController::class, 'add_funds']);
    });

    Route::get('/user/permissions', [PermissionController::class, 'getPermissions']);

    Route::post('send-phone-verification-code', [AuthController::class, 'send_phone_verification_code']);
    Route::post('verify-phone-verification-code', [AuthController::class, 'verify_phone_verification_code']);
    Route::post('send-email-verification-code', [AuthController::class, 'send_email_verification_code']);
    Route::post('verify-email-verification-code', [AuthController::class, 'verify_email_verification_code']);



    Route::get('messages', [MessageController::class, 'messages']);
    Route::post('messages', [MessageController::class, 'messageStore']);

    Route::post('create-trade-settings', [AccountSettingController::class, 'create_trade_settings']);
    Route::post('update-setting', [AccountSettingController::class, 'update_setting']);

    // Match Offers Routes start

    // Funds

    // ContactUs


    // Route::post('edit_contact_us', [ContactUsController::class, 'add_contact_us']);




    Route::post('logout', [AuthController::class, 'logout']);
});

Route::apiResource('contact', ContactUsController::class);
// Route::get('all_contacts', [ContactUsController::class, 'index']);


