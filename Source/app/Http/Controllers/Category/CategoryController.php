<?php

namespace App\Http\Controllers\category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
        return back();
    }
    public function editlayout()
    {
        $id = \Request::get('edit');
        $category = \App\Category::find($id);
        $data['id'] = $id;
        $data['name'] = $category->name;
        return view('admin.category.edit', ['data' => $data]);
    }
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|unique:categories,name|max:255',
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('/admin/category')
                ->withErrors($validator);
        }
        $id = \Request::get('id');
        $name = \Request::get('name');
        $category = \App\Category::find($id);
        $category->name = $name;
        $category->save();
        return redirect('/admin/category');
    }
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:categories,name|max:255',
        ]);
        $category = new \App\Category;
        $category->name = \Request::get('name');
        $category->save();
        return back();
    }
}
