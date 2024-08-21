<?php

namespace App\Http\Controllers;

use App\Models\VacancyLevel;
use Illuminate\Http\Request;

class VacancyPostionController extends Controller
{
    public function index()
    {
        $positions = VacancyLevel::latest()->paginate(10);

        return view('admin.vacancy.position.index', compact('positions'));
    }

    public function create()
    {
        return view('admin.vacancy.position.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        VacancyLevel::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.vacancy.position.index')->withMessage(__('Vacancy Level created successfully'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $position = VacancyLevel::find($id);
        return view('admin.vacancy.position.edit', compact('position'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $position = VacancyLevel::find($id);
        $position->update([
            'name' => $request->name
        ]);
        return redirect()->route('admin.vacancy.position.index')->withMessage(__('Vacancy Level updated successfully'));
    }

    public function destroy($id)
    {
        $position = VacancyLevel::find($id);
        $position->delete();
        return redirect()->route('admin.vacancy.position.index')->withMessage(__('Vacancy Level deleted successfully'));
    }
}
