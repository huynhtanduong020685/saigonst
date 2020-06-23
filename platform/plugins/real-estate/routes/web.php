<?php

Route::group(['namespace' => 'Botble\RealEstate\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => config('core.base.general.admin_dir') . '/real-estate', 'middleware' => 'auth'], function () {

        Route::get('settings', [
            'as'   => 'real-estate.settings',
            'uses' => 'RealEstateController@getSettings',
        ]);

        Route::post('settings', [
            'as'   => 'real-estate.settings',
            'uses' => 'RealEstateController@postSettings',
        ]);

        Route::group(['prefix' => 'properties', 'as' => 'property.'], function () {
            Route::resource('', 'PropertyController')->parameters(['' => 'property']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'PropertyController@deletes',
                'permission' => 'property.destroy',
            ]);
        });

        Route::group(['prefix' => 'projects', 'as' => 'project.'], function () {
            Route::resource('', 'ProjectController')->parameters(['' => 'project']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ProjectController@deletes',
                'permission' => 'project.destroy',
            ]);
        });

        Route::group(['prefix' => 'property-features', 'as' => 'property_feature.'], function () {
            Route::resource('', 'FeatureController')->parameters(['' => 'property_feature']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'FeatureController@deletes',
                'permission' => 'property_feature.destroy',
            ]);
        });

        Route::group(['prefix' => 'investors', 'as' => 'investor.'], function () {
            Route::resource('', 'InvestorController')->parameters(['' => 'investor']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'InvestorController@deletes',
                'permission' => 'investor.destroy',
            ]);
        });

        Route::group(['prefix' => 'consults', 'as' => 'consult.'], function () {
            Route::resource('', 'ConsultController')->parameters(['' => 'consult'])->except(['create', 'store']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ConsultController@deletes',
                'permission' => 'consult.destroy',
            ]);
        });

        Route::group(['prefix' => 'categories', 'as' => 'category.'], function () {
            Route::resource('', 'CategoryController')->parameters(['' => 'category']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'CategoryController@deletes',
                'permission' => 'category.destroy',
            ]);
        });

    });

    Route::post('send-consult', [
        'as'   => 'public.send.consult',
        'uses' => 'PublicController@postSendConsult',
    ]);
});
