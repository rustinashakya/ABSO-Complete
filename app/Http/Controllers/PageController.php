<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Team;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\MediaCoverage;
use App\Models\Notice;

class PageController extends Controller
{
    public function getAllPages($slug, Page $page) {
        // dd);
        $meta_tag = Page::where('page_slug',$slug)->first();
        $get_category = Category::query();
        $sub_menu_about_us = Category::with('pages')->where('name','About Us ')->first();
        $sub_menu_csr = Category::with('pages')->where('name','CSR ')->first();
        $sub_menu_technology = Category::with('pages')->where('name','Use of technology ')->first();
        $pages = Category::where('name','Popular Tourism')->first();
        $side_menu = Category::with('pages')->where('name','Popular Tourism')->get();
        $team = Team::orderBy('order_by', 'ASC')->get();
        $gallery = Gallery::latest()->get();
        $media = MediaCoverage::latest()->get();
        $page = Page::where('page_slug', $slug)->firstOrFail();
        $notice = Notice::latest()->get();

        $redirect_page = $page->redirectPageBySlug($page->template);

        return view('frontend.'.$redirect_page, compact(
                    'page', 'team',
                    'pages','notice',
                    'media','gallery',
                    'side_menu','sub_menu_about_us',
                    'sub_menu_csr','sub_menu_technology',
                    'meta_tag'
                ));
    }

    public function facilities($slug, Page $page) {
        $page = Page::where('page_slug', $slug)->firstOrFail();
        $pages = Category::where('name','Popular Facilities')->first();
        $side_menu = Category::with('pages')->where('name','Popular Facilities')->get();
        // dd($side_menu);
        $redirect_page = $page->redirectPageBySlug($slug);
        // dd($redirect_page);
    return view('frontend.'.$redirect_page, compact('side_menu','pages','page'));
    }

    public function aboutTimeline($timeline_slug) {
        $page_timeline = Page::where('page_slug',$timeline_slug)->firstOrFail();
        return view('frontend.timeline',compact('page_timeline'));
    }

    public function aboutTeams($team_slug) {
        $page_team_board = Page::where('page_slug',$team_slug)->firstOrFail();
        $team = Team::get();
        // dd($page_team_board);
        $team = Team::orderBy('name','ASC')->get();
        return view('frontend.teams.index',compact('page_team_board','team'));
    }
    public function detailTeams() {
        return view('frontend.teams.detail');
    }
    public function aboutManagement($management) {
        $management = Page::where('page_slug',$management)->firstOrFail();
        $team = Team::get();
        $team = Team::orderBy('name','ASC')->get();


        return view('frontend.management',compact('management','team'));
    }

    public function aboutPartners($partners) {
        $partners = Page::where('page_slug',$partners)->firstOrFail();
        return view('frontend.partners',compact('partners'));
    }


    public function responsibility() {
        return view('frontend.responsibility');
    }

    public function environment($environment) {
        $environment = Page::where('page_slug',$environment)->firstOrFail();
        return view('frontend.environment',compact('environment'));
    }

    public function technology() {
        return view('frontend.technology');
    }
    public function useTechnology() {
        return view('frontend.useTechnology');
    }
    public function investors() {
        return view('frontend.investors');
    }

    public function shareHolder($shareholder) {
        $shareholder = Page::where('page_slug',$shareholder)->firstOrFail();
        return view('frontend.environment',compact('shareholder'));
    }

    public function generalInformation() {
        // $general = Page::where('page_slug',$general)->firstOrFail();
        return view('frontend.general');
    }

    public function restaurant($restaurant) {
        $restaurant = Page::where('page_slug',$restaurant)->firstOrFail();
        return view('frontend.restaurant',compact('restaurant'));
    }

    public function tourism($tourism) {
        $tourism = Page::where('page_slug',$tourism)->firstOrFail();
        return view('frontend.tourism',compact('tourism'));
    }

    public function palpa($palpa) {
        $palpa_view = Page::where('page_slug',$palpa)->firstOrFail();
        return view('frontend.palpa',compact('palpa_view'));
    }

    public function reach($reach) {
        $reach = Page::where('page_slug',$reach)->firstOrFail();
        return view('frontend.how_to_reach',compact('reach'));
    }

    public function places($places) {
        $places = Page::where('page_slug',$places)->firstOrFail();
        return view('frontend.places',compact('places'));
    }

    public function cableCar($cablecar) {
        $cablecar = Page::where('page_slug',$cablecar)->firstOrFail();
        return view('frontend.cable_car',compact('cablecar'));
    }

    public function generalInfo($generalinfo) {
        $generalinfo = Page::where('page_slug',$generalinfo)->firstOrFail();
        return view('frontend.media_info',compact('generalinfo'));
    }

    public function resort($resort) {
        $resort = Page::where('page_slug',$resort)->firstOrFail();
        return view('frontend.resort',compact('resort'));
    }

    public function tansan($tansan) {
        $tansen = Page::where('page_slug',$tansan)->firstOrFail();
        return view('frontend.tansen',compact('tansen'));
    }

    public function phulbari() {

        return view('frontend.phulbari');
    }

    public function chapiya() {
        return view('frontend.chapiya');
    }

    public function notice() {
        $notice = Notice::latest()->get();
        return view('frontend.notice',compact('notice'));
    }
    public function notice_detail($slug) {
        $notice = Notice::where('slug',$slug)->firstOrFail();
        return view('frontend.notice_detail',compact('notice'));
    }

    public function mediaDetail($slug) {
        $media = MediaCoverage::where('slug',$slug)->firstOrFail();
        return view('frontend.media_detail',compact('media'));
    }

    public function popularTourism() {
        $page = Category::with('pages')->where('name','Popular Tourism')->get();
        // $butwal_phulbari_park = Page::butwalphulbari()->firstOrFail();
        // $chhapiya = Page::chhapiya()->firstOrFail();
        // $tansen = Page::butwal()->firstOrFail();
        // $tourism = Page::palpatansen()->firstOrFail();
        // $palpa_view = Page::palpaview()->firstOrFail();
        return view('frontend.popular-tourism.popular_tourism',compact('page'));
    }
    public function popularFacilities() {
        $pages = Category::with('pages')->where('name','Popular Facilities')->get();
        $restaurant = Page::restaurant()->firstOrFail();
        $tourism = Page::palpatansen()->firstOrFail();
        $tansen = Page::butwal()->firstOrFail();
        $palpa_view = Page::palpaview()->firstOrFail();
        return view('frontend.popular-facilities.popular_facilities',compact('restaurant','tourism','tansen','palpa_view','pages'));

   }

   public function gallery() {
    return view('frontend.gallery');
}
public function media() {
    return view('frontend.media');
}

}
