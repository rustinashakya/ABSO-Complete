<?php
use App\Models\Page;

if(!function_exists('getPage'))
{
    function getPage($slug)
    {
        $page = Page::get();
        return $page;
    }
}