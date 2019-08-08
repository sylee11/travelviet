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
	Route::get('/', 'FrontController@index')->name('home.page');
	Route::get('/home', function(){
		return view('pages.home');
	})->name('home');
	Route::get('/all-posts', 'FrontController@allPosts')->name('all.posts');
	Route::get('search-post', 'FrontController@searchPost')->name('search.posts');
	Route::get('profile', 'ProfileController@show')->name('profile');
	Route::get('/edit', 'ProfileController@edit')->name('profile.edit');
	Route::get('/post/{id}', 'FrontController@showPosts')->name('show.posts');

	Route::post('/update', 'ProfileController@update')->name('profile.update');
	Route::post('/update_avatar', 'ProfileController@update_avatar')->name('avatar.update');
	
	 Route::get('/searchlist', 'SearchListController@searchlist')->name('search.slide');
	Route::get('/get_city_list', 'SearchListController@getCityList')->name('get.city.list');
	Route::get('/list_place', 'SearchListController@getList')->name('get.list');
	// Route::post('/list_place', 'SearchListController@postList')->name('get.list');
	Route::get('/search_list', 'SearchListController@getsearch')->name('search.list');
	// Route::post('/search_list', 'SearchListController@postsearch')->name('search.list');
	Route::get('/googlemap', 'SearchListController@googlemap')->name('google.map');

    Route::get('/autocomplete', 'SearchListController@autocomplete')->name('autocomplete');
	
	Route::get('/user/{user_id}','FrontController@userInfo');
	Route::get('/user/{user_id}/post','FrontController@userPost');
	Route::get('/user/{user_id}/comment','FrontController@userComment');
	Route::group(['prefix' => 'account', 'middleware' => 'auth'],function(){
		Route::get('/{id}/post', 'PostController@showformAddPost')->name('account.addpost');
		Route::post('/{id}/post', 'PostController@add')->name('account.addpost');
		Route::get('/edit/{idpost}', 'PostController@showformEditPost')->name('account.editpost');
		Route::post('/edit/{idpost}', 'PostController@edit')->name('account.editpost');
		Route::get('/get-city-list', 'PostController@getCityList')->name('acount.post.getcity');
		Route::get('/autocomplete', 'PostController@autocomplete')->name('post.autocomplete');
		Route::get('/autocompletetinh', 'PostController@autocompleteTinh')->name('post.autocompletetinh');
		Route::get('/autocompletehuyen', 'PostController@autocompleteHuyen')->name('post.autocompletehuyen');
		Route::get('/autocompleteAddress', 'PostController@autocompleteAddress')->name('post.autocompleteAddress');
		Route::group(['prefix' => 'admin'], function(){
			Route::get('/approved/show/{id}', 'ApprovedController@show')->name('acount.admin.approved');
			Route::post('/manageacout/blockuser', 'UserController@blockuser')->name('account.admin.blockuser');
			Route::post('/manageacout/findpost', 'UserController@findpost')->name('account.admin.findpost');
			Route::post('/manageacout/delete', 'UserController@delete')->name('account.admin.deleteuser');
			Route::get('/manageacout/search', 'UserController@search')->name('account.admin.searchuser');
			Route::get('/manageacout', 'UserController@show')->name('account.admin.showall');

			Route::get('/approved', 'ApprovedController@show')->name('acount.admin.approved');
			Route::get('/approved/{id}', 'ApprovedController@approved')->name('approved');
			// Route::get('/approved/all', 'ApprovedController@allpost')->name('xxx');
			Route::post('/deletepost', 'ApprovedController@delete')->name('approved/deletepost');
			// Route::get('/approved/search', 'ApprovedController@search')->name('approved.search');
		});
		Route::get('aa/admin/approved/all', 'ApprovedController@allpost')->name('approved.all');
		Route::get('aa/approved/search', 'ApprovedController@search')->name('approved.search');
		Route::get('aa/approved/search/appect', 'ApprovedController@appcetall')->name('approved.appectall');
		Route::get('aa/approved/search/unappect', 'ApprovedController@unappcetall')->name('approved.unappectall');


	});


