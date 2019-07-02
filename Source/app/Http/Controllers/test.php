<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
class test extends Controller
{
    public function index(){
 Alert::success('Success Title', 'Success Message');
alert()->success('SuccessAlert','Lorem ipsum dolor sit amet.');
toast('Success Toast','success');

    return view('test');


    }

}
