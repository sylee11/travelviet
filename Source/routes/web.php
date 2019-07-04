<?php
use Illuminate\Routing\Controller;
use App\Http\Controllers\HomeController;

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



//Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
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
		Route::post('/delete','CategoryController@delete');
		Route::post('/edit','CategoryController@edit');
		 Route::post('/editlayout','CategoryController@editlayout');
		 Route::get('/addlayout',function(){
			return view('admin.category.addlayout');
		 });
		 Route::post('/add','CategoryController@add');
		 
	});
	Route::group(['prefix' => 'place','namespace'=>'place'], function(){
		Route::get('/', 'PlaceController@index')->name('admin.place.index');
	});
	Route::group(['prefix' => 'rating','namespace'=>'rating'], function(){
		Route::get('/', 'RatingController@index')->name('admin.rating.index');
	});
});

Route::get('/home', function() {
	return view('pages.home');
    //
});
Route::get('fb-callback','PhpSdkController@callback');
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
Route::get('/home','HomeController@index')->name('home');

Auth::routes();

