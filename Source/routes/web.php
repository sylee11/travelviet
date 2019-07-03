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


Route::group(['namespace' => 'Front'], function (){
	Route::get('/', 'FrontController@index')->name('pages.home');
});


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('register', 'Auth\RegisterController@showFormRegister')->name('register');

Route::get('auth/google', 'Auth\SocialAuthController@redirectToProvider')->name('login.social');
Route::get('auth/google/callback', 'Auth\SocialAuthController@handleProviderCallback');


Route::group(['prefix' => 'admin'], function () {

	Route::get('/', 'AdminController@index')->name('admin.index');

	Route::group(['prefix' => 'user','namespace'=>'user'], function(){
		Route::get('/', 'UserController@index')->name('admin.user.index');
	});
	Route::group(['prefix' => 'post','namespace'=>'post'], function(){
		Route::get('/', 'PostController@index')->name('admin.post.index');
	});
	Route::group(['prefix' => 'category','namespace'=>'category'], function(){
		Route::get('/', 'CategoryController@index')->name('admin.category.index');
	});
	Route::group(['prefix' => 'place','namespace'=>'place'], function(){
		Route::get('/', 'PlaceController@index')->name('admin.place.index');
	});
	Route::group(['prefix' => 'rating','namespace'=>'rating'], function(){
		Route::get('/', 'RatingController@index')->name('admin.rating.index');
		Route::post('/','RatingController@add')->name('admin.rating.add');
		Route::get('edit/{id}', 'RatingController@edit')->name('admin.rating.edit');
		Route::post('update/{id}', 'RatingController@update')->name('admin.rating.update');
  //       Route::post('update/{category}', 'CategoryController@update')->name('admin.category.update');
  //       Route::get('delete/{category}', 'CategoryController@destroy')->name('admin.category.delete');
	});
});


Route::get('/abc', function() {
	return view('Test');
    //
});

Auth::routes();