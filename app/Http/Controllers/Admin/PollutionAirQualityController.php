<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Admin\PollutionAirQualityRepository;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportAirQuality;

class PollutionAirQualityController extends Controller
{
    protected $pollutionAirQualityRepository;

    public function __construct(PollutionAirQualityRepository $pollutionAirQualityRepository){
        parent::__construct();
        $this->pollutionAirQualityRepository = $pollutionAirQualityRepository;
    }

    public function list(Request $req){
        if($req->ajax())
        {
            $locations = $this->pollutionAirQualityRepository->list($req->location);

            return DataTables::of($locations)
                    ->addIndexColumn()
                    ->editColumn('date', function ($data) {
                        return date('d-m-Y', strtotime($data->date));
                    })
                    ->toJson();
        }
        $locationName = $this->pollutionAirQualityRepository->getPollutionLocationName($req->location);

        return view('admin.pollution.air-quality.list')->with(['locationName' => $locationName]); 
    }

    public function add(Request $req){
        $locationName = $this->pollutionAirQualityRepository->getPollutionLocationName($req->location);

        return view('admin.pollution.air-quality.add')->with(['locationName' => $locationName]); 
    }

    public function store(Request $req){
        $location = $this->pollutionAirQualityRepository->store($req);
        
        if($location){
            return redirect('/admin/pollution/location/'.$req->location_id.'/air-quality/list')->with(['status' => 'Air quality added successfully']);
        }
    }

    public function edit(Request $req){
        $airQuality = $this->pollutionAirQualityRepository->edit($req->id);
        
        $locationName = $this->pollutionAirQualityRepository->getPollutionLocationName($req->location);

        return view('admin.pollution.air-quality.edit')->with(['airQuality' => $airQuality, 'locationName' => $locationName]); 
    }

    public function update(Request $req){
        $location = $this->pollutionAirQualityRepository->update($req);
        
        if($location){
            return redirect('/admin/pollution/location/'.$req->location_id.'/air-quality/list')->with(['status' => 'Air quality updated successfully']);
        }
    }

    public function delete(Request $req){
        $location = $this->pollutionAirQualityRepository->delete($req);
        
        if($location){
            return back()->with(['status' => 'Air quality removed successfully']);
        }
    }

    public function import(Request $req){
        Excel::import(new ImportAirQuality, $req->file('import'));
        return back()->with(['status' => 'Air Quality Import Successfully']);
    }
}
