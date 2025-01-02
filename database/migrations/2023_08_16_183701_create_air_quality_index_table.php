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
        Schema::create('air_quality_index', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pollution_location_id');
            $table->date('date')->nullable();
            $table->float('so2', 5, 2)->default(0);
            $table->float('nox', 5, 2)->default(0);
            $table->float('pm2', 5, 2)->default(0);
            $table->float('pm10', 5, 2)->default(0);
            $table->foreign('pollution_location_id')->references('id')->on('pollution_locations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_quality_index');
    }
};
