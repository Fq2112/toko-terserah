<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'akun'], function () {

    Route::group(['namespace' => 'Auth'], function () {

        Route::get('cek/{username}', [
            'uses' => 'RegisterController@cekUsername',
            'as' => 'cek.username'
        ]);

        Route::post('masuk', [
            'uses' => 'LoginController@login',
            'as' => 'login'
        ]);

        Route::post('keluar', [
            'uses' => 'LoginController@logout',
            'as' => 'logout'
        ]);

        Route::post('password/reset/{token}', [
            'uses' => 'ResetPasswordController@showResetForm',
            'as' => 'password.request'
        ]);

        Route::post('password/reset', [
            'uses' => 'ResetPasswordController@postReset',
            'as' => 'password.reset'
        ]);

    });

    Route::group(['namespace' => 'Pages\Users', 'middleware' => ['auth', 'user']], function () {

        Route::group(['prefix' => 'wishlist'], function () {

            Route::get('/', [
                'uses' => 'UserController@wishlist',
                'as' => 'user.wishlist'
            ]);

        });

        Route::group(['prefix' => 'cart'], function () {

            Route::get('/', [
                'uses' => 'UserController@cart',
                'as' => 'user.cart',
            ]);

            Route::put('update/{id}/order', [
                'uses' => 'UserController@updateOrder',
                'as' => 'user.update-order.cart',
            ]);

            Route::get('delete/{id}/note', [
                'uses' => 'UserController@deleteNote',
                'as' => 'user.delete-note.cart',
            ]);

            Route::get('cari/promo', [
                'uses' => 'UserController@cariPromo',
                'as' => 'get.cari-promo.cart'
            ]);

            Route::post('checkout', [
                'uses' => 'UserController@checkout',
                'as' => 'user.checkout.cart',
            ]);

        });

        Route::group(['prefix' => 'profil'], function () {

            Route::get('/', [
                'uses' => 'AkunController@profil',
                'as' => 'user.profil'
            ]);

            Route::put('update', [
                'uses' => 'AkunController@updateProfil',
                'as' => 'user.update.profil'
            ]);

        });

        Route::get('pengaturan', [
            'uses' => 'AkunController@pengaturan',
            'as' => 'user.pengaturan'
        ]);

        Route::put('pengaturan/update', [
            'uses' => 'AkunController@updatePengaturan',
            'as' => 'user.update.pengaturan'
        ]);

    });

});

Route::group(['prefix' => '/', 'namespace' => 'Pages'], function () {

    Route::get('/', [
        'uses' => 'MainController@beranda',
        'as' => 'beranda'
    ]);

    Route::group(['prefix' => 'info'], function () {

        Route::get('tentang-kami', [
            'uses' => 'MainController@tentang',
            'as' => 'tentang'
        ]);

        Route::get('ketentuan-layanan', [
            'uses' => 'MainController@ketentuanLayanan',
            'as' => 'ketentuan-layanan'
        ]);

        Route::get('kebijakan-privasi', [
            'uses' => 'MainController@kebijakanPrivasi',
            'as' => 'kebijakan-privasi'
        ]);

        Route::get('kontak-kami', [
            'uses' => 'MainController@kontak',
            'as' => 'kontak'
        ]);

        Route::post('kontak/kirim', [
            'uses' => 'MainController@kirimKontak',
            'as' => 'kirim.kontak'
        ]);

    });

});
