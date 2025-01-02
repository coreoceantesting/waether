<?php

namespace App\Repository\Admin;

use App\Models\AirQualityIndex;
use App\Models\PollutionLocation;

class PollutionAirQualityRepository
{
	public function list($location)
	{
		return AirQualityIndex::join('pollution_locations', 'pollution_locations.id', '=', 'air_quality_index.pollution_location_id')
			->where('pollution_location_id', $location)
			->select('pollution_locations.name', 'air_quality_index.id', 'air_quality_index.so2', 'air_quality_index.nox', 'air_quality_index.pm2', 'air_quality_index.pm10', 'air_quality_index.date')
			->orderBy('id', 'desc');
	}

	public function store($req)
	{
		$airQualityIndex = new AirQualityIndex;
		$airQualityIndex->pollution_location_id  = $req->location_id;
		$airQualityIndex->date = date('Y-m-d', strtotime($req->date));
		$airQualityIndex->so2 = $req->so2;
		$airQualityIndex->nox = $req->nox;
		$airQualityIndex->pm2 = $req->pm2;
		$airQualityIndex->pm10 = $req->pm10;
		if ($airQualityIndex->save()) {
			return true;
		}
	}

	public function edit($id)
	{
		return AirQualityIndex::find($id);
	}

	public function update($req)
	{
		$airQualityIndex = AirQualityIndex::find($req->id);
		$airQualityIndex->pollution_location_id  = $req->location_id;
		$airQualityIndex->date = date('Y-m-d', strtotime($req->date));
		$airQualityIndex->so2 = $req->so2;
		$airQualityIndex->nox = $req->nox;
		$airQualityIndex->pm2 = $req->pm2;
		$airQualityIndex->pm10 = $req->pm10;
		if ($airQualityIndex->save()) {
			return true;
		}
	}

	public function delete($req)
	{
		$air = AirQualityIndex::find($req->id);

		if ($air->delete()) {
			return true;
		}
	}

	public function getPollutionLocationName($id)
	{
		return PollutionLocation::where('id', $id)->value('name');
	}
}
