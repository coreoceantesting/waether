<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiWeatherData extends Model
{
    use HasFactory;

    protected $fillable = ['location_id', 'date', 'time', 'temp_out', 'hi_temp', 'low_temp', 'out_hum', 'dew_pt', 'wind_speed', 'wind_run', 'hi_speed', 'hi_dir', 'wind_chill', 'heat_index', 'thw_index', 'bar', 'rain', 'rain_rate', 'heat_dd', 'cool_dd', 'in_temp', 'in_hum', 'in_dew', 'in_heat', 'in_emc', 'in_air_destiny', 'wind_samp', 'wind_txt', 'iss_recept', 'arc_int', 'wind_dir', 'datetime'];
}
