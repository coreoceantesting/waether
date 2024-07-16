<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Weather;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Models\PollutionLocation;
use App\Models\AirQualityIndex;
use App\Repository\WebsiteRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use Log;
use App\Exports\WeatherFilterDataExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class WebsiteController extends Controller
{
    protected $websiteRepository;

    public function __construct(WebsiteRepository $websiteRepository)
    {
        parent::__construct();
        $this->websiteRepository = $websiteRepository;
    }

    public function filter(Request $req)
    {
        $locations = Location::where('status', 1)->select('id', 'name')->get();

        return view('website.filter')->with(['locations' => $locations]);
    }

    public function getFilter(Request $req)
    {
        if ($req->ajax()) {
            $weathers = Weather::join('locations', 'weathers.location_id', '=', 'locations.id')
                ->select('locations.name as name', 'weathers.date', 'weathers.time', 'weathers.rain', 'weathers.wind_speed', 'weathers.in_temp', 'weathers.in_hum', 'weathers.datetime', 'weathers.location_id', 'weathers.hi_temp', 'weathers.low_temp')
                ->where('locations.status', 1)
                ->orderBy('weathers.datetime', 'desc');

            if ($req->location != "") {
                $weathers = $weathers->where('weathers.location_id', $req->location);
            }

            if ($req->start_date != "") {
                $weathers = $weathers->where('weathers.datetime', '>=', date('Y-m-d h:i:s', strtotime($req->start_date)));
            }

            if ($req->end_date != "") {
                $weathers = $weathers->where('weathers.datetime', '<=', date('Y-m-d h:i:s', strtotime($req->end_date)));
            }

            return DataTables::of($weathers)
                ->addIndexColumn()
                ->editColumn('prograsive_rain', function ($data) {
                    return round(DB::table('weathers')->where('datetime', '>=', $data->date . ' 08:30:00')->where('datetime', '<=', strtotime('+1 days', strtotime($data->date . ' 08:15:00')))->where('location_id', $data->location_id)
                        ->where('hi_temp', '>', 0)->avg('rain'), 2);
                })
                ->editColumn('lastday', function ($query) {
                    $data = DB::table('weathers')
                        ->where('datetime', '<=', date('Y-m-d H:i:s', strtotime($query->datetime)))
                        ->where('datetime', '>', date('Y-m-d H:i:s', strtotime('-1 days', strtotime($query->datetime))))
                        ->where('location_id', $query->location_id)
                        ->where('hi_temp', '>', 0)
                        ->avg('rain');

                    return ($data) ? round($data, 2) : 0;
                })
                ->editColumn('date', function ($data) {
                    return date('d-m-Y', strtotime($data->date));
                })
                ->editColumn('time', function ($data) {
                    return date('h:i A', strtotime($data->time));
                })
                ->toJson();
        }
    }


    public function filterWeatherInfo(Request $req)
    {
        // to get the total rain
        $totalRain = Weather::whereYear('date', date('Y'))->where('datetime', '<=', date('Y-m-d H:i:s', strtotime($req->start_date . ' 08:15:00')))->sum('rain');

        // to get the weathers data by date
        $weathers = Weather::join('locations', 'locations.id', '=', 'weathers.location_id')
            ->where('locations.status', 1)
            ->select('weathers.id', 'weathers.location_id', 'weathers.datetime', 'weathers.rain')
            ->orderBy('weathers.datetime', 'desc');
        if (isset($req->start_date) && $req->start_date != "") {
            $weathers = $weathers->where('weathers.datetime', '>=', date('Y-m-d H:i:s', strtotime($req->start_date . ' 08:30:00')))
                ->where('weathers.datetime', '<=', date('Y-m-d H:i:s', strtotime('+1 days', strtotime($req->start_date . ' 08:15:00'))));
        }
        $weathers = $weathers->get();

        $weatherLocations = $weathers->groupBy('datetime');
        // to get the last day of avg of rain
        $lastDay = Weather::where('datetime', '>=', date('Y-m-d H:i:s', strtotime('-1 days', strtotime($req->start_date . ' 08:30:00'))))
            ->where('datetime', '<', date('Y-m-d H:i:s', strtotime($req->start_date . ' 08:15:00')))
            ->avg('rain');

        // to get active devices
        $locations = Location::where('status', 1)->select('name', 'id')->get();

        return view('website.filter-weather-info')->with(['locations' => $locations, 'weathers' => $weathers, 'totalRain' => $totalRain, 'lastDay' => $lastDay, 'weatherLocations' => $weatherLocations]);
    }



    public function contact(Request $req)
    {
        return view('website.contact');
    }

    public function saveContact(Request $req)
    {
        $contact = new Contact;
        $contact->name = $req->name;
        $contact->email = $req->email;
        $contact->mobile = $req->mobile;
        $contact->message = $req->message;
        if ($contact->save()) {
            session()->flash('success', "Thank you for contact. We will inform you weather related news in your mail.");
            return back();
        }
    }

    public function pollutionUpdate(Request $req)
    {
        $locations = PollutionLocation::where('status', 1)->select('id', 'name')->get();

        $climateMonitorings = $this->websiteRepository->getPollutionAQI();

        return view('website.pollution_update')->with(['climateMonitorings' => $climateMonitorings, 'locations' => $locations]);
    }

    public function pollutionAirQuality(Request $req)
    {
        if ($req->ajax()) {
            $airQuality = AirQualityIndex::select('date', 'so2', 'nox', 'rspm', 'pm2', 'co', 'o3', 'nh3');

            if ($req->location != "") {
                $airQuality = $airQuality->where('pollution_location_id', $req->location);
            }

            if ($req->start_date != "") {
                $airQuality = $airQuality->where('date', '>=', date('Y-m-d', strtotime($req->start_date)));
            }

            if ($req->end_date != "") {
                $airQuality = $airQuality->where('date', '<=', date('Y-m-d', strtotime($req->end_date)));
            }

            return DataTables::of($airQuality)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return date('d-m-Y', strtotime($data->date));
                })->editColumn('aqi', function ($data) {
                    return round(max([$this->websiteRepository->getSo2AirQualityIndexAttr($data->so2), $this->websiteRepository->getNoxAirQualityIndexAttr($data->nox), $this->websiteRepository->getRspmAirQualityIndexAttr($data->rspm), $this->websiteRepository->getPm2AirQualityIndexAttr($data->pm2), $this->websiteRepository->getCoAirQualityIndexAttr($data->co), $this->websiteRepository->getO3AirQualityIndexAttr($data->o3), $this->websiteRepository->getNh3AirQualityIndexAttr($data->nh3)]), 2);
                })
                ->toJson();
        }
        $locations = PollutionLocation::select('id', 'name')->where('status', 1)->get();

        return view('website.pollution_air_quality')->with(['locations' => $locations]);
    }

    public function climatemonitring(Request $req)
    {
        return view('website.climatemonitoring');
    }

    public function pollutionUpdateChart(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->websiteRepository->pollutionUpdateChart($req);

            return response()->json([
                'data' => $data
            ]);
        }
    }

    public function pollutionUpdatePieChart(Request $req)
    {
        if ($req->ajax()) {
            $pollutionAqi = $this->websiteRepository->pollutionUpdatePieChart($req);
            $graphData = [];
            foreach ($pollutionAqi as $data) {
                if ($data['aqi'] <= 50) {
                    $totalAqiValue = (isset($graphData['Good'])) ? $graphData['Good'][1] + $data['aqi'] : $data['aqi'];;
                    $graphData['Good'] = ['Good', $totalAqiValue];
                }

                if ($data['aqi'] >= 51 && $data['aqi'] <= 100) {
                    $totalAqiValue = (isset($graphData['Satisfactory'])) ? $graphData['Satisfactory'][1] + $data['aqi'] : $data['aqi'];
                    $graphData['Satisfactory'] = ['Satisfactory', $totalAqiValue];
                }

                if ($data['aqi'] >= 101 && $data['aqi'] <= 200) {
                    $totalAqiValue = (isset($graphData['Moderate'])) ? $graphData['Moderate'][1] + $data['aqi'] : $data['aqi'];
                    $graphData['Moderate'] = ['Moderate', $totalAqiValue];
                }

                if ($data['aqi'] >= 201 && $data['aqi'] <= 300) {
                    $totalAqiValue = (isset($graphData['Poor'])) ? $graphData['Poor'][1] + $data['aqi'] : $data['aqi'];
                    $graphData['Poor'] = ['Poor', $totalAqiValue];
                }

                if ($data['aqi'] >= 301 && $data['aqi'] <= 400) {
                    $totalAqiValue = (isset($graphData['Very Poor'])) ? $graphData['Very Poor'][1] + $data['aqi'] : $data['aqi'];
                    $graphData['Very Poor'] = ['Very Poor', $totalAqiValue];
                }

                if ($data['aqi'] > 400) {
                    $totalAqiValue = (isset($graphData['Severe'])) ? $graphData['Severe'][1] + $data['aqi'] : $data['aqi'];
                    $graphData['Severe'] = ['Severe', $totalAqiValue];
                }
            }
            $tempData[0] = ['Remark', 'Value'];
            $i = 1;
            $color = [];
            foreach ($graphData as $data) {
                // to get chart color
                if ($data[0] == "Good") {
                    $color[] = "#0EB409";
                } elseif ($data[0] == "Satisfactory") {
                    $color[] = "#6AD067";
                } elseif ($data[0] == "Moderate") {
                    $color[] = "#ffff00";
                } elseif ($data[0] == "Poor") {
                    $color[] = "#EF8B06";
                } elseif ($data[0] == "Very Poor") {
                    $color[] = "#F41212";
                } elseif ($data[0] == "Severe") {
                    $color[] = "#B60E0E";
                }
                $tempData[$i++] = [$data[0], $data[1]];
            }

            // Code For Aqi Month Wise
            $aqiMonth = [];
            foreach ($pollutionAqi as $data) {
                $aqiMonth[] = [
                    'year' => date('Y', strtotime($data['date'])),
                    'month' => date('F', strtotime($data['date'])),
                    'aqi' => $data['aqi']
                ];
            }
            return response()->json([
                'data' => $tempData,
                'aqimonth' => $aqiMonth,
                'color' => $color,
            ]);
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new WeatherFilterDataExport($request), 'weather.xlsx');
    }

    public function generatePdf(Request $request)
    {
        $weathers = Weather::join('locations', 'weathers.location_id', '=', 'locations.id')
            ->select('locations.name as name', 'weathers.date', 'weathers.time', 'weathers.rain', 'weathers.wind_speed', 'weathers.in_temp', 'weathers.in_hum', 'weathers.datetime', 'weathers.location_id', 'weathers.hi_temp', 'weathers.low_temp')
            ->where('locations.status', 1)
            ->orderBy('weathers.id', 'desc');

        if ($request->location != "") {
            $weathers = $weathers->where('weathers.location_id', $request->location);
        }

        if ($request->start_date != "") {
            $weathers = $weathers->where('weathers.datetime', '>=', date('Y-m-d h:i:s', strtotime($request->start_date)));
        }

        if ($request->end_date != "") {
            $weathers = $weathers->where('weathers.datetime', '<=', date('Y-m-d h:i:s', strtotime($request->end_date)));
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

        $weathers = $data;
        $pdf = PDF::loadView('filter.export', compact('weathers'))->setPaper('a4', 'landscape');;
        // download PDF file with download method
        return $pdf->stream();
    }
}
