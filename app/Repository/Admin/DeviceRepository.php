<?php

namespace App\Repository\Admin;

use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeviceRepository
{
	public function list()
	{
		return Location::select('id', 'name', 'path', 'status')->get();
	}

	public function store($req)
	{
		DB::beginTransaction();

		try {
			$device = new Location;
			$device->name = $req->name;
			$device->path = serialize($req->path);
			$device->graph_title = $req->graph_title;
			$device->status = $req->status;
			if ($device->save()) {
				DB::commit();
				return true;
			}
		} catch (\Exception $e) {
			DB::roolback();
			Log::info($e);
			return false;
		}
	}

	public function edit($id)
	{
		return Location::find($id);
	}

	public function update($req)
	{
		DB::beginTransaction();

		try {
			$device = Location::find($req->id);
			$device->name = $req->name;
			$device->path = serialize($req->path);
			$device->graph_title = $req->graph_title;
			$device->status = $req->status;
			if ($device->save()) {
				DB::commit();
				return true;
			}
		} catch (\Exception $e) {
			DB::roolback();
			Log::info($e);
			return false;
		}
	}
}
