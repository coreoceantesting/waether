<?php 

namespace App\Repository\Admin;

use App\Models\PollutionLocation;

class PollutionLocationRepository{
	public function list(){
		return PollutionLocation::select('id', 'name', 'status')->get();
	}

	public function store($req){
		$pollutionLocation = new PollutionLocation;
		$pollutionLocation->name = $req->name;
		$pollutionLocation->status = $req->status;
		if($pollutionLocation->save()){
			return true;
		}
	}

	public function edit($id){
		return PollutionLocation::find($id);
	}

	public function update($req){
		$pollutionLocation = PollutionLocation::find($req->id);
		$pollutionLocation->name = $req->name;
		$pollutionLocation->status = $req->status;
		if($pollutionLocation->save()){
			return true;
		}
	}
}