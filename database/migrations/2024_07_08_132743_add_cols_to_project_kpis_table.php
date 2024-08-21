<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_kpis', function (Blueprint $table) {
            $table->string('altitude')->nullable();
            $table->string('source')->nullable();
            $table->string('subbasin')->nullable();
            $table->string('kw_per_year')->nullable();
            $table->string('full_load_hours')->nullable();
            $table->string('plant_availability')->nullable();
            $table->string('circulation_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_kpis', function (Blueprint $table) {
            $table->dropColumn(['altitude', 'source', 'subbasin', 'kw_per_year', 'full_load_hours', 'plant_availability', 'circulation_rate']);
        });
    }
};
