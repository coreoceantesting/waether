<?php

namespace App\Imports;

use App\Models\AirQualityIndex;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAirQuality implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['so2'] != "" && $row['nox'] != "" && $row['pm2'] != "" && $row['rspm'] != "" && $row['co'] != "" && $row['o3'] != "" && $row['nh3'] != "")
        {
            return new AirQualityIndex([
                'pollution_location_id' => Request()->location_id,
                'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d'),
                'so2' => $row['so2'],
                'nox' => $row['nox'],
                'pm2' => $row['pm2'],
                'rspm' => $row['rspm'],
                'co' => $row['co'],
                'o3' => $row['o3'],
                'nh3' => $row['nh3'],
            ]);
        }
    }
}
