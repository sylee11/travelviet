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


        $year = \Request::get('year');
        $dbname = \Request::get('dbname');
        if ($year === NULL) $year = 2019;
        if ($dbname === NULL) $dbname = 'users';
        //  $users = DB::select("select COUNT(*) as count from users where year(created_at) = ? GROUP BY Month(created_at)", [$year]);
        $users = DB::select("select COUNT(*) as count from $dbname where year(created_at) = $year GROUP BY Month(created_at)");
        $user_arr = [];
        for ($i = 0; $i < count($users); $i++)
            $user_arr[$i] = $users[$i]->count;
        $a = mt_rand(0, 255);
        $b = mt_rand(0, 255);
        $c = mt_rand(0, 255);
        $chart = new SampleChart;
        $chart->labels(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']);
        $chart->dataset($dbname . ' ' . $year, 'bar', $user_arr)->options(['backgroundColor' => "rgb($a,$b,$c)",]);
        $chart->displayLegend(true);
        return view('admin.index', ['chart' => $chart]);
    }
    public function chart()
    {
        if (\Request::get('begin') !== NULL && \Request::get('end') !== NULL) {
            $begin = \Request::get('begin');
            $end = \Request::get('end');
            $yearbegin = explode('-', $begin)[0];
            $monthbegin = explode('-', $begin)[1];
            $yearend = explode('-', $end)[0];
            $monthend = explode('-', $end)[1];
            if ($yearbegin > $yearend || ($yearbegin == $yearend && $monthbegin >= $monthend)) {
                // return '12312';
                return $this->index();
            }

            $dbname = \Request::get('dbname');
            if ($dbname === NULL) $dbname = 'users';
            $users = DB::select("select COUNT(*) as count from $dbname where created_at BETWEEN '$yearbegin-$monthbegin-01' AND '$yearend-$monthend-31' GROUP BY Year(created_at),Month(created_at)");
            $user_arr = [];
            for ($i = 0; $i < count($users); $i++)
                $user_arr[$i] = $users[$i]->count;
                
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

            $a = mt_rand(0, 255);
            $b = mt_rand(0, 255);
            $c = mt_rand(0, 255);
            $chart = new SampleChart;
            $chart->labels($arr);
            $chart->dataset($dbname, 'bar', $user_arr)->options(['backgroundColor' => "rgb($a,$b,$c)",]);
            $chart->displayLegend(true);
            return view('admin.index', ['chart' => $chart]);
        }
    }
}
