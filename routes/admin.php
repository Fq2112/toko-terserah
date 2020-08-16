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

    Route::group(['prefix' => 'order'], function () {
        Route::get('/', [
            'uses' => 'OrderController@order',
            'as' => 'admin.order'
        ]);

        Route::post('resi', [
            'uses' => 'OrderController@update_resi',
            'as' => 'order.resi'
        ]);

        Route::post('resi/update', [
            'uses' => 'OrderController@update_resi_',
            'as' => 'order.resi.update'
        ]);

        Route::post('label', [
            'uses' => 'OrderController@create_label',
            'as' => 'order.label'
        ]);

        Route::post('/download', [
            'uses' => 'OrderController@download_label',
            'as' => 'order.label.download'
        ]);

        Route::get('show/{kode}', [
            'uses' => 'OrderController@show_order',
            'as' => 'admin.order.user'
        ]);

        Route::post('detail', [
            'uses' => 'OrderController@order_detail',
            'as' => 'get.order.detail'
        ]);

        Route::post('create', [
            'uses' => 'OrderController@create_data',
            'as' => 'add.order'
        ]);

        Route::get('edit/{id}', [
            'uses' => 'OrderController@ger_data',
            'as' => 'get.order'
        ]);

        Route::put('update', [
            'uses' => 'OrderController@update_data',
            'as' => 'update.order'
        ]);

        Route::post('update/order', [
            'uses' => 'OrderController@proceed_order',
            'as' => 'update.order.status'
        ]);

        Route::post('update/order/mass', [
            'uses' => 'OrderController@proceed_order_mass',
            'as' => 'update.order.update.mass'
        ]);

        Route::get('{id}/delete', [
            'uses' => 'OrderController@delete_data',
            'as' => 'delete.order'
        ]);

        Route::get('download/{id}/file', [
            'uses' => 'OrderController@get_file',
            'as' => 'admin.order.download'
        ]);

        Route::post('download/invoice', [
            'uses' => 'OrderController@download_invoice',
            'as' => 'admin.order.invoice.download'
        ]);

        Route::post('download/shipping/', [
            'uses' => 'OrderController@create_pdf',
            'as' => 'admin.order.production.pdf'
        ]);

        Route::post('download/production', [
            'uses' => 'OrderController@download_production',
            'as' => 'admin.order.production.download'
        ]);

        Route::get('shipping/{code}', [
            'uses' => 'OrderController@shipping',
            'as' => 'admin.order.shipping'
        ]);
        Route::get('shipping/', [
            'uses' => 'OrderController@download_shipping',
            'as' => 'admin.order.shipping'
        ]);
        Route::group(['prefix' => 'shipper'], function () {

            Route::post('modal', [
                'uses' => 'ShipperController@showModal',
                'as' => 'admin.shipper.modal.create'
            ]);

            Route::post('create', [
                'uses' => 'ShipperController@postOrder',
                'as' => 'admin.shipper.create.order'
            ]);

            Route::post('agents', [
                'uses' => 'ShipperController@getAgents',
                'as' => 'admin.shipper.modal.agents'
            ]);

            Route::post('create/pickup', [
                'uses' => 'ShipperController@postPickup',
                'as' => 'admin.shipper.create.pickup'
            ]);
        });

    });

    Route::group(['prefix' => 'produk', 'namespace' => 'DataMaster'], function () {

        Route::group(['prefix' => 'gudang'], function () {
            Route::get('show', [
                'uses' => 'ProdukController@show',
                'as' => 'admin.show.produk'
            ]);

            Route::get('tambah', [
                'uses' => 'ProdukController@add_product_page',
                'as' => 'admin.show.produk.tambah'
            ]);

            Route::post('tambah/stok', [
                'uses' => 'ProdukController@add_stock',
                'as' => 'admin.show.produk.stock'
            ]);

            Route::post('tambah/produk', [
                'uses' => 'ProdukController@add_produk',
                'as' => 'admin.show.produk.add'
            ]);

            Route::get('sunting/{kode_barang}', [
                'uses' => 'ProdukController@edit',
                'as' => 'admin.show.produk.edit'
            ]);

            Route::post('update/produk', [
                'uses' => 'ProdukController@update_produk',
                'as' => 'admin.show.produk.update'
            ]);


            Route::get('{id}/delete', [
                'uses' => 'ProdukController@delete_produk',
                'as' => 'delete.produk'
            ]);

        });

        Route::group(['prefix' => 'qna'], function () {
            Route::get('show', [
                'uses' => 'QnAController@show',
                'as' => 'admin.show.qna'
            ]);

            Route::post('jawab', [
                'uses' => 'QnAController@jawab',
                'as' => 'admin.show.qna.jawab'
            ]);
        });

        Route::group(['prefix' => 'ulasan'], function () {

            Route::get('show', [
                'uses' => 'ReviewController@show',
                'as' => 'admin.show.ulasan'
            ]);

        });
    });

    Route::group(['prefix' => 'master', 'namespace' => 'DataMaster'], function () {

        Route::group(['prefix' => 'kategori'], function () {
            Route::get('show', [
                'uses' => 'CategoryController@show_kategori',
                'as' => 'admin.show.kategori'
            ]);

            Route::post('post', [
                'uses' => 'CategoryController@create_kategori',
                'as' => 'admin.show.kategori.add'
            ]);

            Route::post('update', [
                'uses' => 'CategoryController@update_kategori',
                'as' => 'admin.show.kategori.update'
            ]);

            Route::get('{id}/delete', [
                'uses' => 'CategoryController@delete_kategori',
                'as' => 'delete.kategori'
            ]);
        });

        Route::group(['prefix' => 'sub'], function () {
            Route::get('show', [
                'uses' => 'CategoryController@show_sub',
                'as' => 'admin.show.sub'
            ]);

            Route::post('post', [
                'uses' => 'CategoryController@create_sub',
                'as' => 'admin.show.sub.add'
            ]);

            Route::post('update', [
                'uses' => 'CategoryController@update_sub',
                'as' => 'admin.show.sub.update'
            ]);

            Route::get('{id}/delete', [
                'uses' => 'CategoryController@delete_sub',
                'as' => 'delete.sub'
            ]);
        });
    });

    Route::group(['prefix' => 'msc'], function () {
        Route::group(['prefix' => 'promo', 'middleware' => 'owner'], function () {
            Route::get('show', [
                'uses' => 'PromoController@show_promo',
                'as' => 'admin.promo'
            ]);

            Route::post('create', [
                'uses' => 'PromoController@create_data',
                'as' => 'add.promo'
            ]);

            Route::get('edit/{id}', [
                'uses' => 'PromoController@ger_data',
                'as' => 'get.promo'
            ]);

            Route::put('update', [
                'uses' => 'PromoController@update_data',
                'as' => 'update.promo'
            ]);


            Route::get('{id}/delete', [
                'uses' => 'PromoController@delete_data',
                'as' => 'delete.promo'
            ]);
        });

        Route::group(['prefix' => 'setting', 'middleware' => 'owner'], function () {
            Route::get('show', [
                'uses' => 'SettingController@show_setting',
                'as' => 'admin.setting.general'
            ]);

            Route::get('general', [
                'uses' => 'SettingController@show_general',
                'as' => 'admin.setting.general.show'
            ]);

            Route::post('general/update', [
                'uses' => 'SettingController@update_general',
                'as' => 'admin.setting.general.update'
            ]);

            Route::get('maintenance', [
                'uses' => 'SettingController@show_maintenance',
                'as' => 'admin.setting.maintenance.show'
            ]);

            Route::post('maintenance/update', [
                'uses' => 'SettingController@activeMaintenance',
                'as' => 'admin.setting.maintenance.update'
            ]);

            Route::get('rules', [
                'uses' => 'SettingController@rule',
                'as' => 'admin.setting.rules.show'
            ]);

            Route::post('rules/update', [
                'uses' => 'SettingController@rules_update',
                'as' => 'admin.setting.rules.update'
            ]);

        });

        Route::group(['prefix' => 'qna', 'middleware' => 'owner'], function () {

            Route::get('/', [
                'uses' => 'SettingController@show_qna',
                'as' => 'admin.qna.show'
            ]);

            Route::post('/add', [
                'uses' => 'TemplateController@create_data',
                'as' => 'admin.qna.add'
            ]);

            Route::post('/update', [
                'uses' => 'TemplateController@edit',
                'as' => 'admin.qna.update'
            ]);

            Route::get('/delete/{id}', [
                'uses' => 'TemplateController@delete',
                'as' => 'admin.qna.delete'
            ]);
        });

        Route::group(['prefix' => 'banner', 'middleware' => 'owner'], function () {

            Route::get('/', [
                'uses' => 'SettingController@show_banner',
                'as' => 'admin.banner.show'
            ]);

            Route::post('/add', [
                'uses' => 'TemplateController@create_data',
                'as' => 'admin.qna.add'
            ]);

            Route::post('/update', [
                'uses' => 'TemplateController@edit',
                'as' => 'admin.qna.update'
            ]);

            Route::get('/delete/{id}', [
                'uses' => 'TemplateController@delete',
                'as' => 'admin.qna.delete'
            ]);
        });
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
