<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectType;

class ProjectTypeController extends Controller
{
    public function index()
    {
        $projectTypes = ProjectType::all();
        return view('admin.project.type.index', compact('projectTypes'));
    }

    public function create()
    {
        return view('admin.project.type.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        ProjectType::create($request->all());
        return redirect()->route('admin.project.types.index')->withMessage('Project Type created successfully.');
    }

    public function edit($id)
    {
        $project_type = ProjectType::findOrFail($id);
        return view('admin.project.type.edit', compact('project_type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $projectType = ProjectType::findOrFail($id);
        $projectType->update($request->all());
        return redirect()->route('admin.project.types.index')->withMessage('Project Type updated successfully.');
    }

    public function destroy($id)
    {
        $projectType = ProjectType::findOrFail($id);
        $projectType->delete();
        return redirect()->route('admin.project.types.index')->withMessage('Project Type deleted successfully.');
    }
}
