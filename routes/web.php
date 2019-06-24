<?php

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
    return view('welcome');
});
Route::get('/abc', function () {
    echo "Hello WORkD le";
});
Route::get('/account' , function(){
	return view('login');	
});
Route::get('/',function(){
	return view('pages.home');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('login','LoginController@getLogin')->name('login');
Route::get('/admin',function(){
	return view('admin.index');
});
Route::get('/tables',function(){
	return view('admin.tables');
});
Route::get('/charts',function(){
	return view('admin.charts');
});