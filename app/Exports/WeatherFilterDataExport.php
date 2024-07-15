<?php

namespace App\Exports;

use App\Models\Weather;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WeatherFilterDataExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $weathers = Weather::join('locations', 'weathers.location_id', '=', 'locations.id')
            ->select('locations.name as name', 'weathers.date', 'weathers.time', 'weathers.rain', 'weathers.wind_speed', 'weathers.in_temp', 'weathers.in_hum', 'weathers.datetime', 'weathers.location_id', 'weathers.hi_temp', 'weathers.low_temp')
            ->where('locations.status', 1)
            ->orderBy('weathers.id', 'desc');

        if ($this->data->location != "") {
            $weathers = $weathers->where('weathers.location_id', $this->data->location);
        }

        if ($this->data->start_date != "") {
            $weathers = $weathers->where('weathers.datetime', '>=', date('Y-m-d h:i:s', strtotime($this->data->start_date)));
        }

        if ($this->data->end_date != "") {
            $weathers = $weathers->where('weathers.datetime', '<=', date('Y-m-d h:i:s', strtotime($this->data->end_date)));
        }

        $weathers = $weathers->get();

        $data = [];

        foreach ($weathers as $weather) {
            $data[] = [
                'location' => $weather->name,
                'date' => $weather->date,
                'time' => $weather->time,
                'rain' => $weather->rain,
                'wind_speed' => $weather->wind_speed,
                'in_temp' => $weather->in_temp,
                'low_temp' => $weather->low_temp,
                'hi_temp' => $weather->hi_temp,
                'in_hum' => $weather->in_hum,
                'prograsive_rain' => round(Weather::where('datetime', '>=', $weather->date . ' 08:30:00')->where('datetime', '<=', strtotime('+1 days', strtotime($weather->date . ' 08:15:00')))->where('location_id', $weather->location_id)
                    ->where('hi_temp', '>', 0)->avg('rain'), 2),
                'lastday' => Weather::where('datetime', '<=', date('Y-m-d H:i:s', strtotime($weather->datetime)))
                    ->where('datetime', '>', date('Y-m-d H:i:s', strtotime('-1 days', strtotime($weather->datetime))))
                    ->where('location_id', $weather->location_id)
                    ->where('hi_temp', '>', 0)
                    ->avg('rain'),
            ];
        }
        return view('filter.export', [
            'weathers' => $data
        ]);
    }
}
