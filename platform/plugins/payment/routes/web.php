<?php

Route::group(['namespace' => 'Botble\Payment\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(['prefix' => 'payments'], function () {
        Route::post('checkout', 'PaymentController@postCheckout')->name('payments.checkout');

        Route::get('status', 'PaymentController@getPayPalStatus')->name('payments.paypal.status');
    });

    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'payments'], function () {
            Route::get('methods', [
                'as'   => 'payments.methods',
                'uses' => 'PaymentController@methods',
            ]);

            Route::post('methods', [
                'as'         => 'payments.methods',
                'uses'       => 'PaymentController@updateMethods',
                'middleware' => 'preventDemo',
            ]);

            Route::post('methods/update-status', [
                'as'         => 'payments.methods.update.status',
                'uses'       => 'PaymentController@updateMethodStatus',
                'permission' => 'payment.methods',
            ]);

            Route::get('view/{charge_id}', 'PaymentController@getView')->name('payments.view');
        });
    });
});
