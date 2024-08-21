<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Notice;
use App\Models\SlideImage;
use App\Models\Page;
use App\Models\SiteSetting;

class HomeController extends Controller
{

    public function index() {
        $meta_tag = '';
        $category = Category::with('pages' )
                    ->where('is_menu', '1')
                    ->get();
        $slider = SlideImage::orderBy('id','asc')->get();
        $page = Category::with(['pages' => function($q) {
            $q->take(7);
        }])->where('name','Popular Tourism')->get();
        $page_facilities = Category::with('pages' )->where('is_menu','facilities')->get();
        $campaign = Campaign::where('status','1')->first();
        $ishomepage = 'yes';
        $site_setting = SiteSetting::firstOrFail();
        $notice = Notice::latest()->get();
        return view('home.index',compact('slider','page','ishomepage','page_facilities','campaign','site_setting','notice','meta_tag'));
    }
}
