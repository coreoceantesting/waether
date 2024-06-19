<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Admin\SettingRepository;

class SettingController extends Controller
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository){
        $this->settingRepository = $settingRepository;
    }

    public function list(Request $req){
        
        $setting = $this->settingRepository->getSetting();

        $months = ["01" => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];

        return view('admin.setting.list')->with(['setting' => $setting, 'months' => $months]);
    }

    public function save(Request $req){

        $setting = $this->settingRepository->saveWeatherSetting($req);

        if($setting){
            return redirect('admin/setting')->with('success', 'Weather Setting updated successfully');
        }
    }

    public function saveDashboardBanner(Request $req){
        $setting = $this->settingRepository->saveDashboardBanner($req);

        if($setting){
            return redirect('admin/setting')->with('success', 'Weather Setting updated successfully');
        }
    }
}
