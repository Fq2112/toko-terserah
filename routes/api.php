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
        Route::post('login_email', 'AuthController@login_email');
        Route::get('user', 'AuthController@getAuthenticatedUser')->middleware('jwt.verify');

        Route::get('get_kode', 'AuthController@sendParams');
        Route::post('sosialite', 'AuthController@sosialite');


        //check email register
        Route::get('check_email', 'AuthController@check_email');
    });

    Route::post('search', 'ProductController@get_product');

    Route::group(['prefix' => 'product'], function () {

        Route::get('home', 'ProductController@home_mobile');

        Route::get('detail/{id}', 'ProductController@get_detail');


        Route::get('voucher_list', 'ProductController@get_voucher');

        Route::post('use_voucher', 'ProductController@use_voucher');




        Route::post('qna', 'BuyingController@submit_qna')->middleware('jwt.verify');

        Route::post('review', 'BuyingController@submit_ulasan')->middleware('jwt.verify');
        Route::post('review/image', 'BuyingController@_ulasan_image')->middleware('jwt.verify');
    });

    Route::group(['prefix' => 'master'], function () {

        Route::get('sub', 'MasterController@getSubKategori');
    });

    Route::group(['middleware' => 'jwt.verify'], function () {

        Route::group(['prefix' => 'profile'], function () {

            Route::get('membercard', 'ProfileController@membercard');

            Route::post('update/bio', 'ProfileController@update_bio');

            Route::post('update/password', 'ProfileController@change_password');

            Route::post('upload/ava', 'ProfileController@upload_ava');

            Route::post('upload/background', 'ProfileController@upload_background');
        });



        Route::group(['prefix' => 'address'], function () {

            Route::get('/', 'alamatController@get');

            Route::get('/detail/{id}', 'alamatController@detail');
            Route::post('/set_utama/{id}', 'alamatController@set_utama');

            Route::get('/kota', 'alamatController@get_kota');
            Route::get('/provinsi', 'alamatController@get_provinsi');

            Route::get('/kecamatan', 'alamatController@get_kecamatan');
            Route::get('/occupancy', 'alamatController@get_occupancy');

            Route::post('create', 'alamatController@create');

            Route::post('delete/{id}', 'alamatController@delete');

            Route::post('update/{id}', 'alamatController@update');
        });

        Route::group(['prefix' => 'wish'], function () {
            //mobile

            Route::get('/', 'BuyingController@get_wish');
            Route::post('/switch', 'BuyingController@switchWish');

            // web
            Route::post('delete/{id}', 'BuyingController@delete_wish_list');

            Route::post('mass_delete', 'BuyingController@mass_delete_wish_list');
        });

        Route::group(['prefix' => 'cart'], function () {
            //mobile

            Route::get('/', 'keranjangController@get');


            Route::post('/add_cart', 'keranjangController@addCart');
            Route::post('/update_cart', 'keranjangController@updateCart');

            Route::post('/delete_cart', 'keranjangController@deleteCart');
        });

        Route::group(['prefix' => 'checkout'], function () {

            Route::group(['prefix' => 'midtrans'], function () {

                Route::get('snap', [
                    'uses' => 'CheckoutController@snap',
                    'as' => 'get.midtrans.snap'
                ]);

                Route::get('check/{code}', [
                    'uses' => 'CheckoutController@check',
                    'as' => 'get.midtrans.check'
                ]);

                Route::get('snap-webview', [
                    'uses' => 'CheckoutController@snapWebview',
                    'as' => 'get.midtrans.snap-webview'
                ]);
                Route::get('/success', function () {
                    return view('pages.webviews.midtrans-success-notice', ['intruksi' => 'untuk trigger ganti screen']);
                });


            });

            Route::get('get_rule', [
                'uses' => 'CheckoutController@get_rule',
                'as' => 'get.checkout.promo'
            ]);

            Route::get('promo', [
                'uses' => 'CheckoutController@promo',
                'as' => 'get.checkout.promo'
            ]);
        });

        Route::group(['prefix' => 'dashboard'], function () {
            //mobile
            Route::get('/', 'DashboardController@get');
            Route::get('detail/{code}', 'DashboardController@detail');
            Route::get('invoice/{code}', 'DashboardController@invoice');
            Route::post('received/{code}', 'DashboardController@received');
            Route::post('reorder/{code}', 'DashboardController@reorder');
        });
    });



    Route::group(['prefix' => 'midtrans'], function () {

        Route::get('snap', [
            'uses' => 'MidtransController@snap',
            'as' => 'get.midtrans.snap'
        ]);

        Route::group(['prefix' => 'callback'], function () {

            /*Route::get('finish', [
                'uses' => 'MidtransController@finishCallback',
                'as' => 'get.midtrans-callback.finish'
            ]);

            Route::get('unfinish', [
                'uses' => 'MidtransController@unfinishCallback',
                'as' => 'get.midtrans-callback.unfinish'
            ]);*/

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
