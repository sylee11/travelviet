<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use DB;

class AdminController extends Controller
{
	public function index()
	{
		$user_year=User::
		select(DB::raw('year(created_at) as getYear'), DB::raw('COUNT(*) as value'))
		->groupBy('getYear')
		->orderBy('getYear', 'ASC')
		->get();

		$user_month=DB::table('users')
		->select(DB::raw('month(created_at) as getMonth'), DB::raw('COUNT(*) as value'))
		->whereYear('created_at','=','2018')
		->groupBy('getMonth')
		->orderBy('getMonth', 'ASC')
		->get();
		//dd($user_month);
		return view('admin.index', compact('user_year'));
	}
}
