<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectKpi;
use Illuminate\Http\Request;

class ProjectKpiController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'capacity'=> 'required|max:100',
            'capital'=> 'required|max:100',
        ]);

        $projectKpi = ProjectKpi::updateOrcreate([
           'capacity'=> $request->capacity,
           'capital'=> $request->capital,
           'project_id'=> $request->project_id
        ]);

        return redirect()->route('admin.project.show', $request->project_id)->withMessage('Project KPI created successfully');
    }
}
