<?php

namespace App\Http\Controllers\category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Category::all();
       
       return view('admin.category.index', ['categories' => $categories]);
    }
    public function delete()
    {

        
        $id = \Request::get('delete');
        \App\Category::destroy($id);
        $categories = \App\Category::all();
        return view('admin.category.index', ['categories' => $categories]);
    }
    public function editlayout()
    {
        $id = \Request::get('edit');
        $category=\App\Category::find($id);
        $data['id'] = $id;
        $data['name']=$category->name;
        return view('admin.category.edit',['data'=>$data]);;
     
    }
    public function edit()
    {

   
        $id =\Request::get('id');
        $name =\Request::get('name');
        $category=\App\Category::find($id);
        $category->name = $name;
        $category->save();
        $categories = \App\Category::all();
        return view('admin.category.index', ['categories' => $categories]);
        
    }
    public function add(){
        $category = new \App\Category;
        $category->name = \Request::get('name');
        $category->save();
        $categories = \App\Category::all();
        return view('admin.category.index', ['categories' => $categories]);
        
    }
}
