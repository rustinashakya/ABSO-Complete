<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MediaCoverage;
use App\Models\News;
use App\Models\Service;
use App\Models\Team;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $team=Team::get();
        $news=News::get();
        return view('admin.dashbaord',compact('team','news'));
    }
}
