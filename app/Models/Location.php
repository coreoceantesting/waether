<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Weather;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';

    protected $fillable = ['name', 'path'];

    public function weathers(){
        return $this->hasMany(Weather::class, 'location_id', 'id');
    }
    public function weathers1(){
        return $this->hasMany(Weather::class, 'location_id', 'id');
    }
    public function weathers2(){
        return $this->hasMany(Weather::class, 'location_id', 'id');
    }
    public function weathers3(){
        return $this->hasMany(Weather::class, 'location_id', 'id');
    }
}
