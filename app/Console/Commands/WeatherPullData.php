<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Weather;
use File;
use DB;
use Carbon\Carbon;
use App\Models\Location;
use Log;

class WeatherPullData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:pull-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To get the weather data in every 15 min';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $locations = Location::where('status', 1)->select('path', 'id')->get();

        foreach($locations as $location)
        {
            // read file
            $fh = fopen(unserialize($location->path),"r");
            $data = [];

            while ($line = fgets($fh))
            {
                $data[] = preg_split('/\s+/', trim($line));

            }
            $line = count($data);
            
            $date = Carbon::createFromFormat( 'd-m-y', str_replace(" ", "", $data[$line-1][0]) )->toDateString();
            $times = date('h:i:s', strtotime(str_replace(" ", "", $data[$line-1][1])));
            
            $check = Weather::where('datetime', $date.' '.$times)
                   ->where('location_id', $location->id)
                   ->doesntExist();

            if($check){
                Weather::create([
                    'location_id' => $location->id,
                    'date' => $date,
                    'time' => $times,
                    'datetime' => $date.' '.$times,
                    'temp_out' => $data[$line-1][2],
                    'hi_temp' => $data[$line-1][3],
                    'low_temp' => $data[$line-1][4],
                    'out_hum' => $data[$line-1][5],
                    'dew_pt' => $data[$line-1][6],
                    'wind_speed' => $data[$line-1][7],
                    'wind_dir' => $data[$line-1][8],
                    'wind_run' => $data[$line-1][9],
                    'hi_speed' => $data[$line-1][10],
                    'hi_dir' => $data[$line-1][11],
                    'wind_chill' => $data[$line-1][12],
                    'heat_index' => $data[$line-1][13],
                    'thw_index' => $data[$line-1][14],
                    'bar' => $data[$line-1][15],
                    'rain' => $data[$line-1][16],
                    'rain_rate' => $data[$line-1][17],
                    'heat_dd' => $data[$line-1][18],
                    'cool_dd' => $data[$line-1][19],
                    'in_temp' => $data[$line-1][20],
                    'in_hum' => $data[$line-1][21],
                    'in_dew' => $data[$line-1][22],
                    'in_heat' => $data[$line-1][23],
                    'in_emc' => $data[$line-1][24],
                    'in_air_destiny' => $data[$line-1][25],
                    'wind_samp' => $data[$line-1][26],
                    'wind_txt' => $data[$line-1][27],
                    'iss_recept' => $data[$line-1][28],
                    'arc_int' => $data[$line-1][29]
                ]);
            }

            
        }
    }
}
