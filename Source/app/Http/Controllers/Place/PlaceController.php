<?php

namespace App\Http\Controllers\place;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Place;
use DB;
class PlaceController extends Controller
{
    public function index()
    {
        // $place=Place::all();

    	$place = DB::table('places')
    	->leftJoin('categories','places.category_id', '=', 'categories.id')

    	->leftJoin('districts','places.districts_id', '=', 'districts.id')
    	->leftJoin('cities','districts.cities_id', '=', 'cities.id')
    	      ->select('places.*', 'categories.name as name_category','cities.name as name_cities')->get();
        return view('admin.place.index',['place'=>$place]);
    }

   public function xoa($id)
    {
    	// $id =\Request::get('xoa'); 
    	// Place::destroy($id);
        $place = Place::find($id);
        $place->delete();
        $place = DB::table('places')
    	->leftJoin('categories','places.category_id', '=', 'categories.id')

    	->leftJoin('districts','places.districts_id', '=', 'districts.id')
    	->leftJoin('cities','districts.cities_id', '=', 'cities.id')
    	      ->select('places.*', 'categories.name as name_category','cities.name as name_cities')->get();
        return view('admin.place.index',['place'=>$place]);
    }

   public function getedit ($id)
    {
    	$place=Place::find($id);
        return view('admin.place.edit',['place'=>$place]);
    }
    public function postedit (Request $request,$id)
    {
        $place = Place::find($id);

        $this->validate($request,
            [
                'name'=>'required|max:255',
                
            ],
            [
                'name.max(255)'=>'ten co do dai ko qua 255',
                'email.unique'=>'email da ton tai'

            ]
        );
        $place->name = $request->get('name');
        $place->address = $request->get('address');
        


        $place->save();

        return \Redirect::route('admin.place.edit', [$place->id])->with('message', 'Place has been updated!');
        
    }
}
