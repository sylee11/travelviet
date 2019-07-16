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

use DB;

class FrontController extends Controller
{
    public function index(){
        $category=Category::all();
		$city=City::all();
		$district=District::all();
		return view('pages.home',['category'=>$category,'district'=>$district,'city'=>$city]);
    }
    
}
	