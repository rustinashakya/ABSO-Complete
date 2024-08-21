<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function __construct()
    {
        $shared_sectors = Page::where('type', 'sector')->get();
        $shared_static_pages = Page::where('type', 'static_page')->get();
        $shared_services = Page::where('type', 'service')->get();
        $shared_site_setting = SiteSetting::first();
        $shared_projects = Project::latest()->get();

        view()->share([
            'shared_static_pages' => $shared_static_pages,
            'shared_sectors' => $shared_sectors,
            'shared_services' => $shared_services,
            'shared_site_setting' => $shared_site_setting,
            'shared_projects' => $shared_projects
        ]);
    }

}
