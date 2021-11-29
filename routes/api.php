<?php

use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\DriverRoutesController;
use App\Http\Controllers\Api\V1\AdvertisementController;
use App\Http\Controllers\Admin\CityController;


Route::post('register', 'Api\\AuthController@register');
Route::post('login', 'Api\\AuthController@login');

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

// Change password
Route::post('change-forget-password', [HomeController::class, 'changeUserPassword']);

// City List
Route::get('city-list', [CityController::class, 'citiesList']);

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

    // Update User
    Route::post('update-user-data', [HomeController::class, 'saveUserDetails']);

    // Verify User Email Opt
    Route::post('verify-user-email-otp', [HomeController::class, 'verifyUserOtpVerificationMail']);

    // Change User Password
    Route::post('change-password', [HomeController::class, 'changeUserPassword']);
    
    // Nearby drivers list
    Route::post('near-drivers-list', [HomeController::class, 'nearDriversList']);

    // Nearby drivers list
    Route::get('subscription-list', [HomeController::class, 'subscriptionList']);

    // Create Driver Route
    Route::post('create-driver-route', [DriverRoutesController::class, 'createDriverRoutes']);

    // Driver's Routes
    Route::post('driver-routes', [HomeController::class, 'driverRoutes']);

    // Driver Assign Routes
    Route::post('driver-assign-routes', [HomeController::class, 'driverAssignRoutes']);

    // Get Routes by Date 
    Route::post('get-routes-by-date', [HomeController::class, 'getRoutesByDate']);
    
    // Driver Single Route
    Route::get('single-driver-routes', [DriverRoutesController::class, 'singleDriverRoutes']);

    // Send Driver Friend Request
    Route::post('send-driver-friend-request', [DriverRoutesController::class, 'sendDriverFriendRequest']);

    // Accept Driver Friend Request
    Route::post('accept-driver-friend-request', [DriverRoutesController::class, 'acceptDriverFriendRequest']);

    // Driver Friends List
    Route::post('drivers-friend-list', [DriverRoutesController::class, 'driversFriendsList']);

    // Driver Friends Request List
    Route::post('driver-friend-request-list', [DriverRoutesController::class, 'driverFriendsRequestList']);

    // Cancle Driver Friend Requst
    Route::post('cancle-driver-friend-request', [DriverRoutesController::class, 'cancleDrivrFriendReqest']);

    // Share Route
    Route::post('share-route', [DriverRoutesController::class, 'shareRoute']);

    // Advertisement List
    Route::post('advertisement-list', [AdvertisementController::class, 'advertisementList']);

    // Driver Notifications
    Route::post('driver-routes-notifications', [DriverRoutesController::class, 'driverRoutesNotifications']);

    // Driver Notifications
    Route::post('update-notifications', [HomeController::class, 'updateNotification']);
    
    // Resposnse On Driver Route Request
    Route::post('update-requested-route', [DriverRoutesController::class, 'updateRequestedRoute']);

    // Make Subscription Payment
    Route::post('subscription-payment', [HomeController::class, 'subscriptionPayment']);

    // All Cards
    Route::post('all-cards', [HomeController::class, 'allCardsList']);

    // Delete Cards
    Route::post('delete-card', [HomeController::class, 'deleteCard']);

    // Add Card
    Route::post('add-card', [HomeController::class, 'addCard']);

    // Start Following Route
    Route::post('start-following-route', [DriverRoutesController::class, 'startFollowingRoute']);

    // End Following Route
    Route::post('end-following-route', [DriverRoutesController::class, 'endFollowingRoute']);

    // Single Driver Info
    Route::post('single-driver-information', [DriverRoutesController::class, 'singleDriverInformation']);

    Route::get('user', function (){
        // code...
        return "Sdf";
    });
});
