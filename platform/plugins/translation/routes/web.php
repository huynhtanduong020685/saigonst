<?php

Route::group(['namespace' => 'Botble\Translation\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'system/translations'], function () {
            Route::get('/', [
                'as'         => 'translations.index',
                'uses'       => 'TranslationController@getIndex',
                'permission' => 'translations.edit',
            ])->where('groupKey', '.*');

            Route::post('edit', [
                'as'         => 'translations.group.edit',
                'uses'       => 'TranslationController@update',
                'permission' => 'translations.edit',
            ])->where('groupKey', '.*');

            Route::post('add', [
                'as'         => 'translations.group.add',
                'uses'       => 'TranslationController@postAdd',
                'permission' => 'translations.create',
            ])->where('groupKey', '.*');

            Route::post('delete', [
                'as'         => 'translations.group.destroy',
                'uses'       => 'TranslationController@postDelete',
                'permission' => 'translations.destroy',
            ])->where('groupKey', '.*');

            Route::post('publish', [
                'as'         => 'translations.group.publish',
                'uses'       => 'TranslationController@postPublish',
                'permission' => 'translations.edit',
            ])->where('groupKey', '.*');

            Route::post('import', [
                'as'         => 'translations.import',
                'uses'       => 'TranslationController@postImport',
                'permission' => 'translations.edit',
            ]);

            Route::post('find', [
                'as'         => 'translations.find',
                'uses'       => 'TranslationController@postFind',
                'permission' => 'translations.create',
            ]);
        });
    });
});
