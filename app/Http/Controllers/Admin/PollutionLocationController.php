<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Admin\PollutionLocationRepository;

class PollutionLocationController extends Controller
{
    protected $pollutionLocationRepository;

    public function __construct(PollutionLocationRepository $pollutionLocationRepository){
        $this->pollutionLocationRepository = $pollutionLocationRepository;
    }

    public function list(){
        $locations = $this->pollutionLocationRepository->list();

        return view('admin.pollution.location.list')->with(['locations' => $locations]);
    }

    public function add(){
        return view('admin.pollution.location.add'); 
    }

    public function store(Request $req){
        $location = $this->pollutionLocationRepository->store($req);
        
        if($location){
            return redirect('admin/pollution/location/list')->with(['status' => 'Location added successfully']);
        }
    }

    public function edit($id){
        $location = $this->pollutionLocationRepository->edit($id);

        return view('admin.pollution.location.edit')->with(['location' => $location]); 
    }

    public function update(Request $req){
        $location = $this->pollutionLocationRepository->update($req);
        
        if($location){
            return redirect('admin/pollution/location/list')->with(['status' => 'Location updated successfully']);
        }
    }
}
