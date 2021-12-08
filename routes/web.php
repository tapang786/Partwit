<?php

Route::redirect('/', '/login');
Route::redirect('/home', '/dashboard');
Auth::routes(['register' => false]);

Route::group(['prefix' => 'dashboard', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
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

    // Sellers
    Route::delete('sellers/destroy', 'SellersController@massDestroy')->name('sellers.massDestroy');
    Route::resource('sellers', 'SellersController');

    // Enable Disable User
    Route::get('users-enable/{id}', 'UsersController@isenable')->name('users-enable');
    
    // Route::get('seller', 'UsersController@showVendor')->name('seller');

    // Route::get('vendor-add', 'UsersController@addVendor')->name('vendor-add');
    // Route::post('vendor-store', 'UsersController@storeVendor')->name('vendor-store');


    // Products
    Route::resource('products', 'ProductsController');
    Route::delete('products/destroy', 'SubscriptionController@massDestroy')->name('products.massDestroy');


    //Category
    Route::resource('category', 'CategoryController');

    //Attributes
    Route::resource('attributes', 'AttributeController');

    //Attributes Value
    Route::resource('attribute-value', 'AttributeValueController');


    // Subscriptions
    Route::resource('subscription', 'SubscriptionController');
    Route::delete('subscription/destroy', 'SubscriptionController@massDestroy')->name('subscription.massDestroy');


});
