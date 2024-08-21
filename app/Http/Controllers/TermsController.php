<?php

namespace App\Http\Controllers;
use App\Models\Page;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function terms($term_condition){
        $term_condition = Page::where('page_slug',$term_condition)->firstOrFail();
        return view('frontend.terms.index',compact('term_condition'));
    }
}
