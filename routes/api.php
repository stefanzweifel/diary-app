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

        Route::get('journals', '\Diary\Api\Http\Controllers\JournalController@index')->name('api.journals.index');
        Route::post('journals', '\Diary\Api\Http\Controllers\JournalController@store')->name('api.journals.store');
        Route::get('journals/{journal}', '\Diary\Api\Http\Controllers\JournalController@show')->name('api.journals.show');
        Route::patch('journals/{journal}', '\Diary\Api\Http\Controllers\JournalController@update')->name('api.journals.update');
        Route::delete('journals/{journal}', '\Diary\Api\Http\Controllers\JournalController@destroy')->name('api.journals.destroy');

    });


});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return ['data' => $request->user()];
    return $request->user();
});


// $api = app(Router::class);
// $api->version('v1', ['middleware' => ['api.auth', 'api.throttle'], 'limit' => 200, 'expires' => 5], function ($api) {


//     // -----------------------------------------

//     $api->get('journals/{id}/entries', [
//         'uses' => 'Diary\Api\Http\Controllers\JournalEntryController@index',
//         'as' => 'journal.entries.index'
//     ]);

//     $api->post('journals/{id}/entries', [
//         'uses' => 'Diary\Api\Http\Controllers\JournalEntryController@store',
//         'as' => 'journal.entries.store'
//     ]);

//     // $api->patch('journals/{id}/entries/{entriesId}', [
//     //     'uses' => 'Diary\Api\Http\Controllers\JournalEntryController@update',
//     //     'as' => 'journal.entries.update'
//     // ]);

//     // -----------------------------------------

//     $api->get('entries/', [
//         'uses' => 'Diary\Api\Http\Controllers\EntryController@index',
//         'as' => 'entries.index'
//     ]);

//     $api->get('entries/{id}', [
//         'uses' => 'Diary\Api\Http\Controllers\EntryController@show',
//         'as' => 'entries.show'
//     ]);

//     $api->patch('entries/{id}', [
//         'uses' => 'Diary\Api\Http\Controllers\EntryController@update',
//         'as' => 'entries.update'
//     ]);

//     $api->delete('entries/{id}', [
//         'uses' => 'Diary\Api\Http\Controllers\EntryController@destroy',
//         'as' => 'entries.destroy'
//     ]);

//     // ----------------------------------------------------

//     $api->get('user/', [
//         'uses' => 'Diary\Api\Http\Controllers\UserController@index',
//         'as' => 'users.index'
//     ]);

//     $api->post('master-password', [
//         'uses' => 'Diary\Api\Http\Controllers\MasterPasswordController@store',
//         'as' => 'master-password.store'
//     ]);

//     $api->post('master-password/unlock', [
//         'uses' => 'Diary\Api\Http\Controllers\MasterPasswordController@unlock',
//         'as' => 'master-password.unlock'
//     ]);

// });