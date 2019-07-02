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

Auth::routes();
Route::group(['namespace' => 'Front'], function (){
    Route::get('/', 'FrontController@index')->name('pages.home');
    Route::get('/home', function(){
    	return view('pages.home');
    })->name('home');
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
		Route::get('/', 'PostController2@index')->name('admin.post.index');
		Route::get('/delete/{id}', 'PostController2@destroy')->name('admin.post.delete');
		Route::get('/approved/{id}', 'PostController2@approved')->name('admin.post.approved');
		Route::get('/unapproved/{id}', 'PostController2@unapproved')->name('admin.post.unapproved');
		    //
	});
	Route::group(['prefix' => 'category','namespace'=>'category'], function(){
		Route::get('/', 'CategoryController@index')->name('admin.category.index');
	});
	Route::group(['prefix' => 'place','namespace'=>'place'], function(){
		Route::get('/', 'PlaceController@index')->name('admin.place.index');
	});
	Route::group(['prefix' => 'rating','namespace'=>'rating'], function(){
		Route::get('/', 'RatingController@index')->name('admin.rating.index');
	});
});

//Reset password
Route::group(['prefix' => 'account'], function() {
	Route::group(['prefix' => 'password'], function() {
		Route::get('/sendmail' ,'Auth\PasswordResetController@index')->name('account.password.sendmail');
	    Route::post('/create' ,'Auth\PasswordResetController@create')->name('account.password.create');
	    Route::post('/reset' ,'Auth\PasswordResetController@reset')->name('account.password.reset');
		Route::get('/setnewpasss/{token}' ,'Auth\PasswordResetController@showResetForm')->name('account.password.setnewpass');
		Route::get('/sendmailsuccess' ,function(){
			return view('notifation.sendmailsuccess');
		})->name('sendmailsuccess');
		Route::get('/resetpassdone' ,function(){
			return view('notifation.resetpassdone');
		})->name('resetpassdone');

	});
});

Route::get('/abc', 'test@index');

Route::get('/abc', function() {
	return view('Test');
    //
});

Auth::routes();
