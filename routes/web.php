<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Redirect root to admin
Route::get('/', function(){ return redirect('/admin'); });
Route::get('/home', function(){ return redirect('/admin'); });

Route::middleware(['web', 'auth'])->group(function(){
    // show the admin app
    Route::get('/admin', function(){
        return view('admin.app');
    });
    include(__DIR__ . '/shared.php');
});

// handle short url redirect
Route::get('/{id}', 'UrlController@redirectCodeToUrl');
