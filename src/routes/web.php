<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This is where the routes used by the module are registered. 
| These routes are loaded by the BaseServiceProvider into a group
| containing the "web" middleware group.
|
*/

Route::group(
    [
        'namespace'  => 'Rafni\Auth\Http\Controllers\Auth',
        'middleware' => 'web',
        'prefix'     => config('backend.base.panel_route_prefix'),
    ],
    function () {
        // Authentication Routes...
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('logout');

        // Registration Routes...
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');

        // Password Reset Routes...
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset');
    }
);

Route::get('/home', 'Rafni\Auth\Http\Controllers\HomeController@index')
        ->middleware('web')
        ->name('home');