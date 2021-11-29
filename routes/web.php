<?php

Route::redirect('/', '/sweeper/login');
Route::redirect('/home', '/sweeper/admin');
Route::redirect('/admin', '/sweeper/admin');
Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Drivers
    Route::delete('drivers/destroy', 'DriversController@massDestroy')->name('drivers.massDestroy');
    Route::resource('drivers', 'DriversController');

    // City
    Route::delete('city/destroy', 'CityController@massDestroy')->name('city.massDestroy');
    Route::resource('city', 'CityController');

    // Advertisement
    Route::delete('advertisement/destroy', 'AdvertisementController@massDestroy')->name('advertisement.massDestroy');
    Route::resource('advertisement', 'AdvertisementController');

    // Pages
    Route::delete('pages/destroy', 'PagesController@massDestroy')->name('pages.massDestroy');
    Route::resource('pages', 'PagesController');

    // Subscriptions
    Route::resource('subscription', 'SubscriptionController');
    Route::delete('subscription/destroy', 'SubscriptionController@massDestroy')->name('subscription.massDestroy');


    // Payments
    Route::resource('payments', 'PaymentsController');
    // Route::delete('subscription/destroy', 'SubscriptionController@massDestroy')->name('subscription.massDestroy');

});

Route::get('ckeditor', 'CkeditorController@index');
Route::post('ckeditor/upload', 'CkeditorController@upload')->name('ckeditor.upload');
