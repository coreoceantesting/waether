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
        // Log::info($request);
        DB::beginTransaction();
        try {
            $datas = $request->all();

            foreach ($datas['data'] as $data) {

                $check = Weather::where('datetime', $data['date'] . ' ' . $data['time'])
                    ->where('location_id', $data['location_id'])
                    ->first();

                if ($check) {
                    Weather::create($data);
                } else {
                    Weather::where('id', $check->id)->where('location_id', $data['location_id'])
                        ->update([
                            'date' => $data['date'],
                            'time' => $data['time'],
                            'datetime' => $data['datetime']
                        ]);
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
