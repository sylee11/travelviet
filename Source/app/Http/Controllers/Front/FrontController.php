<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\City;
use App\District;
use App\Place;
use App\Post;
use App\Rating;
use App\User;
use Auth;
use Response;
use App\Events\ViewPostHandler;
use Config;

use DB;

class FrontController extends Controller
{
	public function index()
	{
		$category = Category::all();
		$city = City::all();
		$district = District::all();
		//show top users

		$user = User::join('posts', 'posts.user_id', '=', 'users.id')
		->select('posts.user_id', \DB::raw('count(posts.id) as amount'))
		->orderBy('amount', 'desc')
		->groupBy('posts.user_id')
		->take(Config::get('constant.numberRecord1'))
		->get();
		$top_user = array();
		foreach ($user as $value) {
			$top = User::where('id', '=', $value->user_id)->first();
			array_push($top_user, $top);
		}
		//show posts have rating highest
		$top_rating = Post::join('ratings', 'posts.id', '=', 'ratings.post_id')
		->join('photos', 'posts.id', '=', 'photos.post_id')
		->select('posts.id', 'posts.title','posts.slug', 'photos.photo_path', \DB::raw('avg(ratings.rating) as avg_rating'))
		->orderBy('avg_rating', 'desc')
		->groupBy('posts.id')
		->groupBy('posts.title')
		->groupBy('photos.photo_path')
		->where([
			['is_approved', '=', '1'],
			['photos.flag', '=', '1']
		])
		->take(Config::get('constant.numberRecord1'))
		->get();
		//show post newest
		$new_post = Post::join('photos', 'posts.id', '=', 'photos.post_id')
		->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->select('posts.id', 'title','posts.slug', 'photos.photo_path', \DB::raw('avg(ratings.rating) as avg_rating'))
		->orderBy('posts.id', 'desc')
		->groupBy('posts.id')
		->groupBy('title')
		->groupBy('photos.photo_path')
		->where([
			['is_approved', '=', '1'],
			['photos.flag', '=', '1']
		])
		->take(Config::get('constant.numberRecord2'))
		->get();

		$all_post = Post::join('photos', 'posts.id', '=', 'photos.post_id')
		->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->select('posts.id', 'title','posts.slug', 'photos.photo_path', \DB::raw('avg(ratings.rating) as avg_rating'))
		->orderBy('posts.id', 'desc')
		->groupBy('posts.id')
		->groupBy('title')
		->groupBy('photos.photo_path')
		->where([
			['is_approved', '=', '1'],
			['photos.flag', '=', '1']
		])
		->take(Config::get('constant.numberRecord3'))
		->get();

		$cities = Post::join('places', 'posts.place_id', '=', 'places.id')
		->join('districts', 'places.districts_id', '=', 'districts.id')
		->join('cities', 'districts.cities_id', '=', 'cities.id')
		->select('cities.id','posts.slug', \DB::raw('count(posts.id) as sum'))
		->orderBy('sum', 'desc')
		->groupBy('cities.id')
		->where('is_approved', '=', '1')->take(Config::get('constant.numberRecord2'))->get();
		$array = array();
		foreach ($cities as $value) {
			$tt = Post::join('places', 'posts.place_id', '=', 'places.id')
			->join('districts', 'places.districts_id', '=', 'districts.id')
			->join('cities', 'districts.cities_id', '=', 'cities.id')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->select('photos.photo_path', 'cities.name', 'cities.id','posts.slug')
			->where([
				['cities.id', '=', $value->id],
				['is_approved', '=', '1'],
				['photos.flag', '=', '1']
			])
			->first();
			array_push($array, $tt);
		}

		return view('pages.index', ['new_post' => $new_post, 'top_rating' => $top_rating, 'top_user' => $top_user, 'all_post' => $all_post, 'city_post' => $array, 'category' => $category, 'district' => $district, 'city' => $city]);
	}

