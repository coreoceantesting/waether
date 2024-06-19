<?php

namespace App\Repository\Admin;

use App\Models\Setting;
use Storage;

class SettingRepository{
	public function getSetting(){
		return Setting::whereIn('config_name', ['sunny_day', 'rainy_day', 'winter_day'])->select('config_name', 'icon', 'background_image', 'from', 'to')->get();
	}

	public function saveWeatherSetting($req){
		if(isset($req->config_name)){
            if(count($req->config_name) > 0){
            	
                for($i=0; $i < count($req->config_name); $i++){
                	
                	$check = Setting::where('config_name', $req->config_name[$i])->first();
                	$icon = $check->icon ?? ''; 
	            	$background = $check->background_image ?? '';
                	if($check){
			            if(isset($req->icon[$i]) && $req->icon[$i] != "")
			            {
		            		if($check->icon != "")
	                		{
		                		if (Storage::exists($check->icon)){
				                    Storage::delete($check->icon);
				                }
				            }
				            $iconName = $req->config_name[$i].'_icon'.time().'.'.$req->icon[$i]->getClientOriginalExtension();
				            $req->file('icon')[$i]->storeAs('setting/upload', $iconName);
				            $icon = 'setting/upload/'.$iconName;
				        }
			            
			            

			            if(isset($req->background_image[$i]) && $req->background_image[$i] != "")
			            {
		            		if($check->background_image != "")
	                		{
		                		if (Storage::exists($check->background_image)){
				                    Storage::delete($check->background_image);
				                }
				            }
				            $backgroundImage = $req->config_name[$i].'_background_image'.time().'.'.$req->background_image[$i]->getClientOriginalExtension();
				            $req->file('background_image')[$i]->storeAs('setting/upload', $backgroundImage);
				            $background = 'setting/upload/'.$backgroundImage;
				        }


					    $setting = Setting::find($check->id);
					    $setting->config_name = $req->config_name[$i];
					    $setting->icon = $icon;
					    $setting->background_image = $background;
					    $setting->from = $req->from[$i];
					    $setting->to = $req->to[$i];
					    $setting->save();
                	}else{

                		if(isset($check->icon) && $check->icon != "")
                		{
	                		if (Storage::exists($check->icon)){
			                    Storage::delete($check->icon);
			                }
			            }
			            if(isset($req->icon[$i]) && $req->icon[$i] != "")
			            {
				            $iconName = $req->config_name[$i].'_icon'.time().'.'.$req->icon[$i]->getClientOriginalExtension();
				            $req->file('icon')[$i]->storeAs('setting/upload', $iconName);
				            $icon = 'setting/upload/'.$iconName;
				        }
			            
			            if(isset($check->background_image) && $check->background_image != "")
                		{
	                		if (Storage::exists($check->background_image)){
			                    Storage::delete($check->background_image);
			                }
			            }
			            if(isset($req->background_image[$i]) && $req->background_image[$i] != "")
			            {
				            $backgroundImage = $req->config_name[$i].'_background_image'.time().'.'.$req->background_image[$i]->getClientOriginalExtension();
				            $req->file('background_image')[$i]->storeAs('setting/upload', $backgroundImage);
				            $background = 'setting/upload/'.$backgroundImage;
				        }

					    $setting = new Setting;
					    $setting->config_name = $req->config_name[$i];
					    $setting->icon = $icon;
					    $setting->background_image = $background;
					    $setting->from = $req->from[$i];
					    $setting->to = $req->to[$i];
					    $setting->save();
                	}
                }
            }

            return true;
        }
	}

	public function saveDashboardBanner($req){
		$check = Setting::where('config_name', 'dashboard_banner')
			   ->doesntExist();

		if($check){
			if(isset($req->banner_image) && $req->banner_image != "")
            {
	            $bannerImage = $req->config_name.'_banner_image'.time().'.'.$req->banner_image->getClientOriginalExtension();
	            $req->file('banner_image')->storeAs('setting/upload', $bannerImage);
	            $banner = 'setting/upload/'.$bannerImage;

	            $setting = new Setting;
	            $setting->config_name = $req->config_name;
	            $setting->background_image = $banner;
	            $setting->save();
	        }
		}else{
        	$banner = Setting::where('config_name', 'dashboard_banner')
        		    ->first();

        	if(isset($banner->background_image) && $banner->background_image != "")
    		{
        		if (Storage::exists($banner->background_image)){
                    Storage::delete($banner->background_image);
                }
            }
            if(isset($banner->background_image) && $banner->background_image != "")
            {
	            $backgroundImage = $req->config_name.'_banner_image'.time().'.'.$req->banner_image->getClientOriginalExtension();
	            $req->file('banner_image')->storeAs('setting/upload', $backgroundImage);
	            $background = 'setting/upload/'.$backgroundImage;

	            $setting = Setting::find($banner->id);
	            $setting->background_image = $background;
	            $setting->save();
	        }
        }
	        return true;
	}
}