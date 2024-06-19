<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Admin\DeviceRepository;

class DeviceController extends Controller
{
    protected $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository){
        $this->deviceRepository = $deviceRepository;
    }

    public function list(){
        $devices = $this->deviceRepository->list();

        return view('admin.devices.list')->with(['devices' => $devices]);
    }

    public function add(){
        return view('admin.devices.add'); 
    }

    public function store(Request $req){
        $device = $this->deviceRepository->store($req);
        
        if($device){
            return redirect('admin/device/list')->with(['status' => 'Device Added successfully']);
        }
    }

    public function edit($id){
        $device = $this->deviceRepository->edit($id);

        return view('admin.devices.edit')->with(['device' => $device]); 
    }

    public function update(Request $req){
        $device = $this->deviceRepository->update($req);
        
        if($device){
            return redirect('admin/device/list')->with(['status' => 'Device updated successfully']);
        }
    }
}
