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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->mediumText('address')->nullable();
            $table->foreignId('vacancy_id')->constrained('vacancies')->onDelete('cascade');
            $table->enum('high_level_education', ['high school', 'bachelor', 'master', 'pg', 'phd'])->nullable();
            $table->enum('experience', ['less than 1 year', '1 to 2 years', '2 to 5 years', '5 to 10 years', 'more than 10 years'])->nullable();
            $table->text('training_description')->nullable();
            $table->text('cover_letter')->nullable();
            $table->string('cv_file')->nullable();
            $table->string('salary_expectation')->nullable();
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
        Schema::dropIfExists('applicants');
    }
};
