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

Route::group(['namespace' => 'API'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::get('user', 'AuthController@getAuthenticatedUser')->middleware('jwt.verify');
    });

    Route::group(['middleware' => 'jwt.verify'], function () {

    });

    Route::group(['prefix' => 'midtrans'], function () {

        Route::get('snap', [
            'uses' => 'MidtransController@snap',
            'as' => 'get.midtrans.snap'
        ]);

        Route::group(['prefix' => 'callback'], function () {

            Route::get('finish', [
                'uses' => 'MidtransController@finishCallback',
                'as' => 'get.midtrans-callback.finish'
            ]);

            Route::get('unfinish', [
                'uses' => 'MidtransController@unfinishCallback',
                'as' => 'get.midtrans-callback.unfinish'
            ]);

            Route::post('payment', [
                'uses' => 'MidtransController@notificationCallback',
                'as' => 'post.midtrans-callback.notification'
            ]);

        });

    });

    Route::group(['prefix' => 'rajaongkir'], function () {

        Route::get('subdistrict', [
            'uses' => 'RajaOngkirController@getSubdistrict',
            'as' => 'get.rajaongkir.subdistrict'
        ]);

        Route::post('cost', [
            'uses' => 'RajaOngkirController@getCost',
            'as' => 'get.rajaongkir.cost'
        ]);

        Route::get('waybill', [
            'uses' => 'RajaOngkirController@getWaybill',
            'as' => 'get.rajaongkir.waybill'
        ]);

    });

});
