<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Models\SlideImage;
use App\Models\SiteSetting;
use App\Models\Category;
use App\Models\Donation;
use App\Models\Event;
use App\Models\MediaCoverage;
use App\Models\Schedule_month;
use App\Models\Schedule_day;

class GetController extends Controller
{

    public function slider_image(){
        $images=SlideImage::select('name','caption_description','main_image','mobile_image','url','youtube_url')->get();
        if(count($images)>0){
            return response()->json([
                'status'=> true,
                'image'=>$images,
            ],200
            );
        }else{
            return response()->json([

                'status'=> false,
                'image'=>'Failed to fetch',
            ],400
            );
        }
    }
    public function site_setting(){

        $setting=SiteSetting::latest()
        ->first();
        if (!is_null($setting)) {
            return response()->json([
                'status' => true,
                'site_setting' => $setting,
            ], 200);
        }else{
            return response()->json(
                [

                'status'=> false,
                'site_setting'=>'Failed to fetch',
            ],400
            );
        }
    }
    public function category(){

        $category = Category::select('name')->where('is_menu', '1')
        ->get();
        if(count($category)>0){
            return response()->json([
                'status'=> true,
                'category'=>$category,
            ],200
            );
        }else{
            return response()->json([

                'status'=> false,
                'category'=>'Failed to fetch',
            ],400
            );
        }
    }
    public function international_events(){

        $events = Event::select('id','title','type','file_image','utube_link','description','slug','meta_description','meta_keyword')
        ->get();
        if(count($events)>0){
            return response()->json([
                'status'=> true,
                'message'=> 'Data fetched successfully!',
                'data'=>$events,
            ],200
            );
        }else{
            return response()->json([

                'status'=> false,
                'message'=>'Failed to fetch',
            ],400
            );
        }
    }
    public function news(){

        $events = MediaCoverage::select('id','title','slug','type','file_image','utube_link','description','publish_date')
        ->get();
        if(count($events)>0){
            return response()->json([
                'status'=> true,
                'message'=> 'Data fetched successfully!',
                'data'=>$events,
            ],200
            );
        }else{
            return response()->json([

                'status'=> false,
                'message'=>'Failed to fetch',
            ],400
            );
        }
    }

        public function getNewsBySlug($slug)
        {

            $events = MediaCoverage::where('slug', $slug)->first();
            if (!$events) {
                return response()->json(['error' => 'News not found'], 404);
            }
            return response()->json(['news' => $events], 200);

        }
    public function schedule(){

        $events = Schedule_month::with(['schedule_day' => function ($query) {
            $query->orderBy('name');
        }])->select('id','month_name')->orderBy('order_by')->get();

        // dd($events);
        if(count($events)>0){
            return response()->json([
                'status'=> true,
                'message'=> 'Data fetched successfully!',
                'data'=>$events,
            ],200
            );
        }else{
            return response()->json([

                'status'=> false,
                'message'=>'Failed to fetch',
            ],400
            );
        }
    }
    public function donation(){

        $donation = Donation::select('id','name')->where('status','active')->get();
        if(count($donation)>0){
            return response()->json([
                'status'=> true,
                'message'=> 'Data fetched successfully!',
                'data'=>$donation,
            ],200
            );
        }else{
            return response()->json([

                'status'=> false,
                'message'=>'Failed to fetch',
            ],400
            );
        }
    }

    /**
     * method to redirect to payment page as per payment method
     */
    public function payment_view_page(){

    }

    public function getStaticPageBySlug($slug)
        {
            $page = Page::where('page_slug',$slug)->
            select(
                'name',
                'sub_name',
                'category_id',
                'description',
                'page_slug',
                'site_title',
                'meta_description',
                'meta_keyword',
                'main_image',
                'mobile_image',
                'youtube_link')
                ->first();
            if ($page) {
                return response()->json(
                    [
                        'status' => true,
                        'page' => $page,
                    ],
                    200
                );
            } else {
                return response()->json(
                    [

                        'status' => false,
                        'page' => 'No page found',
                    ],
                    400
                );
            }
    }
}
