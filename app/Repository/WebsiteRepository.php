<?php

namespace App\Repository;

use App\Models\PollutionLocation;
use App\Models\AirQualityIndex;

class WebsiteRepository
{
	public function getPollutionAQI()
	{
		$locations = PollutionLocation::where('status', 1)->get();

		$data = [];

		foreach ($locations as $location) {
			$aqis = AirQualityIndex::where('pollution_location_id', $location->id)
				->select('date', 'so2', 'nox', 'pm2', 'pm10')
				->latest()
				->take(5)
				->get();

			// $aqis->append('air_quality');

			$aqiDataArr = [];
			foreach ($aqis as $aqi) {
				$aqiArr = [];
				$aqiArr = [$this->getSo2AirQualityIndexAttr($aqi->so2), $this->getNoxAirQualityIndexAttr($aqi->nox), $this->getPm2AirQualityIndexAttr($aqi->pm2)/*, $this->getPm10AirQualityIndexAttr($aqi->pm10)*/, $this->getNh3AirQualityIndexAttr($aqi->nh3)];


				$aqiDataArr[] = [
					'date' => $aqi->date,
					'so2' => $aqi->so2,
					'nox' => $aqi->nox,
					'pm2' => $aqi->pm2,
					'pm10' => $aqi->pm10,
					'aqi' => max($aqiArr)
				];
			}

			$data[] = [
				'id' => $location->id,
				'name' => $location->name,
				'aqi' => $aqiDataArr
			];
		}

		return $data;
	}

	public function pollutionUpdateChart($req)
	{
		$pollutantLocations = AirQualityIndex::where('pollution_location_id', $req->airMonitoring)
			->where('date', '>=', date('Y-m-d', strtotime($req->start_date)))
			->where('date', '<=', date('Y-m-d', strtotime($req->end_date)))
			->select('date',  "$req->selectPollutant as data")
			->orderBy('date', 'asc')
			->get();

		$data = [];
		foreach ($pollutantLocations as $pollutantLocation) {
			$aqi = 0;
			if ($req->selectPollutant == "so2") {
				$aqi = $this->getSo2AirQualityIndexAttr($pollutantLocation->data);
			} elseif ($req->selectPollutant == "nox") {
				$aqi = $this->getNoxAirQualityIndexAttr($pollutantLocation->data);
			} elseif ($req->selectPollutant == "pm2") {
				$aqi = $this->getPm2AirQualityIndexAttr($pollutantLocation->data);
			} elseif ($req->selectPollutant == "pm10") {
				$aqi = $this->getPm10AirQualityIndexAttr($pollutantLocation->data);
			}

			$data[] = [
				'date' => $pollutantLocation->date,
				'aqi' => round($aqi, 2)
			];
		}
		return $data;
	}

	public function pollutionUpdatePieChart($req)
	{
		$pollutantLocations = AirQualityIndex::join('pollution_locations', 'pollution_locations.id', '=', 'air_quality_index.pollution_location_id')
			->where('pollution_locations.status', 1)
			->where('air_quality_index.date', '>=', date('Y-m-d', strtotime($req->start_date)))
			->where('air_quality_index.date', '<=', date('Y-m-d', strtotime($req->end_date)))
			->select('air_quality_index.date', 'air_quality_index.so2', 'air_quality_index.nox', 'air_quality_index.pm2', 'air_quality_index.pm10')
			->get();
		// return 
		$aqiDataArr = [];
		foreach ($pollutantLocations as $pollutantLocation) {
			$aqiArr = [];
			$aqiArr = [$this->getSo2AirQualityIndexAttr($pollutantLocation->so2), $this->getNoxAirQualityIndexAttr($pollutantLocation->nox), $this->getPm2AirQualityIndexAttr($pollutantLocation->pm2), $this->getPm10AirQualityIndexAttr($pollutantLocation->pm10), $this->getCoAirQualityIndexAttr($pollutantLocation->co), $this->getO3AirQualityIndexAttr($pollutantLocation->o3), $this->getNh3AirQualityIndexAttr($pollutantLocation->nh3)];
			$aqiDataArr[date('Y-m', strtotime($pollutantLocation->date))][$pollutantLocation->date] = [
				'date' => $pollutantLocation->date,
				'aqi' => max($aqiArr)
			];
		}
		$data = [];

		foreach ($aqiDataArr as $key => $aqiData) {
			$count = 0;
			$sum = 0;
			foreach ($aqiData as $aqi) {
				$count = $count + 1;
				$sum = $sum + $aqi['aqi'];
			}
			$data[$key] = [
				'date' => $key,
				'aqi' => ($count > 0) ? round($sum / $count, 2) : 0
			];
		}

		return $data;
	}

	// to get the pm10 aqi
	public function getPm10AirQualityIndexAttr($val)
	{
		$aqi = 0;
		if ($val <= 100) {
			$aqi = $val;
		} elseif ($val > 100 && $val <= 250) {
			$aqi = 100 + ($val - 100) * 100 / 150;
		} elseif ($val > 250 && $val <= 350) {
			$aqi = 200 + ($val - 250);
		} elseif ($val > 350 && $val <= 430) {
			$aqi = 300 + ($val - 350) * (100 / 80);
		} elseif ($val > 430) {
			$aqi = 400 + ($val - 430) * (100 / 80);
		}

		return $aqi;
	}

