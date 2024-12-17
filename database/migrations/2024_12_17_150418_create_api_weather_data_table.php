<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_weather_data', function (Blueprint $table) {
            $table->id();
            $table->string('location_id')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('datetime')->nullable();
            $table->string('temp_out')->nullable();
            $table->string('hi_temp')->nullable();
            $table->string('low_temp')->nullable();
            $table->string('out_hum')->nullable();
            $table->string('dew_pt')->nullable();
            $table->string('wind_speed')->nullable();
            $table->string('wind_dir')->nullable();
            $table->string('wind_run')->nullable();
            $table->string('hi_speed')->nullable();
            $table->string('hi_dir')->nullable();
            $table->string('wind_chill')->nullable();
            $table->string('heat_index')->nullable();
            $table->string('thw_index')->nullable();
            $table->string('bar')->nullable();
            $table->string('rain')->nullable();
            $table->string('rain_rate')->nullable();
            $table->string('heat_dd')->nullable();
            $table->string('cool_dd')->nullable();
            $table->string('in_temp')->nullable();
            $table->string('in_hum')->nullable();
            $table->string('in_dew')->nullable();
            $table->string('in_heat')->nullable();
            $table->string('in_emc')->nullable();
            $table->string('in_air_destiny')->nullable();
            $table->string('wind_samp')->nullable();
            $table->string('wind_txt')->nullable();
            $table->string('iss_recept')->nullable();
            $table->string('arc_int')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_weather_data');
    }
};
