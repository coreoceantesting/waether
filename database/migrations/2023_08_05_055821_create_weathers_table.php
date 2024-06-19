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
        Schema::create('weathers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->date('date');
            $table->time('time');
            $table->dateTime('datetime');
            $table->double('temp_out', 7, 2)->nullable();
            $table->double('hi_temp', 7, 2)->nullable();
            $table->double('low_temp', 7, 2)->nullable();
            $table->double('out_hum', 7, 2)->nullable();
            $table->double('dew_pt', 7, 2)->nullable();
            $table->double('wind_speed', 7, 2)->nullable();
            $table->string('wind_dir')->nullable();
            $table->double('wind_run', 7, 2)->nullable();
            $table->double('hi_speed', 7, 2)->nullable();
            $table->string('hi_dir')->nullable();
            $table->double('wind_chill', 7, 2)->nullable();
            $table->double('heat_index', 7, 2)->nullable();
            $table->double('thw_index', 7, 2)->nullable();
            $table->double('bar', 7, 2)->nullable();
            $table->double('rain', 7, 2)->nullable();
            $table->double('rain_rate', 7, 2)->nullable();
            $table->double('heat_dd', 7, 2)->nullable();
            $table->double('cool_dd', 7, 2)->nullable();
            $table->double('in_temp', 7, 2)->nullable();
            $table->double('in_hum', 7, 2)->nullable();
            $table->double('in_dew', 7, 2)->nullable();
            $table->double('in_heat', 7, 2)->nullable();
            $table->double('in_emc', 7, 2)->nullable();
            $table->double('in_air_destiny', 7, 2)->nullable();
            $table->double('wind_samp', 7, 2)->nullable();
            $table->double('wind_txt', 7, 2)->nullable();
            $table->double('iss_recept', 7, 2)->nullable();
            $table->double('arc_int', 7, 2)->nullable();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weathers');
    }
};
