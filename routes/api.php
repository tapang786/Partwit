<?php

use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\ProductsController;
// use App\Http\Controllers\Api\V1\AdvertisementController;
// use App\Http\Controllers\Admin\CityController;

Route::post('register', 'Api\\AuthController@register');
Route::post('login', 'Api\\AuthController@login');
Route::post('social-login', 'Api\\AuthController@socialLogin');

// logout 
Route::post('logout', 'Api\\AuthController@logoutApi');

// Forgot Pass
Route::post('forgot-password', 'Api\\AuthController@forgotPassword');

// Verify OTP
Route::post('verify-otp', [HomeController::class, 'verifyOTP']);

// Resend email verification
Route::post('resend-email-verification-otp', [HomeController::class, 'reSendEmailVerificationOTP']);

// Forgot password send otp
Route::post('send-forgot-password-otp-mail', [HomeController::class, 'sendForgetPasswordOtpMail']);

// Verify forget password OTP
Route::post('verify-forget-password-otp', [HomeController::class, 'verifyForgetPasswordOTP']);

// Change Forget Password
Route::post('change-forget-password', [HomeController::class, 'changeForgetPassword']);

// Privacy Policy
Route::get('privacy-policy', [HomeController::class, 'privacyPolicy']);

// Terms & Conditions
Route::get('terms-conditions', [HomeController::class, 'termsConditions']);

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Verify User Email Opt
    Route::post('verify-user-email-otp', [HomeController::class, 'verifyUserOtpVerificationMail']);

    // Change User Password
    Route::post('change-password', [HomeController::class, 'changeUserPassword']);

    // Products Controller
    Route::apiResource('products', 'ProductsController');

    // Update User
    Route::post('update-user-data', [HomeController::class, 'saveUserDetails']);

    // Users - My Profile M1
    Route::get('my-profile', [HomeController::class, 'myProfile']);

});
