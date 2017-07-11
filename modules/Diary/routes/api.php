<?php

Route::group(['middleware' => ['auth:api', 'throttle']], function() {

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

    // Entry Media
    Route::get('entries/{entry}/media', 'EntryMediaController@index')->name('api.entries.media.index');
    Route::post('entries/{entry}/media', 'EntryMediaController@store')->name('api.entries.media.store');
    Route::delete('entries/{entry}/media/{media}', 'EntryMediaController@destroy')->name('api.entries.media.destroy');

});