<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\SlideImage;
use App\Models\Page;

class AboutController extends Controller
{
    public function aboutUs(){
        return view('frontend.about');
    }
}
