<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PrivacyController extends Controller
{
    public function privacy($private_policy){
        $private_policy = Page::where('page_slug',$private_policy)->firstOrFail();
        // dd($private_policy);
        return view('frontend.privacy.index',compact('private_policy'));
    }

    public function technical($technical_support){
        $technical_support = Page::where('page_slug',$technical_support)->firstOrFail();
        return view('frontend.privacy.technical',compact('technical_support'));
    }
}
