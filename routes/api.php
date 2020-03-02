<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/contacts', 'ContactsController@store');
Route::get('/contacts/{contact}', 'ContactsController@show');
Route::delete('/contacts/{contact}', 'ContactsController@destroy');
Route::patch('/contacts/{contact}', 'ContactsController@update');
