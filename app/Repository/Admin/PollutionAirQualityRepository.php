<?php

namespace App\Repository\Admin;

use App\Models\AirQualityIndex;
use App\Models\PollutionLocation;

class PollutionAirQualityRepository
{
	public function list($location)
	{
		return AirQualityIndex::where('pollution_location_id', $location)
			->select('id', 'so2', 'nox', 'pm2', 'rspm', 'date', 'co', 'o3', 'nh3')
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
		$airQualityIndex->rspm = $req->rspm;
		$airQualityIndex->co = $req->co;
		$airQualityIndex->o3 = $req->o3;
		$airQualityIndex->nh3 = $req->nh3;
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
		$airQualityIndex->rspm = $req->rspm;
		$airQualityIndex->co = $req->co;
		$airQualityIndex->o3 = $req->o3;
		$airQualityIndex->nh3 = $req->nh3;
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
