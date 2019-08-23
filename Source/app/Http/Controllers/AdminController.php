<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\SampleChart;
use App\User;
use DB;

class AdminController extends Controller
{
    private $ADMIN_VIEW = 'admin.index';
    public function index()
    {
        return view($this->ADMIN_VIEW);
    }
    public function chart()
    {
        $begin = \Request::get('begin');
        $end = \Request::get('end');
        $dbname = \Request::get('dbname');
        $yearbegin = explode('-', $begin)[0];
        $monthbegin = explode('-', $begin)[1];
        $yearend = explode('-', $end)[0];
        $monthend = explode('-', $end)[1];

        if ($yearbegin > $yearend || ($yearbegin == $yearend && $monthbegin > $monthend)) {
            return $this->index();
        } elseif ($yearbegin == $yearend && $monthbegin == $monthend) {
            $data = DB::select("select COUNT(*) as count from $dbname where Year(created_at)=$yearend AND Month(created_at)=$monthend");
            $arr[] = $monthend . '-' . $yearend;
            $db_arr[] = $data[0]->count;
        } else {


            $data = DB::select("select YEAR(created_at) as year,Month(created_at) as month,COUNT(*) as count from $dbname where created_at BETWEEN '$yearbegin-$monthbegin-01' AND '$yearend-$monthend-31' GROUP BY Year(created_at),Month(created_at)");

            $db_arr = [];

            $i = 0;
            $arr = [];

            while ($monthbegin != $monthend || $yearbegin != $yearend) {
                array_push($arr, $monthbegin . '-' . $yearbegin);
                if ($i < count($data) && $monthbegin == $data[$i]->month && $yearbegin == $data[$i]->year) {
                    $db_arr[] = $data[$i]->count;
                    $i++;
                } else {
                    $db_arr[] = 0;
                }
                $monthbegin++;
                if ($monthbegin > 12) {
                    $monthbegin = 1;
                    $yearbegin++;
                }
            }
            if ($i < count($data) && $monthbegin == $data[$i]->month && $yearbegin == $data[$i]->year) {
                $db_arr[] = $data[$i]->count;
            }
            array_push($arr, $monthbegin . '-' . $yearbegin);
        }

        $a = random_int(0, 255);
        $b = random_int(0, 255);
        $c = random_int(0, 255);
        $chart = new SampleChart;
        $chart->labels($arr);
        $chart->dataset($dbname, 'bar', $db_arr)->options(['backgroundColor' => "rgb($a,$b,$c)",]);
        $chart->displayLegend(true);
        return view($this->ADMIN_VIEW, ['chart' => $chart]);
    }
}
