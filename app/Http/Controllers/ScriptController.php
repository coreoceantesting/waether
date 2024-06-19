<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;

class ScriptController extends Controller
{
    public function index(){
        // return "Okay";
        set_time_limit(0);
        // ini_set('memory_limit', '-1');
        // return date('H:i:s', strtotime('+15 minutes', strtotime('00:00:00')));
        $date = date('Y-m-d', strtotime('-60 days'));
       
        $count = 1;
        for($i=1;$i<=100;$i++){
            for($k=1;$k<=95;$k++)
            {
                $val = $k*15;
                for($j=1;$j<=6;$j++){
                    $this->insert($j, $i, $date, date('H:i:s', strtotime("+$val minutes", strtotime('00:00:00'))));
                    echo $count."<br>";
                    $count = $count + 1;
                }
            }
        }
        echo "Success";
    }

    public function insert($location, $day, $date, $time){
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Log::info(date('d-m-Y', strtotime("+$day days", strtotime($date))));
        DB::table('weathers')->insert([
            'location_id' => $location,
            'date' => date('Y-m-d', strtotime("+$day days", strtotime($date))),
            'time' => $time,
            'datetime' => date('Y-m-d', strtotime("+$day days", strtotime($date))).' '.$time,
            'temp_out' => rand(25, 30),
            'hi_temp' => rand(25, 30),
            'low_temp' => rand(25, 30),
            'out_hum' => rand(70, 85),
            'dew_pt' => rand(20, 30),
            'wind_speed' => rand(20, 30),
            'wind_dir' => $characters[rand(0, strlen($characters)-1)],
            'wind_run' => rand(0,5),
            'hi_speed' => rand(15, 20),
            'hi_dir' => $characters[rand(0, strlen($characters)-1)],
            'wind_chill' => rand(25, 30),
            'heat_index' => rand(25, 35),
            'thw_index' => rand(25, 35),
            'bar' => rand(950, 1400),
            'rain' => rand(0, 10),
            'rain_rate' => rand(20, 30),
            'heat_dd' => rand(0, 5),
            'cool_dd' => rand(0, 5),
            'in_temp' => rand(25, 35),
            'in_hum' => rand(70, 75),
            'in_dew' => rand(20, 25),
            'in_heat' => rand(27, 34),
            'in_emc' => rand(10, 15),
            'in_air_destiny' => rand(0, 5),
            'wind_samp' => rand(350, 550),
            'wind_txt' => rand(0, 4),
            'iss_recept' => rand(96, 130),
            'arc_int' => rand(100, 105),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
