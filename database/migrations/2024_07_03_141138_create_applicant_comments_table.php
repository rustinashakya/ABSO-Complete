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
        Schema::create('applicant_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade')->onUpdate('cascade');
            $table->text('comment');
            $table->date('comment_date');
            $table->foreignId('comment_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['accepted', 'rejected', 'pending', 'shortlisted'])->default('pending');
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
        Schema::dropIfExists('applicant_comments');
    }
};
