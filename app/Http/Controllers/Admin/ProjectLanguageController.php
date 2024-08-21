<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Project;
use App\Models\ProjectLanguage;
use Illuminate\Http\Request;

class ProjectLanguageController extends Controller
{

    public function index($project_id)
    {
        $project = Project::find($project_id);
        $languages = ProjectLanguage::where('project_id', $project_id)->get();
        return view('admin.project.language.index', compact('project', 'languages'));
    }


    public function create($project_id)
    {
        $project = Project::find($project_id);
        $languages = Language::all();
        return view('admin.project.language.create', compact('project', 'languages'));
    }

    public function store(Request $request, $project_id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'short_description' => 'required',
        ]);

        $project = Project::find($project_id);
        $language = ProjectLanguage::updateOrCreate([
            'language_id' => $request->language_id,
            'project_id' => $project->id
        ], [
            'title' => $request->title,
            'description' => $request->description,
            'short_description' => $request->short_description,
        ]);
        return redirect()->route('admin.project.language.index', $project->id)->withMessage('Project Language created Successfully!');
    }

    public function edit($project_id, $id)
    {
        $project = Project::find($project_id);
        $project_language = ProjectLanguage::find($id);
        $languages = Language::all();
        return view('admin.project.language.edit', compact('project', 'project_language', 'languages'));
    }

    public function update(Request $request, $project_id, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'short_description' => 'required',
        ]);
        $project = Project::find($project_id);
        $language = ProjectLanguage::find($id);
        $language->update([
           'language_id' => $request->language_id,
            'title' => $request->title,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'project_id' => $project->id
        ]);
        return redirect()->route('admin.project.language.index', $project->id)->withMessage('Project Language updated Successfully!');
    }

    public function destroy($project_id, $id)
    {
        $project = Project::find($project_id);
        $language = ProjectLanguage::find($id);
        $language->delete();
        return redirect()->route('admin.project.language.index', $project->id)->withMessage('Project Language Deleted Successfully!');
    }
}
