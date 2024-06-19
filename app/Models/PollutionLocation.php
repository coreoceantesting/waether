<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AirQualityIndex;
use App\Models\PollutionLocation;

class PollutionLocation extends Model
{
    use HasFactory;

    protected $table = 'pollution_locations';

    public function airQualityIndex(){
        return $this->hasMany(AirQualityIndex::class, 'pollution_location_id', 'id');
    }
}
