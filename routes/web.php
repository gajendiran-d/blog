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

Route::get('/', function () {
    return redirect('listPost');
});
Route::middleware(['auth', 'login'])->group(function () {
    Route::resource('/post', 'PostController');
    Route::get('/otherPost', 'PostController@otherPost');
    Route::post('/updateStatus', 'PostController@updateStatus');
    Route::get('/user', 'HomeController@user');
    Route::post('/updateUser', 'HomeController@updateUser');
    Route::post('/addComment', 'PostController@addComment');
});
Route::get('/listPost', 'PostController@listPost');
Route::get('/viewPost/{id}', 'PostController@viewPost');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