	public function allPosts(){
		$post= DB::table('posts')
		->join('places','posts.place_id','=','places.id')
		->join('districts', 'places.districts_id', '=', 'districts.id')
		->join('cities', 'districts.cities_id', '=', 'cities.id')
		->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')

		->where([
			['photos.flag', '=', '1'],
			['is_approved','=','1']
		])

		->paginate(Config::get('constant.pagenation'));
		$category= Category::all();

		return view('pages.allPost',['category'=>$category,'all_post'=>$post]);
	}
	public function searchPost(Request $request){
		$search_city = $request->get('search_city');
		$result1 = City::where('name', 'LIKE',$search_city.'%')->get();
		$place = $request->get('place');
		$city = $request->get('city_input');
		$category= $request->get('category');
		$city_selected= $request->get('city_selected');
		if($place){
			if($category != 0){
				if($city){
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('categories', 'categories.id', '=', 'places.category_id')
					->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['cities.name','LIKE',$city.'%'],
						['places.name','LIKE','%'.$place.'%'],
						['categories.id', '=',$category],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}else if($city_selected){
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('categories', 'categories.id', '=', 'places.category_id')
					->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['cities.name', '=',$city_selected],
						['places.name','LIKE','%'.$place.'%'],
						['categories.id', '=',$category],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}else{
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('categories', 'categories.id', '=', 'places.category_id')
					->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['places.name','LIKE','%'.$place.'%'],
						['categories.id', '=',$category],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}
			}else{
				if($city){
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['cities.name','LIKE',$city.'%'],
						['places.name','LIKE','%'.$place.'%'],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}else if($city_selected){
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['cities.name', '=',$city_selected],
						['places.name','LIKE','%'.$place.'%'],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}else{
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id','posts.slug','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['places.name','LIKE','%'.$place.'%'],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}
			}
		}else{
			if($category != 0){
				if($city){
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('categories', 'categories.id', '=', 'places.category_id')
					->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['cities.name','LIKE',$city.'%'],
						['categories.id', '=',$category],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}else if($city_selected){
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('categories', 'categories.id', '=', 'places.category_id')
					->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['cities.name', '=',$city_selected],
						['categories.id', '=',$category],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}else{
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('categories', 'categories.id', '=', 'places.category_id')
					->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['categories.id', '=',$category],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}
			}else{
				if($city){
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['cities.name','LIKE',$city.'%'],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}else if($city_selected){
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id','posts.describer','posts.slug','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['cities.name', '=',$city_selected],
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}else{
					$post= DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts', 'places.districts_id', '=', 'districts.id')
					->join('cities', 'districts.cities_id', '=', 'cities.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id','posts.slug','posts.describer','places.address', 'posts.title','photos.photo_path','places.name',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
					->where([
						['photos.flag', '=', '1'],
						['is_approved','=','1']
					])
					->paginate(Config::get('constant.pagination1'));
				}
			}
		}
		$output = '';
		$total_row = $post->count();
		if($total_row > 0)
		{
			foreach($post as $row)
			{
				$output .= '
				<div class="col-sm-6" style="margin:10px 0;">
				<div class="card-img" id="card-img" style="background-color: #e2e2e2;">
				<a href="'.route("detail",$row->slug).'" title="" style="text-decoration: none;" id="pic">
				<div style="height: 200px;">
				<img class="card-img-top list_images" src="' .$row->photo_path. '" alt="'.htmlspecialchars($row->title,ENT_QUOTES).'" >
				</div>
				<div class="card-body">
				<h5 class="card-title text-primary">
				<span style="display:block;text-overflow: ellipsis;overflow: hidden; white-space: nowrap;font-size: 16px;color: black;">
				'.htmlspecialchars($row->title,ENT_QUOTES).'
				</span>
				</h5>
				<div class="rating">';
				for($i=0;$i< ceil($row->avg_rating);$i++){
					$output .='<span class="fa fa-star checked" ></span>';
				}
				for($i=ceil($row->avg_rating);$i< 5;$i++){
					$output .='<span class="fa fa-star unchecked" ></span>';
				}
				$output .='</div>
				<p class="card-text">
				</p>
				</div>
				</a>
				</div>
				</div>'
				;
			}
		}else{
			$output .= '
			<div style="margin:10px 0;color:red;font-weight:bold;font-size:20px;text-align:center;" >Không có bài viết nào</div>
			';
		}
		$data1 = array(
			'table_data'  => $output,
			'total_data'  => $total_row
		);
		return response()->json(['all_posts' => $post,'data1'=>$data1,'city'=>$result1]);
	}
	public function detail($slug)
	{
		if(Post::where('slug',$slug)->first() == null){
			return view('includes.erro404');
		}
		$post = Post::where('slug',$slug)->first();
		event(new ViewPostHandler($post));
		$post_id = DB::table('posts')
		->select('posts.id')
		->where('posts.slug','=',$slug)->first()->id;
		$data = DB::table('posts')
		->join('photos', 'posts.id', '=', 'photos.post_id')
		->join('users', 'posts.user_id', '=', 'users.id')
		->join('places', 'posts.place_id', '=', 'places.id')
		->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->leftJoin('users as userscmt', 'ratings.user_id', '=', 'userscmt.id')
		->select('posts.id', 'posts.place_id', 'posts.title', 'posts.user_id', 'posts.describer','posts.slug','posts.view_count' ,'posts.created_at as create_at', 'photos.photo_path', 'users.name', 'places.name as place', 'places.lat', 'places.longt','places.address','ratings.id as rating_id' ,'ratings.cmt', 'ratings.rating as rate', 'ratings.created_at', 'userscmt.id as cmtid', 'userscmt.name as cmtname', 'userscmt.avatar')
		->where('posts.id', '=', $post_id)
		->get();
		$rating = DB::table('ratings')
		->where('post_id', $post_id)
		->avg('rating');
		$rating = number_format($rating, 1);
		$user_id = \Auth::id();
		$user_rate =  DB::table('ratings')->select('rating')->where([
			['user_id', '=', $user_id],
			['post_id', '=', $post_id],
		])->whereNotNull('rating')
		->orderBy('id', 'desc')->first();
		session()->put('link',  url()->current());
		$data2 = DB::table('posts')
		->join('photos', 'posts.id', '=', 'photos.post_id')
		->join('places', 'posts.place_id', '=', 'places.id')
		->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->select('posts.id', 'posts.title','posts.slug', 'photos.photo_path')
		->where([
			['posts.place_id', '=', $data[0]->place_id],
			['photos.flag', '=', 1],
			['posts.id', '<>', $post_id]
		])
		->distinct()
		->take(Config::get('constant.numberRecord1'))
		->get();
		foreach ($data2 as $index => $value) {
			$value->rate = DB::table('ratings')
			->where('post_id', $value->id)
			->avg('rating');
		}
		return view('pages/detail', ['data' => $data, 'rating' => $rating, 'user_rate' => $user_rate,'post_relate'=>$data2]);
	}
	public function rate(Request $request)
	{
		$rating = $request->get('rating');
		if ($rating != NULL && $rating !=1 && $rating !=2 &&$rating !=3 && $rating !=4 && $rating !=5){
			return back();
		}
		$cmt = htmlspecialchars($request->get('commentarea'));
		$user_id = Auth::id();
		$post_id = $request->session()->pull('post_id');
		//$user_rate = DB::table('ratings')->where('user_id', $user_id)->first();
		$rate = new Rating;
		$rate->cmt = $cmt;
		$rate->user_id = $user_id;
		$rate->post_id = $post_id;
		if ($rating === NULL) {
			$rate->save();
		} else {
			DB::table('ratings')->where([
				['user_id', '=', $user_id],
				['post_id', '=', $post_id],
			])->update(['rating' => null]);
			$rate->rating = $rating;
			$rate->save();
		}
		return back();
	}
	public function upgrade(Request $request)
	{
		$user = Auth::user();
		$user->role = '2';
		$user->save();
		return redirect('/');
	}

	public function showPosts($id)
	{
		$post_city = Post::join('places', 'posts.place_id', '=', 'places.id')
		->join('districts', 'places.districts_id', '=', 'districts.id')
		->join('cities', 'districts.cities_id', '=', 'cities.id')
		->join('photos', 'posts.id', '=', 'photos.post_id')
		->join('users', 'posts.user_id', '=', 'users.id')
		->where([
			['cities.id', '=', $id],
			['is_approved', '=', '1'],
			['photos.flag', '=', '1']
		])
		->orderBy('posts.id', 'desc')
		->paginate(Config::get('constant.pagination1'));
		$name_city = City::where('id', '=', $id)->first();
		return view('pages.postsCity', ['post_city' => $post_city, 'name_city' => $name_city]);
	}
	public function userInfo($user_id)
	{
		$data = DB::table('users')->find($user_id);
		return view('pages/userInfo', ['data' => $data]);
	}
	public function userPost($user_id)
	{
		$data = \DB::table('posts')
		->join('photos', 'posts.id', '=', 'photos.post_id')
		->join('users', 'posts.user_id', '=', 'users.id')
		->select('posts.id as post_id', 'posts.title','posts.slug' ,'posts.describer', 'posts.created_at', 'posts.is_approved', 'photos.photo_path', 'users.name')
		->where([
			['posts.user_id', '=', $user_id],
			['posts.is_approved', '=', '1'],
			['photos.flag', '=', '1']
		])
		->orderBy('posts.id', 'desc')
		->paginate(Config::get('constant.pagination1'));
		return view('pages/userpost', ['data' => $data]);
	}
	public function userComment($user_id)
	{
		$data = \DB::table('ratings')
		->join('posts', 'ratings.post_id', '=', 'posts.id')
		->join('users', 'ratings.user_id', '=', 'users.id')
		->select('ratings.id', 'ratings.cmt', 'ratings.created_at', 'ratings.rating', 'posts.id as post_id','posts.slug', 'posts.title', 'users.name')
		->where('ratings.user_id', '=', $user_id)->get();
		return view('pages/mycmt', ['data' => $data]);
	}
}
