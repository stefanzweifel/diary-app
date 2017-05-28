<?php

Route::get('test', function() {

    $paginator = App\Journal::paginate(1);
    $journals = $paginator->getCollection();

    return fractal()
       ->collection($journals)
       ->transformWith(new Diary\Transformers\JournalTransformer())
       ->addMeta(['key1' => 'value1'], ['key2' => 'value2'])
       ->paginateWith(new League\Fractal\Pagination\IlluminatePaginatorAdapter($paginator))
       ->withResourceName('journal')
       ->respond();
});

Route::group(['middleware' => ['auth:api', 'throttle']], function() {

    Route::group([], function() {

        // User
        Route::get('user', 'UserController@index')->name('api.user.index');

        // MasterPassword
        Route::post('master-password', 'MasterPasswordController@store')->name('api.master-password.store');
        Route::post('master-password/unlock', 'MasterPasswordController@unlock')->name('api.master-password.unlock');

        // Journals
        Route::get('journals', 'JournalController@index')->name('api.journals.index');
        Route::post('journals', 'JournalController@store')->name('api.journals.store');
        Route::get('journals/{journal}', 'JournalController@show')->name('api.journals.show');
        Route::patch('journals/{journal}', 'JournalController@update')->name('api.journals.update');
        Route::delete('journals/{journal}', 'JournalController@destroy')->name('api.journals.destroy');

        // Journal Entries
        Route::get('journals/{journal}/entries', 'JournalEntryController@index')->name('api.journals.entries.index');
        Route::post('journals/{journal}/entries', 'JournalEntryController@store')->name('api.journals.entries.store');
        Route::patch('journals/{journal}/entries', 'JournalEntryController@update')->name('api.journals.entries.update');

        // Entries
        Route::get('entries', 'EntryController@index')->name('api.entries.index');
        Route::get('entries/{entry}', 'EntryController@show')->name('api.entries.show');
        Route::patch('entries/{entry}', 'EntryController@update')->name('api.entries.update');
        Route::delete('entries/{entry}', 'EntryController@destroy')->name('api.entries.destroy');

    });

});