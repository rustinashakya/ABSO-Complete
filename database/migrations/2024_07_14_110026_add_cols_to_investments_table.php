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
        Schema::table('investments', function (Blueprint $table) {
            $table->foreignId('page_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('project_type_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('stage', ['completed', 'ongoing'])->default('completed');
            $table->string('type_of_service')->nullable()->default('investment');
            $table->string('main_image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->mediumText('short_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investments', function (Blueprint $table) {
            //
        });
    }
};
