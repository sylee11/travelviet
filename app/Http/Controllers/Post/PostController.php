<?php

namespace App\Http\Controllers\post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.post.index');
    }
}
