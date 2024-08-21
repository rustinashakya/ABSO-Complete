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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->string('reports_to')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('vacancy_level_id')->constrained()->cascadeOnDelete();
            $table->longText('description');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->date('deadline');
            $table->unsignedInteger('created_by');

            //meta data
            $table->text('html_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();

            //timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacancies');
    }
};
