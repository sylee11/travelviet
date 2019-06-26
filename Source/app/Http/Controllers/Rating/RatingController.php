<?php

namespace App\Http\Controllers\rating;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    public function index()
    {
        return view('admin.rating.index');
    }
}
