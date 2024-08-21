<?php

use App\Http\Controllers\Api\ApplicantController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\LangController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


Route::get('sitemap.xml', [SitemapController::class, 'index']);
//language switcher
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

//frontend
Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/career', 'career')->name('career');
    Route::get('/career/{slug}', 'career_details')->name('career.details');
    Route::get('/career-apply/{slug}', 'career_apply')->name('career.apply');
    Route::get('/career-preview/{id}', 'career_preview')->name('career.preview');
    Route::get('/career/edit/{id}', 'career_edit')->name('career.edit');
    Route::get('/career-confirm/{id}', 'career_confirm')->name('career.confirm');
    Route::get('/sectors/{slug}',  'sector')->name('sector');
    Route::get('/services/{slug}', 'service')->name('service');
    Route::get('/projects', 'project')->name('project');
    Route::get('/projects/{id}', 'project_details')->name('project.details');
    Route::get('/contact-us', 'contact')->name('contact');
    Route::get('/contact-confirm', 'contact_confirm')->name('contact.confirm');
    Route::get('/news', 'news')->name('news');
    Route::get('/news/{slug}', 'news_details')->name('news.details');
    Route::get('/our-team', 'teams')->name('team');
    Route::get('/our-team/{slug}', 'team_details')->name('team.details');
    Route::get('/legal-documents', 'gallery')->name('gallery');
    Route::get('/our-history', 'history')->name('history');
    Route::get('/our-clientele', 'clientele')->name('clientele');
    Route::get('/investments', 'investment')->name('investment');
    Route::get('/investment/{slug}', 'investment_details')->name('investment.details');
    Route::get('{slug}', 'static_page')->name('page');
    

});

Route::controller(ApplicantController::class)->group(function () {
   Route::post('/contact/store', 'contact_store')->name('contact.store');
});


