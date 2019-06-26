<?php

namespace App\Http\Controllers\place;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{
    public function index()
    {
        return view('admin.place.index');
    }
}
