<?php

namespace App\Http\Controllers\place;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Place;
use App\Category;
use App\City;
use App\District;
use DB;
use Config;
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
            [   'name'=>'required',
                'address'=>'required',
                'category_id'=>'required',
                'city_id'=>'required',
                'districts_id'=>'required'
            ],
            [
                'name.required'=>'bạn chưa nhập tên địa điểm',
                'address.required'=>'bạn chưa nhập địa chỉ',
                'category_id.required'=>'bạn chưa chọn loại địa điểm  ',
                'city_id.required'=>'bạn chưa chọn tỉnh, thành phố ',
                'districts_id.required'=>'bạn chưa chọn quận huyện'
            ]
        );
        $place = new Place;
        $place->name=$request->name;
        $place->address=$request->address;
        $place->category_id=$request->category_id;
        $place->districts_id=$request->districts_id;  
        $place->lat=$request->lat;
        $place->longt=$request->lng;     
        $place->save();
        $place=Place::all();
        $category=Category::all();
        $city=City::all();
        $district=District::all();
        return \Redirect::route('admin.place.index',['place'=>$place,'category'=>$category,'district'=>$district,'city'=>$city])->with('message', Config::get('constant.place.addPlace'));
    }

    public function xoa($id)
    {
        $place = Place::find($id);
        $place->delete();
        
        return redirect()->back()->with('success', Config::get('constant.place.deletePlace'));
        
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

        $place->name = $request->get('name');
        $place->address = $request->get('address');
        $place->category_id = $request->get('category_id');
        $place->districts_id = $request->get('districts_id');
        $place->lat=$request->get('lat');
        $place->longt=$request->get('lng');
        $place->save();

        return \Redirect::route('admin.place.edit', [$place->id,'place'=>$place])->with('message',  Config::get('constant.place.editPlace'));
        
    }
    public function getdetail ($id)
    {
     $place=Place::find($id);
     
     $category=Category::all();
     $city=City::all();
     $district=District::all();
     return view('admin.place.detail',['place'=>$place,'category'=>$category,'district'=>$district,'city'=>$city]);
    }
}
