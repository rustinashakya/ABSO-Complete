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
            //team
            $table->text('team_html_title')->nullable();
            $table->text('team_meta_keyword')->nullable();
            $table->text('team_meta_description')->nullable();
            // project 
            $table->text('project_html_title')->nullable();
            $table->text('project_meta_keyword')->nullable();
            $table->text('project_meta_description')->nullable();
            //investment
            $table->text('investment_html_title')->nullable();
            $table->text('investment_meta_keyword')->nullable();  
            $table->text('investment_meta_description')->nullable();
            //news
            $table->text('news_html_title')->nullable();
            $table->text('news_meta_keyword')->nullable();
            $table->text('news_meta_description')->nullable();

            //career 
            $table->text('career_html_title')->nullable();
            $table->text('career_meta_keyword')->nullable();
            $table->text('career_meta_description')->nullable();

            //client
            $table->text('client_html_title')->nullable();
            $table->text('client_meta_keyword')->nullable();
            $table->text('client_meta_description')->nullable();
            //legal document
            $table->text('legal_document_html_title')->nullable();
            $table->text('legal_document_meta_keyword')->nullable();
            $table->text('legal_document_meta_description')->nullable();
            //contact us
            $table->text('contact_us_html_title')->nullable();
            $table->text('contact_us_meta_keyword')->nullable();
            $table->text('contact_us_meta_description')->nullable();

            //history
            $table->text('history_html_title')->nullable();
            $table->text('history_meta_keyword')->nullable();
            $table->text('history_meta_description')->nullable();
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
            //
        });
    }
};
