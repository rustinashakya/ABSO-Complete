<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::get();
        return view('admin.designation.index', compact('designations'));
    }

    public function create()
    {
        return view('admin.designation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        Designation::create($request->all());
        return redirect()->route('admin.designation.index')->withMessage('Designation created Successfully!');
    }

    public function edit($id)
    {
        $designation = Designation::findOrFail($id);
        return view('admin.designation.edit', compact('designation'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]); 
        $designation = Designation::findOrFail($id);
        $designation->update($request->all());
        return redirect()->route('admin.designation.index')->withMessage('Designation updated Successfully!');
    }

    public function destroy($id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();
        return redirect()->route('admin.designation.index')->withMessage('Designation deleted Successfully!');
    }
}
