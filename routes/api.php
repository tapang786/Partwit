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

// Send Verification OTP
Route::post('send-verification-otp', [HomeController::class, 'SendVerificationOTP']);

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

Route::post('product-add', [ProductController::class, 'create']);

// Privacy Policy
Route::get('privacy-policy', [HomeController::class, 'privacyPolicy']);

// Terms & Conditions
Route::get('terms-conditions', [HomeController::class, 'termsConditions']);

// About PartWit
Route::get('about-partwit', [HomeController::class, 'AboutPartwit']);

// Verify User Email Opt
Route::post('verify-user-email-otp', [HomeController::class, 'verifyUserOtpVerificationMail']);

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Change User Password
    Route::post('change-password', [HomeController::class, 'changeUserPassword']);

    // Products Controller
    // Route::apiResource('products', 'ProductsController');

    // Update User
    Route::post('update-user-data', [HomeController::class, 'saveUserDetails']);

    // Users - My Profile M1
    Route::get('my-profile', [HomeController::class, 'myProfile']);

    // Home Page
    Route::get('home-page', [HomeController::class, 'HomePage']);

    // Products by Category
    Route::post('products-by-category', [HomeController::class, 'productsByCategory']);

    //Product Add / Edit
    Route::post('product-add', [ProductsController::class, 'create']); 

    // Show Product
    Route::post('product-show', [ProductsController::class, 'show']); 

    // Report Reasons
    Route::get('report-reasons', [HomeController::class, 'reportReasons']);

    // Report a Product
    Route::post('report-product', [ProductsController::class, 'ReportProduct']);

    // Seller Reviews
    Route::post('seller-reviews', [HomeController::class, 'SellerReviews']); 

    // Add Seller Reviews
    Route::post('add-seller-reviews', [HomeController::class, 'AddSellerReviews']);

    // Search Product
    Route::post('search', [HomeController::class, 'SearchProduct']);

    // Seller Listed Products
    Route::post('seller-listed-products', [HomeController::class, 'sellerListedProducts']); 

    // Seller Profile
    Route::post('seller-profile', [HomeController::class, 'viewSellerProfile']);
    
    // All Cards
    Route::post('all-cards', [HomeController::class, 'allCardsList']);

    // Delete Cards
    Route::post('delete-card', [HomeController::class, 'deleteCard']);

    // Add Card
    Route::post('add-card', [HomeController::class, 'addCard']);

    // Subscription Plan List
    Route::get('subscription-plan-list', [HomeController::class, 'subscriptionList']);

    // Buy Subscription Plan
    Route::post('buy-subscription-plan', [HomeController::class, 'subscriptionPayment']);

    // Add Item to Save Items
    Route::post('add-to-save-item', [HomeController::class, 'addToSaveItem']);

    // Save Items List
    Route::get('save-items-list', [HomeController::class, 'saveItemsList']);

    // Remove from Save Items
    Route::post('remove-save-item', [HomeController::class, 'removeSaveItem']);


});
