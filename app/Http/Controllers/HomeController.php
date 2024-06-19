<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\HomeRepository;
use PDF;

class HomeController extends Controller
{
    protected $homeRepository;

    public function __construct(HomeRepository $homeRepository)
    {
        parent::__construct();
        
        $this->homeRepository = $homeRepository;
    }

    public function home(Request $req)
    {
        $setting = $this->homeRepository->getSetting();
        
        $bannerImage = $this->homeRepository->getBannerImage();

        $data = $this->homeRepository->getHourlyData();

        $lastDayTemp = "";
        if($setting->config_name == "rainy_day"){
            $search = date('Y-m-d').' 08:30:00';
            $locations = $this->homeRepository->getRainyWeathersLocationWeatherDetails($search);
            // to get total rain
            $totalRain = $this->homeRepository->getTotalRain($search);

            // to get last day of rain
            $lastdayRain =  $this->homeRepository->getLastDayRain($search);

            // to get current time of rain
            $currentRain = $this->homeRepository->getCurrentRain($search);

            // to get prograssive rain
            $prograsiveRain = $this->homeRepository->getPrograssiveRain($search);
                        
            return view('website.home')->with(['locations'=> $locations, 'totalRain' => $totalRain, 'lastdayRain' => $lastdayRain, 'currentRain' => $currentRain, 'prograsiveRain' => $prograsiveRain, 'data' => $data, 'setting' => $setting, 'lastDayTemp' => $lastDayTemp, 'bannerImage' => $bannerImage]);
            
        }else{
            $search = date('Y-m-d').' 00:00:00';

            $locations = $this->homeRepository->getSunnyLocationWeatherDetails($search);

            $lastDayTemp = $this->homeRepository->getLastDaySunnyTemp();

            $locations = $this->homeRepository->getRainyWeathersLocationWeatherDetails($search);

            // to get total min temp out
            $minTempOut = $this->homeRepository->getMinTempOut();

            // to get total max temp out
            $maxTempOut = $this->homeRepository->getMaxTempOut();

            // to get total max heat Index
            $maxHeatIndex = $this->homeRepository->getMaxHeatIndex();

            // to get total rain
            $minHeatIndex = $this->homeRepository->getMinHeatIndex();

                        
            return view('website.home')->with(['locations'=> $locations, 'data' => $data, 'setting' => $setting, 'lastDayTemp' => $lastDayTemp, 'bannerImage' => $bannerImage, 'minTempOut' => $minTempOut, 'maxTempOut' => $maxTempOut, 'maxHeatIndex' => $maxHeatIndex, 'minHeatIndex' => $minHeatIndex]);

        }
        // return $lastDayTemp;
        
        
        
    }

    public function hightide(Request $req){
        $hightides = $this->homeRepository->getMonthlyHightide();
        // return view('website.hightide.pdf', compact('hightides'));
        $pdf = PDF::loadView('website.hightide.pdf', compact('hightides'));
        // download PDF file with download method
        return $pdf->stream();
    }
}
