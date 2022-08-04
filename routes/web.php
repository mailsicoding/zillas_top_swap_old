<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\AccountSettingController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\FundsController;
use App\Http\Controllers\API\OrderByController;
use App\Http\Controllers\API\ContactUsController;

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

Route::get('/migrate', function () {
    Artisan::call('migrate');
    return 'migrated successfully';
});
Route::get('/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    dd('clear done');
});

Route::get('/compiled', function () {
    Artisan::call('clear-compiled');
    dd("cleared-view");
});


Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('signup', [AuthController::class, 'signup']);


// Route::post('forget-password', [AuthController::class, 'passwordReset']);
// Route::post('verify-code', [AuthController::class, 'verifyCode']);
// Route::post('update-password', [AuthController::class, 'updatePassword']);

Route::post('send-forget-email-code', [AuthController::class, 'send_forget_email_code']);
Route::post('verify-forget-email-code', [AuthController::class, 'verify_forget_email_code']);
Route::post('update-password', [AuthController::class, 'update_password']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('getRole', [PermissionController::class, 'getRole']);

    Route::group(['middleware' => 'can:Users,Roles'], function () {
        Route::post('search_admin_chat', [AuthController::class, 'search_admin_chat']);
        Route::post('add_user', [AuthController::class, 'store_user']);
        Route::post('edit-user', [AuthController::class, 'edit_user']);
        Route::post('update-user', [AuthController::class, 'update']);
        Route::post('delete-user', [AuthController::class, 'delete_user']);
        Route::post('delete-user', [AuthController::class, 'delete_user']);
        Route::get('get_roles', [AuthController::class, 'get_roles']);
        Route::post('edit_roles', [AuthController::class, 'edit_roles']);
        Route::get('get_permissions', [AuthController::class, 'get_permissions']);
        Route::post('assign_permission_role', [AuthController::class, 'assign_permission_role']);
        // contact us mail module
        Route::get('all_contacts', [ContactUsController::class, 'index']);
        Route::post('delete-contact', [ContactUsController::class, 'delete_contact']);
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
        Route::get('get-cancel-data', [OrderByController::class, 'hide_cancel']);
        Route::get('get-history', [OrderByController::class, 'get_history']);

        Route::post('get-match-offer-user', [OfferController::class, 'get_match_offers']);
        Route::get('get-funds', [FundsController::class, 'get_funds']);

        // contact us mail module
        Route::post('add_contact_us', [ContactUsController::class, 'add_contact_us']);

        Route::get('find_operator', [OfferController::class, 'find_operator']);
    });

    Route::get('all_users', [AuthController::class, 'index']);

    Route::get('get_player_count', [AuthController::class, 'get_player_count']);
    Route::get('get_operator_count', [AuthController::class, 'get_operator_count']);

    Route::post('get_buyer', [OfferController::class, 'get_buyer']);
    Route::post('get_seller', [OfferController::class, 'get_seller']);
    Route::post('get_operator', [OfferController::class, 'get_operator']);
    Route::post('change_operator_status', [OfferController::class, 'change_operator_status']);
    Route::post('change_offer_status', [OfferController::class, 'change_offer_status']);
    Route::post('order-history', [OrderByController::class, 'order_history']);
    Route::get('order-cancel-history', [OrderByController::class, 'order_cancel_history']);

    Route::group(['middleware' => 'can:Funds'], function () {
        Route::get('players', [FundsController::class, 'players']);
        Route::post('add-funds', [FundsController::class, 'add_funds']);
        Route::post('sub-funds', [FundsController::class, 'sub_funds']);
        Route::get('getOperators', [AuthController::class, 'getOperators']);
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


    Route::post('add_contact_us', [ContactUsController::class, 'add_contact_us']);

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');
