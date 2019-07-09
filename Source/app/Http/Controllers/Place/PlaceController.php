<?php

namespace App\Http\Controllers\place;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Place;
use App\Category;
use App\City;
use App\District;
use DB;
class PlaceController extends Controller
{
    
    public function index()
    {
        
     $place=Place::all();
     $category=Category::all();
     $city=City::all();
     $district=District::all();
     return view('admin.place.index',['place'=>$place,'category'=>$category,'district'=>$district,'city'=>$city]);
        //return($place)->toArray();
     
 }
 public function getadd()
 {
    $place=Place::all();
    $category=Category::all();
    $city=City::all();
    $district=District::all();
    return view('admin.place.add',['place'=>$place,'category'=>$category,'district'=>$district,'city'=>$city]);
 }
 public function getCityList(Request $request)
 {
    $districts = DB::table("districts")
    ->where("cities_id",$request->cities_id)
    ->pluck("name","id");
    return response()->json($districts);

}
 public function store(Request $request)
 {
    $this->validate($request,
        [
            'name'=>'required|max:255'
        ],
        [
            'name.required'=>'bạn tên địa điểm ',
            'name.max(255)'=>'ten co do dai ko qua 255'
        ]
    );
    $place = new Place;
    $place->name=$request->name;
    $place->address=$request->address;
    $place->category_id=$request->category_id;
    $place->districts_id=$request->districts_id;       
    $place->save();
    $place=Place::all();
    $category=Category::all();
    $city=City::all();
    $district=District::all();
    return view('admin.place.add',['place'=>$place,'category'=>$category,'district'=>$district,'city'=>$city]);
}

public function xoa($id)
{
    $place = Place::find($id);
    $place->delete();
    $place=Place::all();
    $category=Category::all();
    $city=City::all();
    $district=District::all();
    return view('admin.place.index',['place'=>$place,'category'=>$category,'district'=>$district,'city'=>$city]);
    // $place = DB::table('places')
    // ->leftJoin('categories','places.category_id', '=', 'categories.id')

    // ->leftJoin('districts','places.districts_id', '=', 'districts.id')
    // ->leftJoin('cities','districts.cities_id', '=', 'cities.id')
    // ->select('places.*', 'categories.name as name_category','cities.name as name_cities')->get();
    // return view('admin.place.index',['place'=>$place]);
}

public function getedit ($id)
{
   $place=Place::find($id);
   // $place=Place::all();
    $category=Category::all();
    $city=City::all();
    $district=District::all();
    return view('admin.place.edit',['place'=>$place,'category'=>$category,'district'=>$district,'city'=>$city]);
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
    $place->category_id = $request->get('category_id');
    $place->districts_id = $request->get('districts_id');
    
    $place->save();

    return \Redirect::route('admin.place.edit', [$place->id])->with('message', 'Place has been updated!');
    
}
}
