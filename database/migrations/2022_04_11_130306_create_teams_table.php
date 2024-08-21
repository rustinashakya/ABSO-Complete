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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('profile_image')->nullable();
            $table->mediumText('description')->nullable();
            $table->enum('type', ['general', 'expert'])->nullable();
            $table->integer('order_by')->nullable();
            $table->string('experience')->nullable();
            $table->string('slug')->nullable();
            $table->foreignId('designation_id')->nullable()->constrained()->cascadeOnDelete();
            //social Media
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();

            //meta data
            $table->text('html_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
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
        Schema::dropIfExists('teams');
    }
};
