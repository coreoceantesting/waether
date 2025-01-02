<?php

namespace App\Imports;

use App\Models\AirQualityIndex;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportAirQuality implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        DB::beginTransaction();

        try {
            $date = $row['date'];

            if (is_numeric($date)) {
                // Convert Excel serialized date to a Carbon instance
                $carbonDate = Carbon::instance(Date::excelToDateTimeObject($date));
                $formattedDate = $carbonDate->format('Y-m-d'); // Convert to desired format
            } else {
                // Assume the date is already a proper string format
                $formattedDate = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
            }
            Log::info($formattedDate);
            // $dataFormat = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
            DB::commit();
            return new AirQualityIndex([
                'pollution_location_id' => Request()->location_id,
                'date' => $formattedDate,
                'so2' => $row['so2'] ?? 0,
                'nox' => $row['nox'] ?? 0,
                'pm2' => $row['pm2'] ?? 0,
                'pm10' => $row['pm10'] ?? 0,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
        }
    }
}
