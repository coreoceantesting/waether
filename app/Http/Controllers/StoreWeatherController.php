<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Weather;
use File;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StoreWeatherController extends Controller
{
    public function storeWeatherData(){
        // read file
        $fh = fopen(Storage::disk('public')->path('data.txt'),"r");
        $count = 1;   //variable for line no.
        $data = [];

        while ($line = fgets($fh))
        {
            $explodes = explode("  ",$line);

            $data[] = $explodes;

        }
        $line = count($data);

        Weather::create([
            'date' => Carbon::createFromFormat( 'd-m-y', str_replace(" ", "", $data[$line-1][0]) )->toDateString(),
            'time' => $data[$line-1][1],
            'temp_out' => $data[$line-1][2],
            'hi_temp' => $data[$line-1][3],
            'low_temp' => $data[$line-1][4],
            'out_hum' => $data[$line-1][6],
            'dew_pt' => $data[$line-1][7],
            'wind_speed' => $data[$line-1][8],
            'wind_dir' => $data[$line-1][9],
            'wind_run' => $data[$line-1][10],
            'hi_speed' => $data[$line-1][11],
            'hi_dir' => $data[$line-1][12],
            'wind_chill' => $data[$line-1][13],
            'heat_index' => $data[$line-1][14],
            'thw_index' => $data[$line-1][15],
            'bar' => $data[$line-1][16],
            'rain' => $data[$line-1][17],
            'rain_rate' => $data[$line-1][18],
            'heat_dd' => $data[$line-1][19],
            'cool_dd' => $data[$line-1][20],
            'in_temp' => $data[$line-1][21],
            'in_hum' => $data[$line-1][23],
            'in_dew' => $data[$line-1][24],
            'in_heat' => $data[$line-1][25],
            'in_emc' => $data[$line-1][26],
            'in_air_destiny' => $data[$line-1][27],
            'wind_samp' => $data[$line-1][29],
            'wind_txt' => $data[$line-1][31],
            'iss_recept' => $data[$line-1][33],
            'arc_int' => $data[$line-1][34]
        ]);



    }
}
