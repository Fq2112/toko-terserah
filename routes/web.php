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

Auth::routes();

Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {

    Route::get('cek-username', [
        'uses' => 'RegisterController@cekUsername',
        'as' => 'cek.username'
    ]);

    Route::get('password/reset', [
        'uses' => 'ResetPasswordController@showResetForm',
        'as' => 'password.request'
    ]);

    Route::post('password/reset/submit', [
        'uses' => 'ResetPasswordController@reset',
        'as' => 'password.reset'
    ]);

    Route::post('login', [
        'uses' => 'LoginController@login',
        'as' => 'login'
    ]);

    Route::post('logout', [
        'uses' => 'LoginController@logout',
        'as' => 'logout'
    ]);

    Route::get('activate', [
        'uses' => 'ActivationController@activate',
        'as' => 'activate'
    ]);

    Route::get('login/{provider}', [
        'uses' => 'SocialAuthController@redirectToProvider',
        'as' => 'redirect'
    ]);

    Route::get('login/{provider}/callback', [
        'uses' => 'SocialAuthController@handleProviderCallback',
        'as' => 'callback'
    ]);

});

Route::group(['namespace' => 'Pages'], function () {

    Route::get('/', [
        'uses' => 'MainController@beranda',
        'as' => 'beranda'
    ]);

    Route::group(['prefix' => '{produk}'], function () {

        Route::get('/', [
            'uses' => 'MainController@produk',
            'as' => 'produk'
        ]);

        Route::post('order/submit', [
            'middleware' => ['auth', 'user', 'user.bio'],
            'uses' => 'MainController@submitPemesanan',
            'as' => 'produk.submit.pemesanan'
        ]);

        Route::put('order/{id}/update', [
            'middleware' => ['auth', 'user', 'user.bio'],
            'uses' => 'MainController@updatePemesanan',
            'as' => 'produk.update.pemesanan'
        ]);

        Route::get('order/{id}/delete', [
            'middleware' => ['auth', 'user', 'user.bio'],
            'uses' => 'MainController@deletePemesanan',
            'as' => 'produk.delete.pemesanan'
        ]);

    });

    Route::get('cari/nama', [
        'uses' => 'MainController@cariNamaProduk',
        'as' => 'get.cari-nama.produk'
    ]);

    Route::get('cari/pengiriman', [
        'uses' => 'MainController@cekPengirimanProduk',
        'as' => 'get.cari-pengiriman.produk'
    ]);

    Route::group(['prefix' => 'info'], function () {

        Route::get('tentang-kami', [
            'uses' => 'InfoController@tentang',
            'as' => 'tentang'
        ]);

        Route::get('syarat-ketentuan', [
            'uses' => 'InfoController@syaratKetentuan',
            'as' => 'syarat-ketentuan'
        ]);

        Route::get('kebijakan-privasi', [
            'uses' => 'InfoController@kebijakanPrivasi',
            'as' => 'kebijakan-privasi'
        ]);

        Route::get('kontak', [
            'uses' => 'InfoController@kontak',
            'as' => 'kontak'
        ]);

        Route::post('kontak/kirim', [
            'uses' => 'InfoController@kirimKontak',
            'as' => 'kirim.kontak'
        ]);

    });

    Route::group(['namespace' => 'Users', 'prefix' => 'akun', 'middleware' => ['auth', 'user']], function () {

        Route::group(['prefix' => 'wishlist'], function () {

            Route::get('/', [
                'uses' => 'UserController@wishlist',
                'as' => 'user.wishlist',
            ]);

        });

        Route::group(['prefix' => 'cart'], function () {

            Route::get('/', [
                'uses' => 'UserController@cart',
                'as' => 'user.cart',
            ]);

            Route::get('edit/{id}/design', [
                'middleware' => 'user.bio',
                'uses' => 'UserController@editDesign',
                'as' => 'user.edit-design.cart',
            ]);

            Route::put('update/{id}/order', [
                'middleware' => 'user.bio',
                'uses' => 'UserController@updateOrder',
                'as' => 'user.update-order.cart',
            ]);

            Route::get('delete/{id}/note', [
                'middleware' => 'user.bio',
                'uses' => 'UserController@deleteNote',
                'as' => 'user.delete-note.cart',
            ]);

            Route::get('cari/promo', [
                'middleware' => 'user.bio',
                'uses' => 'UserController@cariPromo',
                'as' => 'get.cari-promo.cart'
            ]);

            Route::post('checkout', [
                'middleware' => 'user.bio',
                'uses' => 'UserController@checkout',
                'as' => 'user.checkout.cart',
            ]);

        });

        Route::group(['prefix' => 'dashboard'], function () {

            Route::get('/', [
                'uses' => 'UserController@dashboard',
                'as' => 'user.dashboard'
            ]);

            Route::get('download/{id}/{file}', [
                'middleware' => 'user.bio',
                'uses' => 'UserController@downloadFile',
                'as' => 'user.download.file'
            ]);

            Route::get('{code}/received', [
                'middleware' => 'user.bio',
                'uses' => 'UserController@received',
                'as' => 'user.received'
            ]);

            Route::get('{code}/reorder', [
                'middleware' => 'user.bio',
                'uses' => 'UserController@reorder',
                'as' => 'user.reorder'
            ]);

        });

        Route::group(['prefix' => 'sunting-profil'], function () {

            Route::get('/', [
                'uses' => 'AkunController@profil',
                'as' => 'user.profil'
            ]);

            Route::put('update', [
                'uses' => 'AkunController@updateProfil',
                'as' => 'user.update.profil'
            ]);

            Route::post('address/create', [
                'uses' => 'AkunController@createProfilAddress',
                'as' => 'user.profil-alamat.create'
            ]);

            Route::put('address/{id}/update', [
                'uses' => 'AkunController@updateProfilAddress',
                'as' => 'user.profil-alamat.update'
            ]);

            Route::get('address/{id}/delete', [
                'uses' => 'AkunController@deleteProfilAddress',
                'as' => 'user.profil-alamat.delete'
            ]);

        });

        Route::group(['prefix' => 'pengaturan'], function () {

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

});
