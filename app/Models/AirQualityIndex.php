<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PollutionLocation;

class AirQualityIndex extends Model
{
    use HasFactory;

    protected $table = "air_quality_index";

    public function pollutionLocation(){
        return $this->belongsTo(PollutionLocation::class, 'pollution_location_id');
    }

    protected $fillable = ['pollution_location_id', 'date', 'so2', 'nox', 'pm2', 'rspm', 'co', 'o3', 'nh3'];

}