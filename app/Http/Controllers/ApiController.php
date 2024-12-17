<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;
use App\Models\ApiWeatherData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $datas = $request->all();
            ApiWeatherData::create($datas);

            foreach ($datas['data'] as $data) {

                $datetime = \Carbon\Carbon::parse($data['datetime'])->format('Y-m-d H:i:s');
                $weather = Weather::where('datetime', $datetime)
                    ->where('location_id', $data['location_id'])
                    ->doesntExist();

                if ($weather) {
                    // Weather::where('id', $weather->id)->where('location_id', $data['location_id'])
                    //     ->update([
                    //         'date' => $data['date'],
                    //         'time' => $data['time'],
                    //         'datetime' => $data['datetime']
                    //     ]);
                    Weather::create($data);
                }
            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'success' => 'Data inserted proper'
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return response()->json([
                'status' => 503,
                'error' => 'Something went wrong'
            ]);
        }
    }
}
