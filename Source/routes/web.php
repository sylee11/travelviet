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
Route::get('register', 'Auth\dangkiController@getRegister')->name('register');
Route::post('register','Auth\dangkiController@postRegister')->name('register');

Route::group(['prefix' => 'admin'], function () {

	Route::get('/', 'AdminController@index')->name('admin.index');

	Route::group(['prefix' => 'user','namespace'=>'user'], function(){
		Route::get('/', 'UserController@index')->name('admin.user.index');

	    Route::post('/add', 'UserController@store')->name('admin.user.add');
	    Route::post('/register', 'UserRegisterController@store')->name('admin.user.register');

	    Route::get('/edit/{id}', 'UserController@getedit')->name('admin.user.edit');
	    Route::post('/edit/{id}', 'UserController@postedit')->name('admin.user.edit1');

	    Route::get('/delete/{id}', 'UserController@xoa')->name('admin.user.delete');
	    Route::get('/block/{id}', 'UserController@block')->name('admin.user.block');
	});
	Route::group(['prefix' => 'post','namespace'=>'post'], function(){
		Route::get('/', 'PostController@index')->name('admin.post.index');
	});
	Route::group(['prefix' => 'category','namespace'=>'category'], function(){
		Route::get('/', 'CategoryController@index')->name('admin.category.index');
	});
	Route::group(['prefix' => 'place','namespace'=>'place'], function(){
		Route::get('/', 'PlaceController@index')->name('admin.place.index');
		Route::get('/delete/{id}', 'PlaceController@xoa')->name('admin.place.delete');

		Route::get('/edit/{id}', 'PlaceController@getedit')->name('admin.place.edit');
	    Route::post('/edit/{id}', 'PlaceController@postedit')->name('admin.place.edit1');

	});
	Route::group(['prefix' => 'rating','namespace'=>'rating'], function(){
		Route::get('/', 'RatingController@index')->name('admin.rating.index');
	});
});


Route::get('/abc', function() {
	return view('Test');
    //
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');