//	Route::post('/update', 'ProfileController@update')->name('profile.update');
//	Route::post('/update_avatar', 'ProfileController@update_avatar')->name('avatar.update');
	Route::get('/mypost','ProfileController@mypost')->name('mypost');
	Route::post('/mypost/{id}/delete','PostController@delete')->name('mypost.delete');

	Route::get('/detail/{slug}','FrontController@detail')->name('detail')->middleware('viewcount');

	Route::post('/detail/rate','FrontController@rate');
	Route::post('/update-profile', 'ProfileController@update')->name('profile.update');
	Route::post('/update-avatar', 'ProfileController@update_avatar')->name('avatar.update');
	Route::post('/upgrade', 'FrontController@upgrade')->name('upgrade');
	Route::get('/mycomment','ProfileController@mycomment');
});
Route::get('login2',function(){
	return view('auth.login');
});
Route::get('invite', 'InviteController@show')->name('invite')->middleware('auth');
Route::post('invite', 'InviteController@process')->name('process')->middleware('auth');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login.admin');
Route::get('show-register', 'Auth\RegisterController@showFormRegister')->name('show.register');
Route::post('signup', 'Auth\RegisterController@store')->name('signup');

Route::get('auth/google/callback', 'Auth\SocialAuthController@redirectToProvider')->name('login.social');

Route::get('/change_password', 'Auth\ChangePasswordController@show')->name('show_changePass');
Route::post('/update_password', 'Auth\ChangePasswordController@update')->name('update_changePass');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

	Route::get('/', 'AdminController@index')->name('admin.index')->middleware('admin');
	Route::get('chart','AdminController@chart');
	Route::group(['prefix' => 'user','namespace'=>'user'], function(){
		Route::get('/', 'UserController@index')->name('admin.user.index');

		Route::post('/add', 'UserController@store')->name('admin.user.add');

		Route::get('/edit/{id}', 'UserController@getedit')->name('admin.user.edit');
		Route::post('/edit/{id}', 'UserController@postedit')->name('admin.user.edit1');

		Route::get('/delete/{id}', 'UserController@xoa')->name('admin.user.delete');
		Route::get('/block/{id}', 'UserController@block')->name('admin.user.block');
		Route::get('/unblock/{id}', 'UserController@unblock')->name('admin.user.unblock');
	});
	Route::group(['prefix' => 'post','namespace'=>'post'], function(){
		Route::get('/', 'PostController2@index')->name('admin.post.index');
		Route::post('/delete/{id}', 'PostController2@destroy')->name('admin.post.delete');
		Route::get('/approved/{id}', 'PostController2@approved')->name('admin.post.approved');
		Route::get('/unapproved/{id}', 'PostController2@unapproved')->name('admin.post.unapproved');
		Route::post('/add', 'PostController2@store')->name('admin.post.add');
		Route::get('/{id}/detail', 'PostController2@detail')->name('admin.post.detail');
		Route::get('/{id}/edit', 'PostController2@showformedit')->name('admin.post.showedit');
		Route::post('/{id}/edit', 'PostController2@edit')->name('admin.post.edit');
		Route::get('/{id}/edit/deletephoto', 'PostController2@deletephoto')->name('admin.post.deletephoto');
		Route::get('/autocompleteUser', 'PostController2@autocompleteUser')->name('post.autocompleteUser');
		Route::get('/autocompletePlcae', 'PostController2@autocompletePlace')->name('post.autocompletePlace');
		// Route::get('/autocompleteAddress', 'PostController2@autocompleteAddress')->name('post.autocompleteAddress');
		    //
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
		Route::get('/delete/{id}', 'PlaceController@xoa')->name('admin.place.delete');

		Route::get('/edit/{id}', 'PlaceController@getedit')->name('admin.place.edit');
		Route::post('/edit/{id}', 'PlaceController@postedit')->name('admin.place.edit');

        Route::get('/detail/{id}', 'PlaceController@getdetail')->name('admin.place.detail');

		Route::get('/add', 'PlaceController@getadd')->name('admin.place.add');
		Route::post('/add', 'PlaceController@store')->name('admin.place.add');
		Route::get('/get-city-list', 'PlaceController@getCityList')->name('admin.place.getcity');


	});
	Route::group(['prefix' => 'rating','namespace'=>'rating'], function(){
		Route::get('/', 'RatingController@index')->name('admin.rating.index');
		Route::post('/add','RatingController@add')->name('admin.rating.add');
		Route::get('edit/{id}', 'RatingController@edit')->name('admin.rating.edit');
		Route::get('/select', 'RatingController@select')->name('admin.rating.select');
		Route::post('update/{id}', 'RatingController@update')->name('admin.rating.update');
		Route::get('/delete/{id}', 'RatingController@delete')->name('admin.rating.delete');
	});
});

Route::get('/home', function() {
	return view('pages.home');
	

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


//test
Route::get('/abc', function() {
 	return view('test');
})->name('test');