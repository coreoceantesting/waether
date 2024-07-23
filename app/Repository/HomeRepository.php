<?php

namespace App\Repository;

use App\Models\Location;
use App\Models\Weather;
use App\Models\YearlyData;
use App\Models\Setting;

class HomeRepository
{
	public function getRainyWeathersLocationWeatherDetails($date)
	{
		$locations = Location::with(['weathers' => function ($query) use ($date) {
			if (date('H:i:s') >= '00:00:00' && date('H:i:s') <= '08:15:00') {
				$query->where('datetime', '<', date('Y-m-d H:i:s'))
					->where('datetime', '>=', date('Y-m-d H:i:s', strtotime('-1 days', strtotime(date('Y-m-d') . ' 08:30:00'))))
					->where('hi_temp', '>', 0);
			} else {
				$query->where('datetime', '<=', date('Y-m-d H:i:s'))
					->where('datetime', '>=', date('Y-m-d H:i:s', strtotime($date)))
					->where('hi_temp', '>', 0);
			}
		}])
			->where('status', 1)
			->get();

		return $locations;
	}

	public function getSunnyLocationWeatherDetails($date)
	{
		$locations = Location::with(['weathers' => function ($query) use ($date) {
			$query->where('datetime', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d') . " 00:00:00")))->where('datetime', '<=', date('Y-m-d H:i:s'))
				->where('hi_temp', '>', 0);
		}])
			->where('status', 1)
			->get();

		return $locations;
	}

	public function getTotalRain($search)
	{
		$totalRain = Weather::whereYear('date', date('Y'))->where('datetime', '<=', date('Y-m-d H:i:s', strtotime($search)))->sum('rain');

		return $totalRain;
	}

	public function getLastDayRain($search)
	{
		$locations = Location::where('status', 1)->get();
		$totalAvg = 0;
		foreach ($locations as $location) {
			if (date('H:i' < '08:30')) {
				$startDate = date('Y-m-d H:i:s', strtotime('-2 days 08:30:00'));
				$enddateDate = date('Y-m-d H:i:s', strtotime('-1 days 08:25:00'));
			} else {
				$startDate = date('Y-m-d H:i:s', strtotime('-1 days 08:30:00'));
				$enddateDate = date('Y-m-d H:i:s', strtotime('08:25:00'));
			}

			$lastdayLocationAvg = Weather::where('datetime', '<', $enddateDate)
				->where('location_id', $location->id)
				->where('datetime', '>=', $startDate)
				->avg('rain');

			$totalAvg += $lastdayLocationAvg;
		}

		if ($totalAvg == 0) {
			return 0;
		} else {
			return $totalAvg / count($locations);
		}
	}

	public function getCurrentRain($search)
	{
		$currentRain = Weather::where('datetime', '>', date('Y-m-d H:i:s', strtotime('-15 min')))->where('datetime', '<=', date('Y-m-d H:i:s'))->avg('rain');

		return $currentRain;
	}

	public function getPrograssiveRain($search)
	{
		return Weather::where('datetime', '>=', date('Y-m-d H:i:s', strtotime($search)))->where('datetime', '<=', date('Y-m-d H:i:s'))->avg('rain');
	}

	public function getHourlyData()
	{
		return Weather::whereDate('date', date('Y-m-d'))->where('hi_temp', '>', 0)->orderBy('id', 'desc')->get();
	}

	public function getHighTide()
	{
		return YearlyData::where('date', date('Y-m-d'))->first();
	}

	public function getSetting()
	{
		$month = date('m');
		return Setting::where('from', '<=', $month)
			->where('to', '>=', $month)
			->select('config_name', 'icon', 'background_image')
			->first();
	}

	public function getLastDaySunnyTemp()
	{
		$locations = Location::with(['weathers' => function ($query) {
			$query->where('datetime', '>=', date('Y-m-d H:i:s', strtotime('-1 days')))
				->where('hi_temp', '>', 0);
		}])
			->get();

		return $locations;
	}

	public function getBannerImage()
	{
		return Setting::where('config_name', 'dashboard_banner')
			->value('background_image');
	}

	public function getMonthlyHightide()
	{
		$data = YearlyData::where('height', '>', 4)
			->select('date', 'time', 'height')
			->get();

		$data->append('year_month');

		return $data->groupBy('year_month');
	}

	public function getMaxTempOut()
	{
		return Weather::where('temp_out', '>', 0)->max('temp_out');
	}

	public function getMinTempOut()
	{
		return Weather::where('temp_out', '>', 0)->min('temp_out');
	}

	public function getMaxHeatIndex()
	{
		return Weather::where('temp_out', '>', 0)->max('heat_index');
	}

	public function getMinHeatIndex()
	{
		return Weather::where('temp_out', '>', 0)->min('heat_index');
	}
}
