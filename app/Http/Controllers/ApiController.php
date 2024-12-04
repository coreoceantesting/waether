<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        // DB::beginTransaction();
        try {
            $datas = $request->all();

            foreach ($datas['data'] as $data) {

                $check = Weather::where('datetime', date('Y-m-d H:i:s', strtotime($data['datetime'])))
                    ->where('location_id', $data['location_id'])
                    ->doesntExist();

                if ($check) {
                    Weather::create([
                        'location_id' => $data['location_id'],
                        'date' => $data['date'],
                        'time' => $data['time'],
                        'temp_out' => $data['temp_out'],
                        'hi_temp' => $data['hi_temp'],
                        'low_temp' => $data['low_temp'],
                        'out_hum' => $data['out_hum'],
                        'dew_pt' => $data['dew_pt'],
                        'wind_speed' => $data['wind_speed'],
                        'wind_dir' => $data['wind_dir'],
                        'wind_run' => $data['wind_run'],
                        'hi_speed' => $data['hi_speed'],
                        'hi_dir' => $data['hi_dir'],
                        'wind_chill' => $data['wind_chill'],
                        'heat_index' => $data['heat_index'],
                        'thw_index' => $data['thw_index'],
                        'bar' => $data['bar'],
                        'rain' => $data['rain'],
                        'rain_rate' => $data['rain_rate'],
                        'heat_dd' => $data['heat_dd'],
                        'cool_dd' => $data['cool_dd'],
                        'in_temp' => $data['in_temp'],
                        'in_hum' => $data['in_hum'],
                        'in_dew' => $data['in_dew'],
                        'in_heat' => $data['in_heat'],
                        'in_emc' => $data['in_emc'],
                        'in_air_destiny' => $data['in_air_destiny'],
                        'wind_samp' => $data['wind_samp'],
                        'wind_txt' => $data['wind_txt'],
                        'iss_recept' => $data['iss_recept'],
                        'arc_int' => $data['arc_int'],
                        'datetime' => $data['datetime'],
                    ]);
                } else {
                    $weather = Weather::where('datetime', $data['date'] . ' ' . $data['time'])
                        ->where('location_id', $data['location_id'])
                        ->first();
                    if ($weather) {
                        Weather::where('id', $weather->id)->where('location_id', $data['location_id'])
                            ->update([
                                'date' => $data['date'],
                                'time' => $data['time'],
                                'datetime' => $data['datetime']
                            ]);
                    }
                }
            }
            // DB::commit();
            return response()->json([
                'status' => 200,
                'success' => 'Data inserted proper'
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            // DB::rollback();
            return response()->json([
                'status' => 503,
                'error' => 'Something went wrong'
            ]);
        }
    }
}
