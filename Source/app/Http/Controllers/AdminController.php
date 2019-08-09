<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\SampleChart;
use App\User;
use DB;

class AdminController extends Controller
{
    public function index()
    {


        /*  $year = \Request::get('year');
        $dbname = \Request::get('dbname');
        if ($year === NULL) $year = 2019;
        if ($dbname === NULL) $dbname = 'users';
        //  $users = DB::select("select COUNT(*) as count from users where year(created_at) = ? GROUP BY Month(created_at)", [$year]);
       // $users = DB::select("select COUNT(*) as count from $dbname where year(created_at) = $year GROUP BY Month(created_at)");
        $db_arr = [];
        for ($i = 1; $i <= 12; $i++){
            $user = DB::select("select COUNT(*) as count from $dbname where year(created_at) = $year and Month(created_at)=$i");
            
            $db_arr[$i-1] = $user[0]->count;
           
        }
        //return var_dump($db_arr);
        $a = mt_rand(0, 255);
        $b = mt_rand(0, 255);
        $c = mt_rand(0, 255);
        $chart = new SampleChart;
        $chart->labels(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']);
        $chart->dataset($dbname . ' ' . $year, 'bar', $db_arr)->options(['backgroundColor' => "rgb($a,$b,$c)",]);
        $chart->displayLegend(true);
        return view('admin.index', ['chart' => $chart]);*/
        return view('admin.index');
    }
    public function chart()
    {
        $begin = \Request::get('begin');
        $end = \Request::get('end');
        $dbname = \Request::get('dbname');
        if ($begin == null || $end == null) {
            if ($end == null && $begin == null) return view('admin.index');
            if ($begin == null) {
                $yearend = explode('-', $end)[0];
                $monthend = explode('-', $end)[1];
                $users = DB::select("select COUNT(*) as count from $dbname where Year(created_at)=$yearend AND Month(created_at)=$monthend");
                $arr[] = $monthend . '-' . $yearend;
                $db_arr[] = $users[0]->count;
            } else {
                $yearbegin = explode('-', $begin)[0];
                $monthbegin = explode('-', $begin)[1];
                $users = DB::select("select COUNT(*) as count from $dbname where Year(created_at)=$yearbegin AND Month(created_at)=$monthbegin");
                $arr[] = $monthbegin . '-' . $yearbegin;
                $db_arr[] = $users[0]->count;
            }
        } else {
            $yearend = explode('-', $end)[0];
            $monthend = explode('-', $end)[1];
            $yearbegin = explode('-', $begin)[0];
            $monthbegin = explode('-', $begin)[1];
            if ($yearbegin > $yearend || ($yearbegin == $yearend && $monthbegin > $monthend)) {
                return $this->index();
            } else {


                $users = DB::select("select COUNT(*) as count from $dbname where created_at BETWEEN '$yearbegin-$monthbegin-01' AND '$yearend-$monthend-31' GROUP BY Year(created_at),Month(created_at)");
                $db_arr = [];
                for ($i = 0; $i < count($users); $i++)
                    $db_arr[$i] = $users[$i]->count;

                $arr = [];
                do {
                    array_push($arr, $monthbegin . '-' . $yearbegin);
                    $monthbegin++;
                    if ($monthbegin > 12) {
                        $monthbegin = 1;
                        $yearbegin++;
                    }
                } while ($monthbegin != $monthend || $yearbegin != $yearend);
                array_push($arr, $monthbegin . '-' . $yearbegin);
                // var_dump($arr);


                //return "select COUNT(*) as count from $dbname where created_at BETWEEN '$yearbegin-$monthbegin-01' AND '$yearend-$monthend-31' GROUP BY Year(created_at),Month(created_at)";
            }
        }
        $a = mt_rand(0, 255);
        $b = mt_rand(0, 255);
        $c = mt_rand(0, 255);
        $chart = new SampleChart;
        $chart->labels($arr);
        $chart->dataset($dbname, 'bar', $db_arr)->options(['backgroundColor' => "rgb($a,$b,$c)",]);
        $chart->displayLegend(true);
        return view('admin.index', ['chart' => $chart]);
    }
}