	// to get pm2.5 aqi
	public function getPm2AirQualityIndexAttr($val)
	{
		$aqi = 0;
		if ($val <= 30) {
			$aqi = $val * 50 / 30;
		} elseif ($val > 30 && $val <= 60) {
			$aqi = 50 + ($val - 30) * 50 / 30;
		} elseif ($val > 60 && $val <= 90) {
			$aqi = 100 + ($val - 60) * 100 / 30;
		} elseif ($val > 90 && $val <= 120) {
			$aqi = 200 + ($val - 90) * (100 / 30);
		} elseif ($val > 120 && $val <= 250) {
			$aqi = 300 + ($val - 120) * (100 / 130);
		} elseif ($val > 250) {
			$aqi = 400 + ($val - 250) * (100 / 130);
		}

		return $aqi;
	}

	// to grt the so2 aqi
	public function getSo2AirQualityIndexAttr($val)
	{
		$aqi = 0;
		if ($val <= 40) {
			$aqi = $val * 50 / 40;
		} elseif ($val > 40 && $val <= 80) {
			$aqi = 50 + ($val - 40) * 50 / 40;
		} elseif ($val > 80 && $val <= 380) {
			$aqi = 100 + ($val - 80) * 100 / 300;
		} elseif ($val > 380 && $val <= 800) {
			$aqi = 200 + ($val - 380) * (100 / 420);
		} elseif ($val > 800 && $val <= 1600) {
			$aqi = 300 + ($val - 800) * (100 / 800);
		} elseif ($val > 1600) {
			$aqi = 400 + ($val - 1600) * (100 / 800);
		}

		return $aqi;
	}

	// to get nox aqi
	public function getNoxAirQualityIndexAttr($val)
	{
		$aqi = 0;
		if ($val <= 40) {
			$aqi = $val * 50 / 40;
		} elseif ($val > 40 && $val <= 80) {
			$aqi = 50 + ($val - 40) * 50 / 40;
		} elseif ($val > 80 && $val <= 180) {
			$aqi = 100 + ($val - 80) * 100 / 100;
		} elseif ($val > 180 && $val <= 280) {
			$aqi = 200 + ($val - 180) * (100 / 100);
		} elseif ($val > 280 && $val <= 400) {
			$aqi = 300 + ($val - 280) * (100 / 120);
		} elseif ($val > 400) {
			$aqi = 400 + ($val - 400) * (100 / 120);
		}

		return $aqi;
	}


	// to get co aqi
	public function getCoAirQualityIndexAttr($val)
	{
		$aqi = 0;
		if ($val <= 1) {
			$aqi = $val * 50 / 1;
		} elseif ($val > 1 && $val <= 2) {
			$aqi = 50 + ($val - 1) * 50 / 1;
		} elseif ($val > 2 && $val <= 10) {
			$aqi = 100 + ($val - 2) * 100 / 8;
		} elseif ($val > 10 && $val <= 17) {
			$aqi = 200 + ($val - 10) * (100 / 7);
		} elseif ($val > 17 && $val <= 34) {
			$aqi = 300 + ($val - 17) * (100 / 17);
		} elseif ($val > 34) {
			$aqi = 400 + ($val - 34) * (100 / 17);
		}

		return $aqi;
	}

	// to get o3 aqi
	public function getO3AirQualityIndexAttr($val)
	{
		$aqi = 0;
		if ($val <= 50) {
			$aqi = $val * 50 / 50;
		} elseif ($val > 50 && $val <= 100) {
			$aqi = 50 + ($val - 50) * 50 / 50;
		} elseif ($val > 100 && $val <= 168) {
			$aqi = 100 + ($val - 100) * 100 / 68;
		} elseif ($val > 168 && $val <= 208) {
			$aqi = 200 + ($val - 168) * (100 / 40);
		} elseif ($val > 208 && $val <= 748) {
			$aqi = 300 + ($val - 208) * (100 / 539);
		} elseif ($val > 748) {
			$aqi = 400 + ($val - 400) * (100 / 539);
		}

		return $aqi;
	}

	// to get nh3 aqi
	public function getNh3AirQualityIndexAttr($val)
	{
		$aqi = 0;
		if ($val <= 200) {
			$aqi = $val * 50 / 200;
		} elseif ($val > 200 && $val <= 400) {
			$aqi = 50 + ($val - 200) * 50 / 200;
		} elseif ($val > 400 && $val <= 800) {
			$aqi = 100 + ($val - 400) * 100 / 400;
		} elseif ($val > 800 && $val <= 1200) {
			$aqi = 200 + ($val - 800) * (100 / 400);
		} elseif ($val > 1200 && $val <= 1800) {
			$aqi = 300 + ($val - 1200) * (100 / 600);
		} elseif ($val > 1800) {
			$aqi = 400 + ($val - 1800) * (100 / 600);
		}

		return $aqi;
	}
}
