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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->text('head_office_address')->nullable();
            $table->string('head_office_phone_no')->nullable();
            $table->string('head_office_email')->nullable();
            $table->text('head_office_map')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['head_office_address', 'head_office_phone_no', 'head_office_email', 'head_office_map']);
        });
    }
};
