<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Shared Routes
|--------------------------------------------------------------------------
|
| Here is where you can register routes that:
| 1) power the admin SPA (using traditional session cookie for auth)
| 2) also powers the REST API (uses bearer token for auth)
|
*/

// handle url CRUD
Route::resource('urls', 'UrlController')
     ->only([ 'index', 'store', 'update', 'destroy']);
Route::get('urls/count', 'UrlController@count');

// handle anayltics view
Route::resource('clicks', 'ClicksController')
     ->only([ 'index']);
Route::get('clicks/count', 'ClicksController@count');
