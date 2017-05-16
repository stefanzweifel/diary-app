<?php

// use Dingo\Api\Routing\Router;
use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:api'], function() {

    Route::group([], function() {

        // User
        Route::get('user', '\Diary\Api\Http\Controllers\UserController@index')->name('api.user.index');

        // MasterPassword
        Route::post('master-password', '\Diary\Api\Http\Controllers\MasterPasswordController@store')->name('api.master-password.index');
        Route::post('master-password/unlock', '\Diary\Api\Http\Controllers\MasterPasswordController@unlock')->name('api.master-password.unlock');

        // Journals
        Route::get('journals', '\Diary\Api\Http\Controllers\JournalController@index')->name('api.journals.index');
        Route::post('journals', '\Diary\Api\Http\Controllers\JournalController@store')->name('api.journals.store');
        Route::get('journals/{journal}', '\Diary\Api\Http\Controllers\JournalController@show')->name('api.journals.show');
        Route::patch('journals/{journal}', '\Diary\Api\Http\Controllers\JournalController@update')->name('api.journals.update');
        Route::delete('journals/{journal}', '\Diary\Api\Http\Controllers\JournalController@destroy')->name('api.journals.destroy');

        // Journal Entries
        Route::get('journals/{journal}/entries', '\Diary\Api\Http\Controllers\JournalEntryController@index')->name('api.journals.entries.index');
        Route::post('journals/{journal}/entries', '\Diary\Api\Http\Controllers\JournalEntryController@store')->name('api.journals.entries.store');
        Route::patch('journals/{journal}/entries', '\Diary\Api\Http\Controllers\JournalEntryController@update')->name('api.journals.entries.update');

        // Entries
        Route::get('entries', '\Diary\Api\Http\Controllers\EntryController@index')->name('api.entries.index');
        Route::get('entries/{entry}', '\Diary\Api\Http\Controllers\EntryController@show')->name('api.entries.show');
        Route::patch('entries/{entry}', '\Diary\Api\Http\Controllers\EntryController@update')->name('api.entries.update');
        Route::delete('entries/{entry}', '\Diary\Api\Http\Controllers\EntryController@destroy')->name('api.entries.destroy');

    });

});