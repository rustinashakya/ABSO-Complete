<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fun;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class FunController extends Controller
{
    public function index()
    {
        $funs = Fun::get();

        return view('admin.fun.index', compact('funs'));
    }

    public function create()
    {
        return view('admin.fun.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255']
        ]);

        Fun::create([
            'title'=>$request->title
        ]);

        return redirect(route('admin.fun.index'))->withMessage("Fun Fact Added Successfully");
    }

    public function edit($id)
    {
        $fun = Fun::findOrFail($id);

        return view('admin.fun.edit', compact('fun'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255']
        ]);

        $fun  = Fun::findOrFail($id);

        $fun->update([
            'title' => $request->title
        ]);

        return redirect(route('admin.fun.index'))->withMessage('Fun Fact Updated Successfully');
    }

    public function destroy($id)
    {
        $fun  = Fun::findOrFail($id);
        $fun->delete();

        return back()->withMessage("Fun Fact Deleted Successfully");
    }
}
