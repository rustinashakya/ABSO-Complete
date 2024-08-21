<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventApiController extends Controller
{
    public function get_event_by_slug($slug){
        $events = Event::select('id','title','type','file_image','utube_link','description','slug','meta_description','meta_keyword')
        ->where('slug',$slug)
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
}
