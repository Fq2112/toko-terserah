<?php

/*
 * routing admin
 * */

Route::redirect('/', 'dashboard');

Route::group(['namespace' => 'Pages\Admins'], function () {

    Route::get('dashboard', [
        'uses' => 'AdminController@dashboard',
        'as' => 'admin.dashboard'
    ]);

    Route::group(['prefix' => 'account'], function () {

        Route::get('profile', [
            'uses' => 'AdminController@profil',
            'as' => 'admin.profil'
        ]);

        Route::put('profile/update', [
            'uses' => 'AdminController@updateProfil',
            'as' => 'admin.update.profil'
        ]);

        Route::get('settings', [
            'uses' => 'AdminController@pengaturan',
            'as' => 'admin.pengaturan'
        ]);

        Route::put('settings/update', [
            'uses' => 'AdminController@updatePengaturan',
            'as' => 'admin.update.pengaturan'
        ]);

        Route::get('admins', [
            'uses' => 'AdminController@show_admin',
            'as' => 'admin.show.list'
        ]);

        Route::post('admin/add', [
            'uses' => 'AdminController@admin_add',
            'as' => 'admin.add'
        ]);

        Route::post('reset', [
            'uses' => 'AdminController@reset_password',
            'as' => 'admin.reset'
        ]);

        Route::get('{id}/delete', [
            'uses' => 'AdminController@delete_admin',
            'as' => 'delete.admin'
        ]);

        Route::get('admins/user', [
            'uses' => 'AdminController@show_user',
            'as' => 'admin.user.list'
        ]);

    });

    Route::group(['prefix' => 'inbox', 'middleware' => 'owner'], function () {

        Route::get('/', [
            'uses' => 'AdminController@showInbox',
            'as' => 'admin.inbox'
        ]);

        Route::post('compose', [
            'uses' => 'AdminController@composeInbox',
            'as' => 'admin.compose.inbox'
        ]);

        Route::get('{id}/delete', [
            'uses' => 'AdminController@deleteInbox',
            'as' => 'admin.delete.inbox'
        ]);

    });

});
